<?php

namespace Lib\Database;

use Lib\Arr;
use Lib\Database\IMigration;
use Lib\Generator;

interface IDatabase {
	/** @return Arr<array<string, mixed>> */
	public function query(string $query): Arr;

	/** @return Generator<array<string, mixed>> */
	public function stream(string $query): Generator;

	public function exec(string $query): void;

	/** @param class-string<IMigration> $migrations */
	public function migrate(string ...$migrations): void;

	public static function escape(string $x): string;
}
