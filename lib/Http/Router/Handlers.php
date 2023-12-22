<?php

namespace Lib\Http\Router;

use Closure;
use Lib\Http\InvalidVerbException;
use Workerman\Protocols\Http\Request;

final class Handlers {
	/**
	 * @param Closure(Request): mixed $GET
	 * @param Closure(Request): mixed $HEAD
	 * @param Closure(Request): mixed $POST
	 * @param Closure(Request): mixed $PUT
	 * @param Closure(Request): mixed $DELETE
	 * @param Closure(Request): mixed $PATCH
	 * @param Closure(Request): mixed $OPTIONS
	 * @param Closure(Request): mixed $CONNECT
	 * @param Closure(Request): mixed $TRACE
	 */
	public function __construct(
		public ?Closure $GET,
		public ?Closure $HEAD,
		public ?Closure $POST,
		public ?Closure $PUT,
		public ?Closure $DELETE,
		public ?Closure $PATCH,
		public ?Closure $OPTIONS,
		public ?Closure $CONNECT,
		public ?Closure $TRACE,
	) {}

	public static function of(string $verb, Closure $fun): Handlers {
		switch ($verb) {
			case 'GET':
				return new Handlers($fun, null, null, null, null, null, null, null, null);

			case 'HEAD':
				return new Handlers(null, $fun, null, null, null, null, null, null, null);

			case 'POST':
				return new Handlers(null, null, $fun, null, null, null, null, null, null);

			case 'PUT':
				return new Handlers(null, null, null, $fun, null, null, null, null, null);

			case 'DELETE':
				return new Handlers(null, null, null, null, $fun, null, null, null, null);

			case 'PATCH':
				return new Handlers(null, null, null, null, null, $fun, null, null, null);

			case 'OPTIONS':
				return new Handlers(null, null, null, null, null, null, $fun, null, null);

			case 'CONNECT':
				return new Handlers(null, null, null, null, null, null, null, $fun, null);

			case 'TRACE':
				return new Handlers(null, null, null, null, null, null, null, null, $fun);

			default:
				throw new InvalidVerbException($verb);
		}
	}

	public function set(string $verb, Closure $fun): Handlers {
		switch ($verb) {
			case 'GET':
				$this->GET = $fun;
				return $this;

			case 'HEAD':
				$this->HEAD = $fun;
				return $this;

			case 'POST':
				$this->POST = $fun;
				return $this;

			case 'PUT':
				$this->PUT = $fun;
				return $this;

			case 'DELETE':
				$this->DELETE = $fun;
				return $this;

			case 'PATCH':
				$this->PATCH = $fun;
				return $this;

			case 'OPTIONS':
				$this->OPTIONS = $fun;
				return $this;

			case 'CONNECT':
				$this->CONNECT = $fun;
				return $this;

			case 'TRACE':
				$this->TRACE = $fun;
				return $this;

			default:
				throw new InvalidVerbException($verb);
		}
	}
}
