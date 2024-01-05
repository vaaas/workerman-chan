<?php
namespace App\DataAccess\Repositories;
use App\DataAccess\Queries\Attachments;
use App\Entities\File;
use App\Entities\Thumbnail;
use Lib\Database\IDatabase;
use Lib\Option\IOption;

class AttachmentController {
	public function __construct(private IDatabase $db) {}

	/** @return IOption<File> */
	public function getContents(int $id): IOption {
		return (new Attachments\GetContents($id))->commit($this->db);
	}

	/** @return IOption<Thumbnail> */
	public function getThumbnail(int $id): IOption {
		return (new Attachments\GetThumbnail($id))->commit($this->db);
	}
}
