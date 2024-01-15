<?php
namespace App\Views\Frontpage;

use App\Entities\Board;
use App\Views\Element;
use App\Views\Layouts\DefaultLayout;
use App\Views\Frontpage\Components\BoardList;
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

	public function __toString(): string {
		$title = Element
			::construct('h1')
			->child("Welcome to {$this->title}!");
		$boards = new BoardList($this->boards);
		return DefaultLayout::construct()
			->body("$title $boards")
			->title($this->title);
	}
}
