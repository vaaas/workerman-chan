<?php
namespace Lib\Option;

final class Option {
	/**
	 * @template T
	 * @param ?T $x
	 * @return IOption<T>
	 */
	public static function from(mixed $x): IOption {
		if (is_null($x))
			/** @var Nothing<T> */
			return new Nothing();
		else
			return new Some($x);
	}
}
