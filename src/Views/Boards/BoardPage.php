<?php
namespace App\Views\Boards;

use App\Entities\Board;
use App\Views\Layouts\DefaultLayout;
use Lib\Arr;
use Stringable;

class BoardPage implements Stringable{
	/** @param Arr<Board> $boards */
	public function __construct(
		private Arr $boards,
		private Board $board,
	) {}

	public function __toString(): string {
		return $this->render();
	}

	public function render(): string {
		$banner = new Banner($this->board);
		$quickbar = new QuickBar($this->boards);
		return new DefaultLayout(
			$this->board->title,
			"$quickbar $banner",
		);
	}
}
