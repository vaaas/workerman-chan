<?php
namespace App\Views\Components;

use App\Views\Element;
use Lib\Arr;
use Lib\SMap;

class TextInput extends Element {
	public function __construct(
		private string $name = '',
		private string $value = '',
	) {
		parent::__construct(
			'input',
			new SMap([
				'name' => $name,
				'value' => $value,
			]),
			new Arr()
		);
	}
}
