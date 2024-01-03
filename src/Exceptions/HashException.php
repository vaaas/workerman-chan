<?php
namespace App\Exceptions;

use Exception;
use Throwable;

class HashException extends Exception {
	public function __construct(string $message = 'Could not hash password', int $code = 500, ?Throwable $previous = null) {
		parent::__construct($message, $code, $previous);
	}
}
