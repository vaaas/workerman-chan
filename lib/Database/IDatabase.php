<?php
namespace Lib\Database;

use Lib\Generator;
use Lib\Arr;

interface IDatabase {
	/** @return Arr<array<string, string|int|null>> */
	public function query(Statement $statement): Arr;

	/** @return Generator<array<string, string|int|null>> */
	public function stream(Statement $statement): Generator;

	public function exec(Statement $statement): void;

	/** @param class-string<IMigration> $migrations */
	public function migrate(string ...$migrations): void;
}
