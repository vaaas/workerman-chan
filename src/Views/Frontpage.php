<?php
namespace App\Views;

use App\Views\Layouts\DefaultLayout;

final class Frontpage {
	public function __construct(
		private string $title,
	) {}

	public static function construct(string $title): Frontpage {
		return new Frontpage($title);
	}

	public function render(): string {
		return DefaultLayout::construct()
			->body(<<<EOF
				<h1>Welcome to {$this->title}</h1>
			EOF)
			->title($this->title)
			->render();
	}
}
