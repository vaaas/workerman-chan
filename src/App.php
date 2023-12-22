<?php
namespace App;

use Lib\Http\Router;
use Lib\Http\Server;
use Workerman\Protocols\Http\Request;
use Workerman\Protocols\Http\Response;
use Workerman\Worker;

final class App {
	public Server $httpServer;

	public function __construct() {
		$this->httpServer = new Server('0.0.0.0', 8000, 4, $this->router()->route(...));
	}

	private function router(): Router {
		return Router::make()
			->get('/', function (Request $request) {
				return 'Hello, world!';
			});
	}

	public static function start(): App {
		$app = new App();
		Worker::runAll();
		return $app;
	}
}
