<?php
namespace App\Views\Boards;

use App\Entities\Board;
use Lib\Arr;
use Stringable;

class QuickBar implements Stringable {
	/** @param Arr<Board> $boards */
	public function __construct(private Arr $boards) {}

	public function __toString(): string {
		return $this->render();
	}

	public function render(): string {
		$boards = $this->boards->map($this->renderBoard(...))->join(' / ');
		return "<nav>$boards</nav>";
	}

	private function renderBoard(Board $x): string {
		return "<a href='{$x->slashedHandle()}'>{$x->handle}</a>";
	}
}
