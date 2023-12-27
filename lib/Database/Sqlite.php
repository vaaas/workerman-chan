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
}
