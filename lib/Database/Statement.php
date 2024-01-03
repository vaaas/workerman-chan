<?php
namespace Lib\Database;

use Lib\Arr;
use Lib\Generator;
use PDO;
use PDOStatement;

class Statement {
	/** @param ?array<string, string|int> $params */
	public function __construct(private string $query, private ?array $params = null) {}

	private function prepare(PDO $db): PDOStatement {
		$statement = $db->prepare($this->query);
		if ($statement === false)
			throw new QueryException($this->query);
		else
			return $statement;
	}

	/** @return Arr<array<string, string|int|null>> */
	public function all(PDO $db): Arr {
		$statement = $this->prepare($db);
		$statement->execute($this->params);
		return Arr::from($statement->fetchAll(PDO::FETCH_ASSOC));
	}

	/** @return Generator<array<string, string|int|null>> */
	public function stream(PDO $db): Generator {
		$statement = $this->prepare($db);
		$statement->execute($this->params);
		return Generator::repeatedly(function() use ($statement) {
			/** @var false | array<string, string|int|null> */
			$row = $statement->fetch(PDO::FETCH_ASSOC);
			if ($row === false) return null;
			else return $row;
		});
	}

	public function exec(PDO $db): void {
		$statement = $this->prepare($db);
		$statement->execute($this->params);
	}

}
