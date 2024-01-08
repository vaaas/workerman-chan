<?php
namespace App\Views;

use App\Entities\Board;
use App\Views\Layouts\DefaultLayout;
use Lib\Arr;
use Stringable;

final class Frontpage implements Stringable {
	/** @param Arr<Board> $boards */
	public function __construct(
		private string $title,
		private Arr $boards,
	) {}

	/** @param Arr<Board> $boards */
	public static function construct(
		string $title,
		Arr $boards,
	): Frontpage {
		return new Frontpage($title, $boards);
	}

	public function render(): string {
		$title = "<h1>Welcome to {$this->title}</h1>";
		$boards = new BoardList($this->boards);
		return DefaultLayout::construct()
			->body("$title $boards")
			->title($this->title)
			->render();
	}

	public function __toString(): string {
		return $this->render();
	}
}
