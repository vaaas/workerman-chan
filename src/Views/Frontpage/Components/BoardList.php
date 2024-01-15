<?php
namespace App\Views\Frontpage\Components;

use App\Entities\Board;
use App\Views\Element;
use Lib\Arr;
use Lib\SMap;

class BoardList extends Element {
	/** @param Arr<Board> $boards */
	public function __construct(Arr $boards) {
		parent::__construct(
			'ul',
			new SMap(),
			$boards->map($this->renderBoard(...))
		);
	}

	private function renderBoard(Board $x) {
		return Element::construct('a')
			->prop('href', $x->slashedHandle())
			->child("{$x->slashedHandle()} - {$x->title}");
	}
}
