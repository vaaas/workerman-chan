<?php

namespace Lib\DependencyInjection;

use Closure;

interface IContainer {
	/**
	 * @template T of object
	 * @param class-string<T> $class
	 * @return T
	 */
	public function construct(string $class): object;

	public function call(Closure $f): mixed;

	/**
	 * @param class-string $interface
	 * @param class-string $implementation
	 */
	public function register(string $interface, string $implementation): IContainer;

	/**
	 * @template T of object
	 * @param class-string<T> $class
	 * @return IContainer
	 */
	public function add(string $class, object $instance): IContainer;
}
