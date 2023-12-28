<?php
namespace App\Controllers;

use App\Config;
use Exception;
use Lib\Http\NotFound;
use Workerman\Protocols\Http\Request;
use Workerman\Protocols\Http\Response;

final class StaticController {
	private string $public;

	public function __construct(Config $config) {
		$this->public = $config->web->public;
	}

	public function serve(Request $request): Response {
		$pathname = $this->public . $request->path();
		if (!file_exists($pathname))
			throw new NotFound('Not found: ' . $request->path());

		$contents = file_get_contents($pathname);
		if ($contents === false)
			throw new Exception('Error reading file: ' . $request->path());

		return new Response(
			200,
			[],
			$contents,
		);
	}
}
