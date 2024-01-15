<?php
namespace Lib\Option;

use Exception;

/** @template T */
abstract class Option {
	/**
	 * @template X
	 * @param ?X $x
	 * @return Option<X>
	 */
	public static function from(mixed $x): Option {
		if (is_null($x))
			/** @var Nothing<X> */
			return new Nothing();
		else
			return new Some($x);
	}

	/**
	 * @template U
	 * @param callable(T): U $f
	 * @return Option<U>
	 */
	abstract public function map(callable $f): Option;

	/**
	 * @template U
	 * @param callable(T): Option<U> $f
	 * @return Option<U>
	 */
	abstract public function bind(callable $f): Option;

	/**
	 * @template U
	 * @param U $d
	 * @return T|U
	 */
	abstract public function fold(mixed $d): mixed;

	/** @return ?T */
	abstract public function unwrap(): mixed;

	/**
	 * @param ?callable(): Exception $f
	 * @return T
	 */
	abstract public function getOrThrow(?callable $f = null): mixed;

	/**
	 * @param callable(): void $nothing
	 * @param callable(T): void $something
	 */
	abstract public function each(callable $nothing, callable $something): void;

	/**
	 * @template A
	 * @template B
	 * @param callable(): A $nothing
	 * @param callable(T): B $something
	 * @return A | B
	 */
	abstract public function match(callable $nothing, callable $something): mixed;
}
