<?php
namespace App\Entities;

use Lib\Mimetype\Mimetype;

class Thumbnail {
	public readonly Mimetype $mimetype;

	public function __construct(
		public string $contents,
	) {
		$this->mimetype = Mimetype::AVIF;
	}
}
