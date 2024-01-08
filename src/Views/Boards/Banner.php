<?php
namespace App\Views\Boards;

use App\Entities\Board;
use Stringable;

class Banner implements Stringable {
	public function __construct(private Board $board) {}

	public function __toString(): string {
		return $this->render();
	}

	public function render(): string {
		return <<<EOF
			<header>
				<h1>{$this->board->slashedHandle()} - {$this->board->title}</h1>
			</header>
		EOF;
	}
}
