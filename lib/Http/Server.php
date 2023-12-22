<?php
namespace Lib\Http;

use JsonSerializable;
use Stringable;
use Throwable;
use Workerman\Worker;
use Workerman\Connection\TcpConnection;
use Workerman\Protocols\Http\Request;
use Workerman\Protocols\Http\Response;

final class Server {
	private Worker $worker;

	/** @var callable(Request): mixed */
	private $request_handler;

	/** @param callable(Request): mixed $request_handler */
	public function __construct(string $host, int $port, int $processes, callable $request_handler) {
		$this->worker = new Worker("http://$host:$port");
		$this->worker->count = $processes;
		$this->worker->onMessage = $this->onMessage(...);
		$this->request_handler = $request_handler;
	}

	private function onMessage(TcpConnection $connection, Request $request): void {
		try {
			$response = ($this->request_handler)($request);
		} catch (Throwable $e) {
			$response = $e;
			error_log(self::errorLogString($e));
		}

		$connection->send(self::makeResponse($response));
	}

	private static function makeResponse(mixed $response): Response {
		if ($response instanceof Response)
			return $response;
		else if ($response instanceof JsonSerializable)
			return self::fromJson($response);
		else if ($response instanceof Throwable)
			return self::fromError($response);
		else if ($response instanceof Stringable)
			return new Response(200, ['content-type' => 'text/plain'], $response->__toString());
		else if (is_array($response))
			return self::fromJson($response);
		else if (is_string($response))
			return new Response(200, ['content-type' => 'text/plain'], $response);
		else if (is_numeric($response))
			return new Response(200, ['content-type' => 'text/plain'], strval($response));
		else {
			$msg = 'Invalid return type. Expected one of string, int, array, JsonSerializable, Stringable, Throwable, Response, got ' . self::typeName($response);
			error_log($msg);
			return new Response(500, ['content-type' => 'text/plain'], $msg);
		}
	}

	/** @param JsonSerializable|array<mixed> $response */
	private static function fromJson(JsonSerializable|array $response): Response {
		return new Response(200, ['content-type' => 'application/json'], self::safeJsonEncode($response));
	}

	private static function fromError(Throwable $error): Response {
		$code = $error->getCode();
		if ($code === 0)
			$code = 500;
		return new Response($code, ['content-type' => 'text/plain'], $error->getMessage());
	}

	private static function errorLogString(Throwable $error): string {
		return $error->getMessage() . ': ' . $error->getTraceAsString();
	}

	private static function typeName(mixed $x): string {
		if (is_object($x))
			return get_class($x);
		else
			return gettype($x);
	}

	private static function safeJsonEncode(mixed $x): string {
		$string = json_encode($x);
		if ($string === false)
			return 'null';
		else
			return $string;
	}
}
