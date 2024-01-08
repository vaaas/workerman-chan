<?php

namespace App\Migrations;

use App\DataAccess\Queries\Users;
use App\DataAccess\Queries\Boards;
use App\Entities\Board;
use App\Entities\Password;
use App\Entities\User;
use Lib\Database\IDatabase;
use Lib\Database\IMigration;

class _00002_Seed implements IMigration {
	public static function run(IDatabase $db): void {
		Users\Create
			::construct(new User(
				0,
				'admin',
				'test@example.com',
				Password::hash('test'),
				true,
			))
			->commit($db);

		Boards\Create
			::construct(new Board(
				0,
				'b',
				'random',
				'Anything goes!',
			))
			->commit($db);

		Boards\Create
			::construct(new Board(
				0,
				'a',
				'Anime & Manga',
				'Chinese cartoons',
			))
			->commit($db);
	}
}
