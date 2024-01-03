<?php

use Lib\Arr;
use PHPUnit\Framework\TestCase;

final class ArrTest extends TestCase {
	public function testArrContainsEntries(): void {
		$entries = [1, 2, 3];
		$arr = Arr::from($entries);
		$this->assertSame($entries, $arr->toArray());
	}

	public function testIterator(): void {
		$entries = [1, 2, 3];
		$arr = iterator_to_array(Arr::from($entries)->getIterator());
		$this->assertSame($entries, $arr);
	}

	public function testMap(): void {
		$arr = Arr::from([1, 2, 3])->map(fn($x) => [$x]);
		$this->assertSame(
			[[1], [2], [3]],
			$arr->toArray(),
		);
	}

	public function testCount(): void {
		$this->assertEquals(
			3,
			Arr::from([1, 2, 3])->count(),
		);
	}

	public function testEmpty(): void {
		$this->assertTrue(Arr::from([])->empty());
		$this->assertFalse(Arr::from([1])->empty());
	}

	public function testHas(): void {
		$arr = Arr::from([1, 2, 3]);
		$this->assertTrue($arr->has(1));
		$this->assertFalse($arr->has(4));
	}

	public function testHasNot(): void {
		$arr = Arr::from([1, 2, 3]);
		$this->assertTrue($arr->hasNot(4));
		$this->assertFalse($arr->hasNot(1));
	}

	public function testFirst(): void {
		$this->assertEquals(1, Arr::from([1, 2, 3])->first()->unwrap());
		$this->assertEquals(null, Arr::from([])->first()->unwrap());
	}
}
