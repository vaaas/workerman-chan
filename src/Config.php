<?php
namespace App;

class Config {
	public WebConfig $web;
	public DBConfig $db;
	public string $title;

	public function __construct() {
		$this->web = new WebConfig();
		$this->db = new DBConfig();
		$this->title = 'Workerman-chan';
	}
}

class WebConfig {
	public string $host;
	public int $port;
	public int $processes;

	public function __construct() {
		$this->host = '0.0.0.0';
		$this->port = 8000;
		$this->processes = 4;
	}
}

class DBConfig {
	public string $filename;

	public function __construct() {
		$this->filename = __DIR__ . '/db.sqlite3';
	}
}
