<?php
namespace App\Views\Boards;

use App\Views\Components\Form;
use App\Views\Components\FormLabel;
use Stringable;

class ThreadForm extends Form implements Stringable {
	public function __construct() {
		parent::__construct();
		$this->add(new FormLabel('Subject'));
	}
}
