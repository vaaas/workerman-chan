<?php
namespace App\DataAccess\Queries\Posts;

use App\Entities\Post;
use Lib\Database\IDatabase;
use Lib\Database\Statement;

class Update extends Base {
	public function __construct(private Post $post) {}

	private function statement(): Statement {
		return new Statement(
			"
				update :table
				set
					thread = :thread
					board = :board
					title = :title
					contents = :contents
					created_at = :created_at
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
		$db->exec($this->statement());
		return $this->post;
	}
}
