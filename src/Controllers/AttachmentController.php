<?php
namespace App\Controllers;

use App\Repositories\AttachmentRepository;
use Lib\Http\NotFound;
use Workerman\Protocols\Http\Request;
use Workerman\Protocols\Http\Response;

class AttachmentController {
	public function __construct(
		private AttachmentRepository $attachmentRepository,
	) {}

	public function getAttachment(Request $req, string $id): Response {
		$parsed = intval($id);
		$attachment = $this->attachmentRepository->getContents($parsed);
		if (!$attachment)
			throw new NotFound();
		return new Response(
			200,
			['Content-Type' => $attachment->mimetype()],
			$attachment->contents,
		);
	}

	public function getThumbnail(Request $req, string $id): Response {
		$parsed = intval($id);
		$thumbnail = $this->attachmentRepository->getThumbnail($parsed);
		if (!$thumbnail)
			throw new NotFound();
		return new Response(
			200,
			['Content-Type' => $thumbnail->mimetype],
			$thumbnail->contents,
		);
	}
}
