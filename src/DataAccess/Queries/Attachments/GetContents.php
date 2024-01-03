<?php
namespace App\DataAccess\Queries\Attachments;

use Stringable;
use App\Entities\File;
use Lib\Arr;
use Lib\Database\IDatabase;

class GetContents extends Base implements Stringable {
	public function __construct(private int $id) {}

	public function __toString(): string {
		$table = self::table;
		return "
			select
				name,
				contents
			from {$table}
			where post = {$this->id}
		";
	}

	public function commit(IDatabase $db): ?File {
		return $this->transform($db->query($this));
	}

	/** @var Arr<array{name: string, contents: string}> */
	private function transform(Arr $results): ?File {
		return $results
			->first()
			->map(fn($x) => new File($x['name'], $x['contents']))
			->unwrap();
	}
}
