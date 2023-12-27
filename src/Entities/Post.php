<?php

namespace App\Entities;

use DateTime;

class Post {
	public function __construct(
		public int $id,
		public ?int $thread,
		public int $board,
		public ?string $title,
		public string $contents,
		public DateTime $created_at = new DateTime(),
	) {}
}
