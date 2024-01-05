<?php
namespace App\DataAccess\Queries\Posts;

use App\Entities\Post;
use Lib\Arr;
use Lib\Database\IDatabase;
use Lib\Database\Statement;

class Create extends Base {
	public function __construct(private Post $post) {}

	private function statement(): Statement {
		return new Statement(
			"
				insert into :table (
					thread,
					board,
					title,
					contents,
					created_at
				) values (
					:thread,
					:board,
					:title,
					:contents,
					:created_at
				)
			",
			[
				'table' => self::table,
				'thread' => $this->post->thread,
				'board' => $this->post->board,
				'title' => $this->post->title,
				'contents' => $this->post->contents,
				'created_at' => $this->post->created_at->getTimestamp(),
			]
		);
	}

	public function commit(IDatabase $db): Post {
		/** @phpstan-ignore-next-line */
		return $this->transform($db->query($this->statement()));
	}

	/** @param Arr<array{id: int}> $results */
	private function transform(Arr $results): Post {
		return $results
			->first()
			->map(fn($x) => $x['id'])
			->map($this->post->withId(...))
			->getOrThrow();
	}
}
