<?php

namespace Lib\Http;

use Lib\Arr;
use Lib\Http\Router\Route;
use Lib\Http\NotFound;
use Lib\Http\InvalidVerbException;
use Lib\Http\MethodNotAllowed;
use Workerman\Protocols\Http\Request;

class Router {
	/** @param Arr<Route> $routes */
	public function __construct(
		public Arr $routes = new Arr()
	) {}

	/** @param Arr<Route> $routes */
	public static function construct(Arr $routes = new Arr()): Router {
		return new Router($routes);
	}

	public function get(string $test, callable $handler): Router {
		return $this->add($test, 'GET', $handler);
	}

	public function head(string $test, callable $handler): Router {
		return $this->add($test, 'HEAD', $handler);
	}

	public function post(string $test, callable $handler): Router {
		return $this->add($test, 'POST', $handler);
	}

	public function put(string $test, callable $handler): Router {
		return $this->add($test, 'PUT', $handler);
	}

	public function delete(string $test, callable $handler): Router {
		return $this->add($test, 'DELETE', $handler);
	}

	public function patch(string $test, callable $handler): Router {
		return $this->add($test, 'PATCH', $handler);
	}

	public function options(string $test, callable $handler): Router {
		return $this->add($test, 'OPTIONS', $handler);
	}

	public function connect(string $test, callable $handler): Router {
		return $this->add($test, 'CONNECT', $handler);
	}

	public function trace(string $test, callable $handler): Router {
		return $this->add($test, 'TRACE', $handler);
	}

	public function add(string $test, string $verb, callable $handler): Router {
		$route = $this->routes->find(fn($x) => $x->test === $test);
		if ($route)
			$route->handlers->set($verb, $handler);
		else
			$this->routes->add(new Route($test, $verb, $handler));
		return $this;
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
