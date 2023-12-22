<?php

namespace Lib\Http;

use Lib\Http\Router\Route;
use Lib\Http\NotFound;
use Lib\Http\InvalidVerbException;
use Lib\Http\MethodNotAllowed;
use Workerman\Protocols\Http\Request;

final class Router {
	/** @param array<Route> $routes */
	public function __construct(
		public array $routes
	) {}

	/** @param array<Route> $routes */
	public static function construct(array $routes = []): Router {
		return new Router($routes);
	}

	/** @param callable(Request): mixed $handler */
	public function get(string $test, callable $handler): Router {
		return $this->add($test, 'GET', $handler);
	}

	/** @param callable(Request): mixed $handler */
	public function head(string $test, callable $handler): Router {
		return $this->add($test, 'HEAD', $handler);
	}

	/** @param callable(Request): mixed $handler */
	public function post(string $test, callable $handler): Router {
		return $this->add($test, 'POST', $handler);
	}

	/** @param callable(Request): mixed $handler */
	public function put(string $test, callable $handler): Router {
		return $this->add($test, 'PUT', $handler);
	}

	/** @param callable(Request): mixed $handler */
	public function delete(string $test, callable $handler): Router {
		return $this->add($test, 'DELETE', $handler);
	}

	/** @param callable(Request): mixed $handler */
	public function patch(string $test, callable $handler): Router {
		return $this->add($test, 'PATCH', $handler);
	}

	/** @param callable(Request): mixed $handler */
	public function options(string $test, callable $handler): Router {
		return $this->add($test, 'OPTIONS', $handler);
	}

	/** @param callable(Request): mixed $handler */
	public function connect(string $test, callable $handler): Router {
		return $this->add($test, 'CONNECT', $handler);
	}

	/** @param callable(Request): mixed $handler */
	public function trace(string $test, callable $handler): Router {
		return $this->add($test, 'TRACE', $handler);
	}

	/** @param callable(Request): mixed $handler */
	public function add(string $test, string $verb, callable $handler): Router {
		$route = $this->find($test);
		if ($route)
			$route->handlers->set($verb, $handler);
		else
			$this->push(new Route($test, $verb, $handler));
		return $this;
	}

	private function find(string $test): ?Route {
		foreach ($this->routes as $route) {
			if ($route->test === $test)
				return $route;
		}
		return null;
	}

	private function push(Route $route): void {
		array_push($this->routes, $route);
	}

	public function route(Request $request): mixed {
		/** @var string */
		$path = $request->path() ?? '';

		foreach ($this->routes as $route) {
			$matches = $route->match($path);
			if (is_null($matches))
				continue;
			$verb = $request->method();
			if (!property_exists($route->handlers, $verb))
				return new InvalidVerbException($verb);
			else if (!$route->handlers->$verb)
				return new MethodNotAllowed('Method not allowed: ' . $verb);
			else
				return ($route->handlers->$verb)($request, ...$matches);
		}

		return new NotFound('Not found: '. $path);
	}

	public function __invoke(Request $request): mixed {
		return $this->route($request);
	}
}
