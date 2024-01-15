<?php
namespace App\Views\Boards;

use App\Entities\Board;
use App\Views\Element;

class Banner extends Element {
	public function __construct(Board $board) {
		parent::__construct('header');
		$this->child(
			Element::construct('h1')
				->child("{$board->slashedHandle()} - {$board->title}")
		);
	}
}
