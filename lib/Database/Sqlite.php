<?php

namespace Lib\Database;

use Lib\Arr;
use Lib\Database\IDatabase;
use Lib\Database\QueryException;
use SQLite3;

class Sqlite implements IDatabase {
	private SQLite3 $db;

	public function __construct(string $filename) {
		$this->db = new SQLite3($filename);
	}

	public function query(string $query): Arr {
		$cursor = $this->db->query($query);
		if ($cursor === false)
			throw new QueryException($query);
		$results = new Arr();
		$row = $cursor->fetchArray();
		while ($row !== false) {
			$results->add($row);
			$row = $cursor->fetchArray();
		}
		return $results;
	}

	/** @param class-string<IMigration> $migrations */
	public function migrate(string ...$migrations): void {
		$this->query('create table if not exists migrations (migration text primary key)');
		/** @var Arr<class-string<IMigration>> */
		$existing = $this->query('select migrations.migration from migrations');
		if ($existing->empty())
			return;
		$missing = Arr::from($migrations)->filter($existing->has(...));
		foreach ($missing as $migration) {
			$migration::run($this);
			$this->query("insert into migrations values ($migration)");
		}
	}

	public static function escape(string $x): string {
		return SQLite3::escapeString($x);
	}
}
