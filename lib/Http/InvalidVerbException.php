<?php
namespace Lib\Http;

use Exception;
use Throwable;

final class InvalidVerbException extends Exception {
	public function __construct(string $verb = '', int $code = 400, ?Throwable $previous = null) {
		parent::__construct('Invalid HTTP Verb: ' . $verb, $code, $previous);
	}
}
