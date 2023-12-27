<?php
namespace App;

use Lib\Http\Router as BaseRouter;
use Workerman\Protocols\Http\Request;

class Router extends BaseRouter {
	public function __construct() {
		parent::__construct();

		$this
			->get('/', function (Request $request) {
				return 'Hello, world!';
			})
			->get('/favicon.ico', function (Request $request) {
				return 'favicon';
			});
	}
}
