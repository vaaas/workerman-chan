<?php
namespace App\DataAccess\Queries\Boards;

use App\Entities\Board;
use Lib\Arr;
use Lib\Database\IDatabase;
use Lib\Database\Statement;

class Create extends Base {
	public function __construct(private Board $board) {}

	public static function construct(Board $board): Create {
		return new Create($board);
	}

	public function commit(IDatabase $db): Board {
		/** @phpstan-ignore-next-line */
		return $this->transform($db->query($this->statement()));
	}

	private function statement(): Statement {
		$table = self::table;
		return new Statement(
			"insert into $table values (null, :handle, :title, :description) returning id",
			[
				'handle' => $this->board->handle,
				'title' => $this->board->title,
				'description' => $this->board->description,
			]
		);
	}

	/** @param Arr<array{id: int}> $results */
	private function transform(Arr $results): Board {
		return $results
			->first()
			->map(fn($x) => $x['id'])
			->map($this->board->withId(...))
			->getOrThrow();
	}
}
