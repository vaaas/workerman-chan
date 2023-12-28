<?php

use Lib\Arr;
use PHPUnit\Framework\TestCase;

final class ArrTest extends TestCase {
	public function testArrContainsEntries() {
		$entries = [1, 2, 3];
		$arr = Arr::from($entries);
		$this->assertSame($entries, $arr->toArray());
	}

	public function testIterator() {
		$entries = [1, 2, 3];
		$arr = iterator_to_array(Arr::from($entries)->getIterator());
		$this->assertSame($entries, $arr);
	}

	public function testMap() {
		$arr = Arr::from([1, 2, 3])->map(fn($x) => [$x]);
		$this->assertSame(
			[[1], [2], [3]],
			$arr->toArray(),
		);
	}

	public function testCount() {
		$this->assertEquals(
			3,
			Arr::from([1, 2, 3])->count(),
		);
	}

	public function testEmpty() {
		$this->assertTrue(Arr::from([])->empty());
		$this->assertFalse(Arr::from([1])->empty());
	}

	public function testHas() {
		$arr = Arr::from([1, 2, 3]);
		$this->assertTrue($arr->has(1));
		$this->assertFalse($arr->has(4));
	}

	public function testFirst() {
		$this->assertEquals(1, Arr::from([1, 2, 3])->first());
		$this->assertEquals(null, Arr::from([])->first());
	}
}
