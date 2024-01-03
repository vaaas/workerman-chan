<?php
namespace Lib\Option;

/**
 * @template T
 * @implements IOption<T>
 */
class Nothing implements IOption {
	public function map(callable $f): Nothing {
		return $this;
	}

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
}
