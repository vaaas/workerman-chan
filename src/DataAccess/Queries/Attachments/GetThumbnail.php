<?php
namespace App\DataAccess\Queries\Attachments;

use Stringable;
use App\Entities\Thumbnail;
use Lib\Arr;
use Lib\Database\IDatabase;
use Lib\Option\IOption;
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

	/**
	 * @param Arr<array{thumbnail: ?string}> $results
	 * @return IOption<Thumbnail>
	 */
	private function transform(Arr $results): IOption {
		return $results
			->first()
			->bind(fn($x) => Option::from($x['thumbnail']))
			->map(fn($x) => new Thumbnail($x));
	}

	/**
	 * @return IOption<Thumbnail>
	 */
	public function commit(IDatabase $db): IOption {
		/** @phpstan-ignore-next-line */
		return $this->transform($db->query($this));
	}
}
