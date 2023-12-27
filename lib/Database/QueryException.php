<?php

namespace Lib\Database;

use Exception;
use Throwable;

final class QueryException extends Exception {
	public function __construct(string $query, int $code = 0, ?Throwable $previous = null) {
		parent::__construct("Failed executing query: $query", $code, $previous);
	}
}
