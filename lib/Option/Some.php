<?php
namespace Lib\Option;

/**
 * @template T
 * @implements IOption<T>
 */
class Some implements IOption {
	/** @param T $x */
	public function __construct(private mixed $x) {}

	/**
	 * @template U
	 * @param callable(T): U $f
	 * @return Some<U>
	 */
	public function map(callable $f): Some {
		return new Some($f($this->x));
	}

	public function bind(callable $f): IOption {
		return $f($this->x);
	}

	public function fold(mixed $x): mixed {
		return $this->x;
	}

	/** @return T */
	public function unwrap(): mixed {
		return $this->x;
	}

	public function each($_, $f): void {
		$f($this->x);
	}

	public function match($_, $f): mixed {
		return $f($this->x);
	}
}
