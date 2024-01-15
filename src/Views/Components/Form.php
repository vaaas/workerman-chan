<?php
namespace App\Views\Components;

use App\Views\Element;
use Lib\SMap;

class Form extends Element {
	public function __construct(
		string $action = '',
		string $method = 'get',
	) {
		parent::__construct(
			'form',
			new SMap(['action' => $action, 'method' => $method])
		);
	}

	public function __toString(): string {
		$this->child(
			element::construct('footer')
				->child(
					element::construct('input')
						->prop('type', 'submit')
						->prop('value', 'Submit')
				)
		);
		return parent::__toString();
	}
}
