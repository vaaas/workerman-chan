<?php
namespace App\DataAccess\Queries\Attachments;

use Stringable;
use App\Entities\Thumbnail;
use Lib\Arr;
use Lib\Database\IDatabase;
use Lib\Option\Option;

final class GetThumbnail extends Base implements Stringable {
	public function __construct(private int $id) {}

	public function __toString(): string {
		$table = self::table;
		return "
			select thumbnail
			from {$table}
			where post = {$this->id}
		";
	}

	/** @param Arr<array{thumbnail: ?string}> $results */
	private function transform(Arr $results): ?Thumbnail {
		return $results
			->first()
			->bind(fn($x) => Option::from($x['thumbnail']))
			->map(fn($x) => new Thumbnail($x))
			->unwrap();
	}

	public function commit(IDatabase $db): ?Thumbnail {
		return $this->transform($db->query($this));
	}
}
