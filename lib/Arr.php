<?php

namespace Lib;

use ArrayIterator;
use IteratorAggregate;
use Traversable;

/**
 * @template T
 * @implements IteratorAggregate<int, T>
 */
class Arr implements IteratorAggregate {
	/**
	 * @template X
	 * @param X[] $entries
	 * @return Arr<X>
	 */
	public static function from(array $entries): Arr {
		return new Arr($entries);
	}

	/** @param array<int, T> $entries */
	public function __construct(
		private array $entries = []
	) {}

	public function getIterator(): Traversable {
		return new ArrayIterator($this->entries);
	}

	/**
	 * @template U
	 * @param callable(T): U $f
	 * @return Arr<U>
	 */
	public function map(callable $f): Arr {
		$xs = [];
		foreach ($this as $x)
			array_push($xs, $f($x));
		return new Arr($xs);
	}
}
