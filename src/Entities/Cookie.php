<?php

namespace App\Entities;
use App\Entities\User;
use App\Exceptions\HashException;
use Exception;
use JsonSerializable;
use Lib\Option\IOption;
use Lib\Option\Nothing;
use Lib\Option\Some;

class Cookie implements JsonSerializable {
	private static string $cipher = 'aes-256-gcm';

	public function __construct(public int $id, public bool $is_admin) {}

	public static function forUser(User $user): Cookie {
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
		$encoded = json_encode($this);

		if ($encoded === false)
			throw new Exception('Error encoding cookie');

		$encrypted = openssl_encrypt(
			$encoded,
			self::$cipher,
			$passphrase,
		);

		if ($encrypted === false)
			throw new HashException();
		else
			return $encrypted;
	}

	/** @return IOption<Cookie> */
	public static function decode(string $encrypted, string $passphrase): IOption {
		$decrypted = openssl_decrypt(
			$encrypted,
			self::$cipher,
			$passphrase,
		);
		if ($decrypted === false)
			/** @var Nothing<Cookie> */
			return new Nothing();
		$parsed = json_decode($decrypted, true);
		if (!self::validate($parsed))
			/** @var Nothing<Cookie> */
			return new Nothing();
		else
			return new Some(new Cookie($parsed['id'], $parsed['is_admin']));
	}

	/** @phpstan-assert-if-true array{id: int, is_admin: bool} $x */
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
