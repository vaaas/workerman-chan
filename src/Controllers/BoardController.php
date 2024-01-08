<?php
namespace App\Controllers;

use App\DataAccess\Repositories\BoardRepository;
use App\Entities\Board;
use App\Views\View;
use App\Views\Boards\BoardPage;
use Lib\Http\NotFound;
use Workerman\Protocols\Http\Request;
use Workerman\Protocols\Http\Response;

class BoardController {
	public function __construct(private BoardRepository $boards) {}

	public function index(Request $_, string $handle): mixed {
		return $this->boards->getByHandle($handle)
			->map(function (Board $x): Response {
				$boards = $this->boards->index();
				return View::response(new BoardPage($boards, $x));
			})
			->fold(new NotFound());
	}
}
