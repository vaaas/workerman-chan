<?php
namespace Lib\Database;

use Lib\Database\IDatabase;

interface IMigration {
	public static function run(IDatabase $db): void;
}
