<?php

namespace App\Entities;
use App\Entities\User;
use JsonSerializable;

class Cookie implements JsonSerializable {
	public int $id;
	public bool $is_admin;
	private static string $cipher = 'aes-256-gcm';

	public function __construct(public int $id, public bool $is_admin) {}

	public static function forUser(User $user) {
		return new Cookie($user->id, $user->is_admin);
	}

	/** @return array{id: int, is_admin: bool} */
	public function jsonSerialize(): array {
		return [
			'id' => $this->id,
			'is_admin' => $this->is_admin,
		];
	}

	public function encode(string $passphrase): string {
		openssl_encrypt(
			json_encode($this),
			self::$cipher,
			$passphrase,
		);
	}

	public static function decode(string $encrypted, string $passphrase): ?Cookie {
		$decrypted = openssl_decrypt(
			$encrypted,
			self::$cipher,
			$passphrase,
		);
		if ($decrypted === false)
			return null;
		$parsed = json_decode($decrypted, true);
		if (!self::validate($parsed))
			return false;
		else
			return new Cookie($parsed['id'], $parsed['is_admin']);
	}

	/** @phpstan-assert array{id: int, is_admin: bool} $x */
	private static function validate(mixed $x): bool {
		if (!is_array($x))
			return false;
		if (!array_key_exists('id', $x))
			return false;
		if (!is_int($x['id']))
			return false;
		if (!array_key_exists('is_admin', $x))
			return false;
		if (!is_bool($x['is_admin']))
			return false;
		return true;
	}
}
