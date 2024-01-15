<?php

namespace Lib;

use ArrayIterator;
use IteratorAggregate;
use Lib\Option\IOption;
use Lib\Option\Nothing;
use Lib\Option\Option;
use Lib\Option\Some;
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

	/** @return Traversable<int, T> */
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
	 * @return IOption<T>
	 */
	public function find(callable $f): IOption {
		foreach ($this as $x) {
			if ($f($x))
				return new Some($x);
		}
		/** @var Nothing<T> */
		return new Nothing();
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

	public function hasNot(mixed $x): bool {
		return !in_array($x, $this->entries);
	}

	/** @return T[] */
	public function toArray(): array {
		return $this->entries;
	}

	/** @return IOption<T> */
	public function first(): IOption {
		return Option::from($this->entries[0]);
	}

	public function join(string $d = ''): string {
		return implode($d, $this->entries);
	}

	public function unique(): Arr {
		return new Arr(array_values(array_unique($this->entries)));
	}

	/** @param callable(T): void $f */
	public function each(callable $f): void {
		foreach ($this as $x)
			$f($x);
	}
}
