<?php
namespace App\Entities;

use Lib\Mimetype\Mimetype;
use Lib\Mimetype\Util;

class File {
	public function __construct(
		public string $pathname,
		public string $contents,
	) {}

	public function mimetype(): Mimetype {
		return Util::fromExtension($this->pathname);
	}
}
