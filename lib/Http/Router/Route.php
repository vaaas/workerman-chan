<?php
namespace Lib\Http\Router;

use Lib\Http\Router\Handlers;
use Workerman\Protocols\Http\Request;

final class Route {
	public string $test;
	public Handlers $handlers;
	private string $regex;

	/** @param callable(Request): mixed $handler */
	public function __construct(
		string $test,
		string $verb,
		callable $handler,
	) {
		$this->test = $test;
		$this->handlers = Handlers::of($verb, $handler);
		$this->regex = self::regex($test);
	}

	/** @return string[]|null */
	public function match(string $url): ?array {
		$matches = [];
		$result = preg_match($this->regex, $url, $matches);
		if ($result === 1)
			return array_slice($matches, 1);
		else
			return null;
	}

	private static function regex(string $test): string {
		return '/^' . str_replace('*', '([^\/]+)', str_replace('/', '\/', $test)) . '$/';
	}
}
