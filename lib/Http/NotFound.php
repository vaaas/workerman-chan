<?php
namespace Lib\Http;

use Exception;
use Throwable;

class NotFound extends Exception {
	public function __construct(string $message = '', int $code = 404, ?Throwable $previous = null) {
		parent::__construct($message, $code, $previous);
	}
}
