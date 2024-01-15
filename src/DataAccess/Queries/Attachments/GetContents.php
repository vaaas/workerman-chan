<?php
namespace App\DataAccess\Queries\Attachments;

use App\Entities\File;
use Lib\Arr;
use Lib\Database\IDatabase;
use Lib\Database\Statement;
use Lib\Option\Option;

class GetContents extends Base {
	public function __construct(private int $id) {}

	private function statement(): Statement {
		return new Statement(
			"select name, contents from :table where post = :id",
			[
				'table' => self::table,
				'id' => $this->id,
			]
		);
	}

	/** @return Option<File> */
	public function commit(IDatabase $db): Option {
		/** @phpstan-ignore-next-line */
		return $this->transform($db->query($this->statement()));
	}

	/**
	 * @param Arr<array{name: string, contents: string}> $results
	 * @return Option<File>
	 */
	private function transform(Arr $results): Option {
		return $results
			->first()
			->map(fn($x) => new File($x['name'], $x['contents']));
	}
}
