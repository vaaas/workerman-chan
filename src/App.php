<?php
namespace App;

use Workerman\Worker;

final class App {
	public function __construct(
		public WebServer $webServer,
	) {
		Worker::runAll();
	}
}
