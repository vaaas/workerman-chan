<?php
namespace App;

use Lib\HttpServer;
use Workerman\Protocols\Http\Response;
use Workerman\Worker;

final class App {
	public HttpServer $httpServer;

	public function __construct() {
		$this->httpServer = new HttpServer('0.0.0.0', 8000, 4, function ($requuest): Response {
			return new Response(200, [], 'Hello, world!');
		});
	}

	public static function start(): App {
		$app = new App();
		Worker::runAll();
		return $app;
	}
}
