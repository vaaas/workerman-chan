<?php
namespace App\Views;

use Lib\Mimetype\Mimetype;
use Stringable;
use Workerman\Protocols\Http\Response;

abstract class View {
	public static function response(Stringable $view, int $status = 200): Response {
		return new Response(200, ['Content-Type' => Mimetype::HTML], $view);
	}
}
