<?php
namespace App\DataAccess\Queries\Attachments;

use Stringable;
use App\Entities\File;
use Lib\Arr;
use Lib\Database\IDatabase;
use Lib\Option\IOption;

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

	/** @return IOption<File> */
	public function commit(IDatabase $db): IOption {
		/** @phpstan-ignore-next-line */
		return $this->transform($db->query($this));
	}

	/**
	 * @param Arr<array{name: string, contents: string}> $results
	 * @return IOption<File>
	 */
	private function transform(Arr $results): IOption {
		return $results
			->first()
			->map(fn($x) => new File($x['name'], $x['contents']));
	}
}
