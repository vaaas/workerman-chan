<?php
namespace Lib;

class Path {
	public static function extension(string $pathname): string {
		return pathinfo($pathname, PATHINFO_EXTENSION);
	}
}
