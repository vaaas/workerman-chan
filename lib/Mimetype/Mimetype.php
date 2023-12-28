<?php
namespace Lib\Mimetype;

enum Mimetype: string {
	case HTML = 'text/html';
	case TXT = 'text/plain';

	case AVIF = 'image/avif';
	case GIF = 'image/gif';
	case JPEG = 'image/jpeg';
	case PNG = 'image/png';
	case SVG = 'image/svg+xml';
	case WEBP = 'image/webp';

	case BINARY = 'application/octet-stream';
}
