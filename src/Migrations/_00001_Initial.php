<?php

namespace App\Migrations;

use Lib\Database\IDatabase;
use Lib\Database\IMigration;

class _00001_Initial implements IMigration {
	public static function run(IDatabase $db): void {
		$db->query('create table boards (
			id integer primary key autoincrement,
			handle text unique not null,
			title text not null
		)');
	}
}
