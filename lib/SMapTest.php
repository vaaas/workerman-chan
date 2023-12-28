<?php

use Lib\SMap;
use PHPUnit\Framework\TestCase;

final class SMapTest extends TestCase {
	public function testHas() {
		$map = new SMap(['1' => 1]);
		$this->assertTrue($map->has('1'));
		$this->assertFalse($map->has('2'));
	}

	public function testGet() {
		$map = new SMap(['1' => 1]);
		$this->assertEquals(1, $map->get('1'));
		$this->assertEquals(null, $map->get('2'));
	}

	public function testDelete() {
		$map = new SMap(['1' => 1]);
		$map->delete('1');
		$this->assertEquals(null, $map->get('1'));
	}

	public function testSet() {
		$map = new SMap(['1' => 1]);
		$this->assertFalse($map->has('2'));
		$map->set('2', 2);
		$this->assertTrue($map->has('2'));
	}

	public function testIterator() {
		$entries = ['1' => 1];
		$copy = iterator_to_array((new SMap($entries))->getIterator());
		$this->assertEquals($entries, $copy);
	}
}
