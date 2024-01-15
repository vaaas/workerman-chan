<?php
namespace App\Views\Components;

use App\Views\Element;

class FormLabel extends Element {
	public function __construct(
		string $label = '',
		string $input = '',
	) {
		parent::__construct('label');
		$this->child(Element::construct('span')->child($label))
			->child(Element::construct('span')->child($input));
	}
}
