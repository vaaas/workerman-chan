<?php

interface IContainer {
	/**
	 * @template T of object
	 * @param class-string<T> $class
	 * @return T
	 */
	public function construct(string $class): object;

	public function call(callable $f): mixed;

	public static function getInstance(): IContainer;

	/**
	 * @param class-string $interface
	 * @param class-string $implementation
	 */
	public function register(string $interface, string $implementation): IContainer;
}
