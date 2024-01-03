<?php
namespace App\Controllers;

use App\DataAccess\Queries\Attachments\GetContents;
use App\DataAccess\Queries\Attachments\GetThumbnail;
use Lib\Database\IDatabase;
use Lib\Http\NotFound;
use Workerman\Protocols\Http\Request;
use Workerman\Protocols\Http\Response;

class AttachmentController {
	public function __construct(private IDatabase $db) {}

	public function getAttachment(Request $req, string $id): NotFound|Response {
		return (new GetContents(intval($id)))
			->commit($this->db)
			->match(
				fn() => new NotFound(),
				fn($x) => new Response(
					200,
					['Content-Type' => $x->mimetype()],
					$x->contents,
				),
			);
	}

	public function getThumbnail(Request $req, string $id): NotFound|Response {
		return (new GetThumbnail(intval($id)))
			->commit($this->db)
			->match(
				fn() => new NotFound(),
				fn($x) => new Response(
					200,
					['Content-Type' => $x->mimetype],
					$x->contents,
				),
			);
	}
}
