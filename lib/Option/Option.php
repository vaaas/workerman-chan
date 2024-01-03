<?php
namespace Lib\Option;

final class Option {
	public static function from(mixed $x): IOption {
		if (is_null($x))
			return new Nothing();
		else
			return new Some($x);
	}
}
