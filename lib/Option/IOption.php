<?php

namespace Lib\Option;

/** @template T */
interface IOption {
	/**
	 * @template U
	 * @param callable(T): U $f
	 * @return IOption<U>
	 */
	public function map(callable $f): IOption;

	/**
	 * @template U
	 * @param callable(T): IOption<U> $f
	 * @return IOption<U>
	 */
	public function bind(callable $f): IOption;

	/**
	 * @param T $d
	 * @return T
	 */
	public function fold(mixed $d): mixed;

	/** @return ?T */
	public function unwrap(): mixed;

	/**
	 * @param callable(): void $nothing
	 * @param callable(T): void $something
	 */
	public function each(callable $nothing, callable $something): void;

	/**
	 * @template A
	 * @template B
	 * @param callable(): A $nothing
	 * @param callable(T): B $something
	 * @return A | B
	 */
	public function match(callable $nothing, callable $something): mixed;
}
