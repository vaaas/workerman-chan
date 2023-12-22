<?php

namespace Lib\Http\Router;

use Lib\Http\InvalidVerbException;
use Workerman\Protocols\Http\Request;

final class Handlers {
	/**
	 * @param ?callable(Request): mixed $GET
	 * @param ?callable(Request): mixed $HEAD
	 * @param ?callable(Request): mixed $POST
	 * @param ?callable(Request): mixed $PUT
	 * @param ?callable(Request): mixed $DELETE
	 * @param ?callable(Request): mixed $PATCH
	 * @param ?callable(Request): mixed $OPTIONS
	 * @param ?callable(Request): mixed $CONNECT
	 * @param ?callable(Request): mixed $TRACE
	 */
	public function __construct(
		public $GET,
		public $HEAD,
		public $POST,
		public $PUT,
		public $DELETE,
		public $PATCH,
		public $OPTIONS,
		public $CONNECT,
		public $TRACE,
	) {}

	public static function of(string $verb, callable $fun): Handlers {
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

	public function set(string $verb, callable $fun): Handlers {
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
