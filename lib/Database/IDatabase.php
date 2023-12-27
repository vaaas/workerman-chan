<?php

namespace Lib\Database;

use Lib\Arr;
use Lib\Database\IMigration;

interface IDatabase {
	/** @return Arr<array<string, mixed>> */
	public function query(string $query): Arr;

	/** @param class-string<IMigration> $migrations */
	public function migrate(string ...$migrations): void;
}
