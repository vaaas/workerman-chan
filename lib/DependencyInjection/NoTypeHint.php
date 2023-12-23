<?php

namespace Lib\DependencyInjection;

use Exception;
use Throwable;

class NoTypeHint extends Exception {
	public function __construct(string $name, int $code = 0, ?Throwable $previous = null) {
		parent::__construct("No type hint found for $name", $code, $previous);
	}
}
