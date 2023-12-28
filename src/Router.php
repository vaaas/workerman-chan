<?php
namespace App;

use App\Views\Frontpage;
use Lib\Http\Router as BaseRouter;
use Workerman\Protocols\Http\Request;
use Workerman\Protocols\Http\Response;

class Router extends BaseRouter {
	public function __construct(Config $config) {
		parent::__construct();

		$this
			->get('/', function (Request $request) use ($config) {
				return new Response(
					200,
					['content-type' => 'text/html'],
					(new Frontpage($config->title))->render()
				);
			})
			->get('/favicon.ico', function (Request $request) {
				return 'favicon';
			});
	}
}
