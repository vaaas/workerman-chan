<?php
use Lib\SMap;
use PHPUnit\Framework\TestCase;

final class SMapTest extends TestCase {
	public function testHas(): void {
		$map = new SMap(['a' => 1]);
		$this->assertTrue($map->has('a'));
		/** @phpstan-ignore-next-line */
		$this->assertFalse($map->has('b'));
	}

	public function testGet(): void {
		/** @var SMap<string, int> */
		$map = new SMap(['a' => 1]);
		$this->assertEquals(1, $map->get('a'));
		$this->assertEquals(null, $map->get('b'));
	}

	public function testDelete(): void {
		$map = new SMap(['a' => 1]);
		$map->delete('a');
		$this->assertEquals(null, $map->get('a'));
	}

	public function testSet(): void {
		/** @var SMap<string, int> */
		$map = new SMap(['a' => 1]);
		$this->assertFalse($map->has('b'));
		$map->set('b', 2);
		$this->assertTrue($map->has('b'));
	}

	public function testIterator(): void {
		$entries = ['a' => 1];
		$copy = iterator_to_array((new SMap($entries))->getIterator());
		$this->assertEquals($entries, $copy);
	}
}
