<?php
namespace App;

use Lib\Http\Server;
use App\Config;
use App\Router;

class WebServer extends Server {
	public function __construct(Config $config, Router $router) {
		parent::__construct($config->web->host, $config->web->port, $config->web->processes, $router);
	}
}
