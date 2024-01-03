<?php
namespace App\Entities;

use Lib\Mimetype\Mimetype;

class Thumbnail {
	public readonly string $mimetype;

	public function __construct(
		public string $contents,
	) {
		$this->mimetype = Mimetype::AVIF;
	}
}
