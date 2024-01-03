<?php
namespace Lib\Mimetype;
use Lib\Mimetype\Mimetype;
use Lib\Path;

class Util {
	const EXTENSION_MAP = [
		'avif' => Mimetype::AVIF,
		'gif' => Mimetype::GIF,
		'html' => Mimetype::HTML,
		'jpeg' => Mimetype::JPEG,
		'jpg' => Mimetype::JPEG,
		'png' => Mimetype::PNG,
		'svg' => Mimetype::SVG,
		'txt' => Mimetype::TXT,
		'webp' => Mimetype::WEBP,
	];

	public static function fromExtension(string $pathname): string {
		$ext = strtolower(Path::extension($pathname));
		return array_key_exists($ext, self::EXTENSION_MAP)
			? self::EXTENSION_MAP[$ext]
			: Mimetype::BINARY;
	}
}
