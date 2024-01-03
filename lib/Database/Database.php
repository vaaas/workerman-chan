<?php
namespace Lib\Database;

use Lib\Arr;
use Lib\Generator;
use PDO;
use ReflectionClass;

class Database implements IDatabase {
	private PDO $db;

	public function __construct(string $connection_string) {
		$this->db = new PDO($connection_string);
	}

	public function query(Statement $statement): Arr {
		return $statement->all($this->db);
	}

	public function stream(Statement $statement): Generator {
		return $statement->stream($this->db);
	}

	public function exec(Statement $statement): void {
			$statement->exec($this->db);
	}

	public function migrate(string ...$migrations): void {
		$this->exec(new Statement('create table if not exists migrations (migration text primary key)'));
		/** @var Arr<class-string<IMigration>> */
		$existing = $this->query(new Statement('select migrations.migration from migrations'));
		$missing = Arr::from($migrations)->filter($existing->hasNot(...));
		if ($missing->empty())
			return;
		foreach ($missing as $migration) {
			$short = (new ReflectionClass($migration))->getShortName();
			error_log('Running migration: ' . $short);
			$migration::run($this);
			$statement = new Statement("insert into migrations values (:migration)", [ 'migration' => $short ]);
			$this->exec($statement);
		}
	}
}
