<?php

namespace App\DataAccess\Repositories;

use App\Entities\Post;
use DateTime;
use Lib\Database\IDatabase;

class PostRepository {
	const table = 'posts';

	public function __construct(
		private IDatabase $db
	) {}

	public function create(Post $post): Post {
		$thread = $post->thread;
		$board = $post->board;
		$title = $post->title ? $this->db::escape($post->title) : 'null';
		$contents = $this->db::escape($post->contents);
		$created_at = $post->created_at->getTimestamp();

		/** @var array{id: int} */
		$row = $this->db->query("
			insert into posts (
				thread,
				board,
				title,
				contents,
				created_at
			)
			values (
				$thread,
				$board,
				$title,
				$contents,
				$created_at,
			)
			returning id
		")->first();

		return new Post(
			$row['id'],
			$thread,
			$board,
			$title,
			$contents,
			new DateTime('@' . $created_at),
		);
	}

	public function update(Post $post): void {
		$id = $post->id;
		$thread = $post->thread;
		$board = $post->board;
		$title = $post->title ? $this->db::escape($post->title) : 'null';
		$contents = $this->db::escape($post->contents);
		$created_at = $post->created_at->getTimestamp();

		$this->db->query("
			update posts
			set
				thread = $thread,
				board = $board,
				title = $title,
				contents = $contents,
				created_at = $created_at
			where
				id = $id
		");
	}
}
