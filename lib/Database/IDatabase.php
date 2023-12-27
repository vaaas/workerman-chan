<?php

namespace Lib\Database;

use Lib\Arr;

interface IDatabase {
	/** @return Arr<array<string, mixed>> */
	public function query(string $query): Arr;
}
