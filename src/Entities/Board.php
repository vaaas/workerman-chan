<?php
namespace App\Entities;

class Board {
	public function __construct(
		public int $id,
		public string $handle,
		public string $title,
		public string $description,
	) {}

	public function withId(int $id): Board {
		return new Board(
			$id,
			$this->handle,
			$this->title,
			$this->description,
		);
	}

	public function slashedHandle(): string {
		return '/' . $this->handle . '/';
	}
}
