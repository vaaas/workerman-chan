<?php
namespace Lib\Option;

/**
 * @template T
 * @implements IOption<T>
 */
class Nothing implements IOption {
	/**
	 * @template U
	 * @param callable(T): U $f
	 * @return Nothing<U>
	 */
	public function map(callable $f): Nothing {
		return $this;
	}

	/**
	 * @template U
	 * @param callable(T): IOption<U> $f
	 * @return Nothing<U>
	 */
	public function bind(callable $f): Nothing {
		return $this;
	}

	public function fold(mixed $x): mixed {
		return $x;
	}

	/** @return null */
	public function unwrap(): mixed {
		return null;
	}

	public function each($f, $_): void {
		$f();
	}

	public function match($f, $_): mixed {
		return $f();
	}
}
