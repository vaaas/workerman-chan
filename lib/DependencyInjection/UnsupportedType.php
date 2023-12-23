<?php

namespace Lib\DependencyInjection;

use Exception;
use Throwable;

final class UnsupportedType extends Exception {
	public function __construct(string $name, int $code = 0, ?Throwable $previous = null) {
		parent::__construct("Intersection and union types are not supported for $name", $code, $previous);
	}
}
