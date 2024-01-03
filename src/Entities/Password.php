<?php

namespace App\Entities;

use App\Exceptions\HashException;
use Stringable;

class Password implements Stringable {
	public function __construct(public string $password) {}

	public static function hash(string $raw): Password {
		$hashed = password_hash($raw, PASSWORD_BCRYPT, [ 'cost' => 10 ]);
		if (!is_string($hashed))
			throw new HashException();
		return new Password($hashed);
	}

	public function match(string $raw): bool {
		return password_verify($raw, $this->password);
	}

	public function __toString(): string {
		return $this->password;
	}
}
