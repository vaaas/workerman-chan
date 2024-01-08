<?php
namespace App\DataAccess\Queries\Boards;

use App\Entities\Board;
use Lib\Arr;
use Lib\Database\IDatabase;
use Lib\Database\Statement;

class Index extends Base {
	/** @return Arr<Board> */
	public function commit(IDatabase $db): Arr {
		/** @phpstan-ignore-next-line */
		return $this->transform($db->query($this->statement()));
	}

	private function statement(): Statement {
		$table = self::table;
		return new Statement("select * from $table");
	}

	/**
	 * @param Arr<array{id: int, handle: string, title: string, description: string}> $results
	 * @return Arr<Board>
	 */
	private function transform(Arr $results): Arr {
		return $results->map(fn($x) => new Board($x['id'], $x['handle'], $x['title'], $x['description']));
	}
}
