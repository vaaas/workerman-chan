<?php
namespace App\Views\Boards;

use App\Entities\Board;
use App\Views\Element;
use Lib\Arr;
use Lib\SMap;

class QuickBar extends Element {
	/** @param Arr<Board> $boards */
	public function __construct(Arr $boards) {
		parent::__construct(
			'nav',
			new SMap(),
			$boards->map($this->renderBoard(...))
		);
	}

	private function renderBoard(Board $x): string {
		return Element::construct('a')
			->prop('href', $x->slashedHandle())
			->child($x->handle);
	}
}
