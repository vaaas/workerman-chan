<?php
namespace Lib;

use ArrayIterator;
use IteratorAggregate;
use Traversable;

/**
 * @template K of string
 * @implements IteratorAggregate of <int, K>
 */
class SSet implements IteratorAggregate {
	/** @param array<string, true> $entries */
	public function __construct(public array $entries = []) {}

	public function getIterator(): Traversable {
		return new ArrayIterator($this->toArray());
	}

	public function add(string $x): self {
		$this->entries[$x] = true;
		return $this;
	}

	public function delete(string $x): self {
		unset($this->entries[$x]);
		return $this;
	}

	public function has(string $x): bool {
		return array_key_exists($x, $this->entries);
	}

	/** @return string[] */
	public function toArray(): array {
		return array_keys($this->entries);
	}

	public function empty(): bool {
		return count($this->entries) === 0;
	}

	public function size(): int {
		return count($this->entries);
	}

	public function join(string $d): string {
		return implode($d, $this->toArray());
	}
}
