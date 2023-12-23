<?php
namespace Lib\Http;

use Exception;
use Throwable;

final class MethodNotAllowed extends Exception {
	public function __construct(string $message = '', int $code = 405, ?Throwable $previous = null) {
		parent::__construct($message, $code, $previous);
	}
}
