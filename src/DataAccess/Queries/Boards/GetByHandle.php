<?php
namespace App\DataAccess\Queries\Boards;

use App\Entities\Board;
use Lib\Arr;
use Lib\Database\IDatabase;
use Lib\Database\Statement;
use Lib\Option\Option;

class GetByHandle extends Base {
	public function __construct(private string $handle) {}

	/** @return Option<Board> */
	public function commit(IDatabase $db): Option {
		/** @phpstan-ignore-next-line */
		return $this->transform($db->query($this->statement()));
	}

	private function statement(): Statement {
		$table = self::table;
		return new Statement(
			"select * from $table where handle = :handle",
			[
				'handle' => $this->handle,
			]
		);
	}

	/**
	 * @param Arr<array{id: int, handle: string, title: string, description: string}> $results
	 * @return Option<Board>
	 */
	private function transform(Arr $results): Option {
		return $results
			->first()
			->map(fn($x) => new Board(
				$x['id'],
				$x['handle'],
				$x['title'],
				$x['description'],
			));
	}
}
