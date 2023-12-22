<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/src/routes.php';

use Workerman\Worker;
use Lib\Http\Server;

new Server('0.0.0.0', 8000, 4, $router);
Worker::runAll();
