<?php
namespace Lib;

use ArrayIterator;
use IteratorAggregate;
use JsonSerializable;
use Traversable;

/**
 * @template T
 * @implements IteratorAggregate<int, T>
 */
class Generator implements IteratorAggregate, JsonSerializable {
	/** @param Traversable<int, T> $xs */
	public function __construct(
		public Traversable $xs
	) {}

	/**
	 * @template X
	 * @param iterable<int, X> $xs
	 * @return Generator<X>
	 */
	public static function from(iterable $xs): Generator {
		return new Generator(is_array($xs) ? new ArrayIterator($xs) : $xs);
	}

	/** @return Traversable<int, T> */
	public function getIterator(): Traversable {
		return $this->xs;
	}

	/**
	 * @template U
	 * @param callable(T): U $f
	 * @return Generator<U>
	 */
	public function map(callable $f): Generator {
		return new Generator((function () use ($f) {
			foreach ($this as $x)
				yield $f($x);
		})());
	}

	/**
	 * @template U
	 * @param callable(T): iterable<int, U> $f
	 * @return Generator<U>
	 */
	public function bind(callable $f): Generator {
		return new Generator((function () use ($f) {
			foreach ($this as $x)
				yield from $f($x);
		})());
	}

	/**
	 * @param callable(T): bool $f
	 * @return Generator<T>
	 */
	public function filter(callable $f): Generator {
		return new Generator((function () use ($f) {
			foreach ($this as $x)
				if ($f($x))
					yield $x;
		})());
	}

	/** @return Arr<T> */
	public function materialise(): Arr {
		return new Arr($this->toArray());
	}

	/** @return array<int, T> */
	public function toArray(): array {
		return iterator_to_array($this);
	}

	/** @return array<int, T> */
	public function jsonSerialize(): array {
		return $this->toArray();
	}

	/** @param callable(T): void $f */
	public function each(callable $f): void {
		foreach ($this as $x)
			$f($x);
	}

	/**
	 * @template X
	 * @param callable(): ?X $f
	 * @return Generator<X>
	 */
	public static function repeatedly(callable $f): Generator {
		return new Generator((function () use ($f) {
			for ($x = $f(); $x !== null; $x = $f())
				yield $x;
		})());
	}
}
