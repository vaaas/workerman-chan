<?php
namespace Lib\Database;
interface IMigration {
	public static function run(IDatabase $db): void;
}
