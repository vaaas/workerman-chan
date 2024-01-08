<?php
namespace App\Views\Frontpage\Components;

use App\Entities\Board;
use Lib\Arr;
use Stringable;

class BoardList implements Stringable {
	/** @param Arr<Board> $boards */
	public function __construct(private Arr $boards) {}

	public function render(): string {
		$items = $this->boards
			->map($this->renderItem(...))
			->join('');
		return "<ul>$items</ul>";
	}

	public function __toString(): string {
		return $this->render();
	}

	private function renderItem(Board $x): string {
		return <<<EOF
			<li>
				<a href='{$x->slashedHandle()}'>{$x->slashedHandle()} - {$x->title}</a>
			</li>
		EOF;
	}
}
