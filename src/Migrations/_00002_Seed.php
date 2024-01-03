<?php

namespace App\Migrations;

use App\Entities\Password;
use Lib\Database\IDatabase;
use Lib\Database\IMigration;

class _00002_Seed implements IMigration {
	public static function run(IDatabase $db): void {
		$password = Password::hash('test')->password;
		$db->exec("
			insert into users (name, email, password, is_admin)
			values (
				'admin',
				'test@example.com',
				'$password',
				1
			)
		");
	}
}
