<?php
namespace App;

use App\Controllers\IndexController;
use App\Controllers\StaticController;
use Lib\Http\Router as BaseRouter;
use Workerman\Protocols\Http\Request;

class Router extends BaseRouter {
	public function __construct(
		IndexController $indexController,
		StaticController $staticController,
	) {
		parent::__construct();

		$this
			->get('/', [$indexController, 'index'])
			->get('/favicon.ico', [$staticController, 'serve']);
	}
}
