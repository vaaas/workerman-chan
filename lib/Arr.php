<?php

namespace Lib;

use ArrayIterator;
use IteratorAggregate;
use Traversable;

/**
 * @template T
 * @implements IteratorAggregate<int, T>
 */
final class Arr implements IteratorAggregate {
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

	/** @param T $x */
	public function add(mixed $x): void {
		array_push($this->entries, $x);
	}

	/**
	 * @param callable(T): bool $f
	 * @return ?T
	 */
	public function find(callable $f): mixed {
		foreach ($this as $x) {
			if ($f($x))
				return $x;
		}
		return null;
	}

	public function count(): int {
		return count($this->entries);
	}

	public function empty(): bool {
		return $this->count() === 0;
	}

	/**
	 * @param callable(T): bool $f
	 * @return Arr<T>
	 */
	public function filter(callable $f): Arr {
		$xs = new Arr();
		foreach ($this as $x)
			if ($f($x))
				$xs->add($x);
		return $xs;
	}

	public function has(mixed $x): bool {
		return in_array($x, $this->entries);
	}
}
