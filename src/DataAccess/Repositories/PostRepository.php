<?php
namespace App\DataAccess\Repositories;

use App\Entities\Post;
use App\DataAccess\Queries\Posts;
use Lib\Database\IDatabase;

class PostRepository {
	const table = 'posts';

	public function __construct(
		private IDatabase $db
	) {}

	public function create(Post $post): Post {
		return (new Posts\Create($post))->commit($this->db);
	}

	public function update(Post $post): Post {
		return (new Posts\Update($post))->commit($this->db);
	}
}
