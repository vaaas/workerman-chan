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
}
