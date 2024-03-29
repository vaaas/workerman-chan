<?php
namespace App\DataAccess\Queries\Attachments;

use App\Entities\Thumbnail;
use Lib\Arr;
use Lib\Database\IDatabase;
use Lib\Database\Statement;
use Lib\Option\Option;

final class GetThumbnail extends Base {
	public function __construct(private int $id) {}

	private function statement(): Statement {
		return new Statement(
			"select thumbnail from :table where post = :id",
			[
				'table' => self::table,
				'id' => $this->id,
			]
		);
	}

	/**
	 * @param Arr<array{thumbnail: ?string}> $results
	 * @return Option<Thumbnail>
	 */
	private function transform(Arr $results): Option {
		return $results
			->first()
			->bind(fn($x) => Option::from($x['thumbnail']))
			->map(fn($x) => new Thumbnail($x));
	}

	/**
	 * @return Option<Thumbnail>
	 */
	public function commit(IDatabase $db): Option {
		/** @phpstan-ignore-next-line */
		return $this->transform($db->query($this->statement()));
	}
}
