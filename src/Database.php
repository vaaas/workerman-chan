<?php

namespace App;

use Lib\Database\Sqlite;

class Database extends Sqlite {
	public function __construct() {
		parent::__construct(__DIR__ . '/db.sqlite3');
	}
}
