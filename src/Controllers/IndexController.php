<?php

namespace App\Controllers;

use App\Config;
use App\DataAccess\Repositories\BoardRepository;
use App\Views\Frontpage;
use Workerman\Protocols\Http\Response;

final class IndexController {
	public function __construct(
		private Config $config,
		private BoardRepository $boards,
	) {}

	public function index(): Response {
		return new Response(
			200,
			['Content-Type' => 'text/html'],
			Frontpage::construct($this->config->title, $this->boards->index()),
		);
	}
}
