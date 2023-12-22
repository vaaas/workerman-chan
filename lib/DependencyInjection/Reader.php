<?php
namespace Lib;

use IContainer;
use Lib\DependencyInjection\Container;

/** @template T */
class Reader {
	/** @var callable */
	private $f;

	/** @var IContainer */
	private $container;

	/** @param callable $f */
	public function __construct($f, ?IContainer $container) {
		$this->f = $f;
		$this->container = $container ?? Container::getInstance();
	}

	/** @return T */
	public function run(): mixed {
		return $this->container->call($this->f);
	}

	/**
	 * @template U
	 * @param callable(T): U $f
	 * @return Reader<U>
	 */
	public function map(callable $f): Reader {
		return new Reader(fn() => $f($this->run()), $this->container);
	}

	/**
	 * @template U
	 * @param callable(T): Reader<U> $f
	 * @return Reader<U>
	 */
	public function bind(callable $f): Reader {
		return new Reader(fn() => $f($this->run())->run(), $this->container);
	}
}
