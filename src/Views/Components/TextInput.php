<?php
namespace App\Views\Components;

use App\Views\Element;
use Lib\Arr;
use Lib\SMap;

class TextInput extends Element {
	public function __construct(
		string $name = '',
		string $value = '',
	) {
		parent::__construct('input');
		$this->prop('name', $name);
		$this->prop('value', $value);
	}
}
