<?php

namespace App;

use App\Migrations\_00001_Initial;
use App\Migrations\_00002_Seed;
use Lib\Database\Database as BaseDatabase;

class Database extends BaseDatabase {
	public function __construct(
		// Config $config
	) {
		parent::__construct('sqlite::memory:');
		// parent::__construct("sqlite:{$config->db->filename}");

		$this->migrate(
			_00001_Initial::class,
			_00002_Seed::class,
		);
	}
}
