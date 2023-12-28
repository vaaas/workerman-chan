<?php

namespace App;

use App\Migrations\_00001_Initial;
use Lib\Database\Sqlite;

class Database extends Sqlite {
	public function __construct(Config $config) {
		parent::__construct($config->db->filename);

		$this->migrate(
			_00001_Initial::class,
		);
	}
}
