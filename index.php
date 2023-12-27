<?php
require_once __DIR__ . '/vendor/autoload.php';

use App\App;
use App\Database;
use Lib\Database\IDatabase;
use Lib\DependencyInjection\Container;

Container::construct()
	->register(IDatabase::class, Database::class)
	->get(App::class);
