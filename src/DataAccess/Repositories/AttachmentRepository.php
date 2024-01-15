<?php
namespace App\DataAccess\Repositories;
use App\DataAccess\Queries\Attachments;
use App\Entities\File;
use App\Entities\Thumbnail;
use Lib\Database\IDatabase;
use Lib\Option\Option;

class AttachmentController {
	public function __construct(private IDatabase $db) {}

	/** @return Option<File> */
	public function getContents(int $id): Option {
		return (new Attachments\GetContents($id))->commit($this->db);
	}

	/** @return Option<Thumbnail> */
	public function getThumbnail(int $id): Option {
		return (new Attachments\GetThumbnail($id))->commit($this->db);
	}
}
