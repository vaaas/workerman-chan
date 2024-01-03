<?php

namespace App\Migrations;

use App\DataAccess\Queries\Users\Create;
use App\Entities\Password;
use App\Entities\User;
use Lib\Database\IDatabase;
use Lib\Database\IMigration;

class _00002_Seed implements IMigration {
	public static function run(IDatabase $db): void {
		Create
			::construct(new User(
				0,
				'admin',
				'test@example.com',
				Password::hash('test'),
				true,
			))
			->commit($db);
	}
}
