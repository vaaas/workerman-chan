<?php

namespace App\DataAccess\Repositories;

use App\Entities\User;
use Lib\Database\IDatabase;

class UserRepository {
	public function __construct(private IDatabase $db) {}

	public function create(User $user): User {
		$name = $this->db::escape($user->name);
		$email = $this->db::escape($user->email);
		$is_admin = $user->is_admin ? 1 : 0;

		/** @var array{id: int} */
		$row = $this->db->query("
			insert into users (name, email, password, is_admin)
			values ($name, $email, $is_admin)
			returning id
		")->first();

		return new User(
			$row['id'],
			$user->name,
			$user->email,
			$user->password,
			$user->is_admin,
		);
	}
}
