<?php
namespace App\Repositories;

use App\Entities\File;
use App\Entities\Thumbnail;
use Lib\Arr;
use Lib\Database\IDatabase;

class AttachmentRepository {
	public function __construct(private IDatabase $db) {}

	public function getContents(int $id): ?File {
		/** @var Arr<array{name: string, contents: string}> */
		$results = $this->db->query("
			select
				name,
				contents
			from attachments
			where post = $id
		");
		if ($results->empty())
			return null;
		/** @var array{name: string, contents: string}> */
		$row = $results->first();
		return new File($row['name'], $row['contents']);
	}

	public function getThumbnail(int $id): ?Thumbnail {
		/** @var Arr<array{thumbnail: ?string}> */
		$results = $this->db->query("
			select
				thumbnail
			from attachments
			where post = $id
		");
		if ($results->empty())
			return null;
		/** @var array{thumbnail: ?string}> */
		$row = $results->first();
		if ($row['thumbnail'] === null)
			return null;
		return new Thumbnail($row['thumbnail']);
	}
}
