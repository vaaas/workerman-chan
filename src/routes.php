<?php
use Lib\Http\Router;
use Workerman\Protocols\Http\Request;

$router = Router::construct()
	->get('/', function (Request $request) {
		return 'Hello, world!';
	})
	->get('/favicon.ico', function (Request $request) {
		return 'favicon';
	});
