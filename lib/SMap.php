<?php

namespace Lib;

use ArrayIterator;
use IteratorAggregate;
use Lib\Option\Option;
use Traversable;

/**
 * @template K of string
 * @template V
 * @implements IteratorAggregate<K, V>
 */
final class SMap implements IteratorAggregate {
	/** @param array<K, V> $entries */
	public function __construct(
		private array $entries = []
	) {}

	/** @phpstan-assert-if-true K $k */
	public function has(string $k): bool {
		return array_key_exists($k, $this->entries);
	}

	/**
	 * @param K $k
	 * @return Option<V>
	 */
	public function get(string $k): Option {
		return Option::from(@$this->entries[$k]);
	}

	/**
	 * @param K $k
	 * @return V
	 */
	public function unsafeGet(string $k): mixed {
		return $this->entries[$k];
	}

	/** @param K $k */
	public function delete(string $k): void {
		unset($this->entries[$k]);
	}

	/**
	 * @param K $k
	 * @param V $v
	 */
	public function set(string $k, mixed $v): void {
		$this->entries[$k] = $v;
	}

	/** @return Traversable<K, V> */
	public function getIterator(): Traversable {
		return new ArrayIterator($this->entries);
	}

	/** @return Arr<array{K, V}> */
	public function entries(): Arr {
		$xs = [];
		foreach ($this as $k => $v)
			array_push($xs, [$k, $v]);
		return new Arr($xs);
	}
}
