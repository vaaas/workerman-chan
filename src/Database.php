<?php

namespace App;

use App\Migrations\_00001_Initial;
use Lib\Database\Sqlite;

class Database extends Sqlite {
	public function __construct() {
		parent::__construct(getcwd() . '/db.sqlite3');

		$this->migrate(
			_00001_Initial::class,
		);
	}
}
