<?php

namespace App\Entities;

class User {
	public function __construct(
		public int $id,
		public string $name,
		public string $email,
		public Password $password,
		public bool $is_admin
	) {}

	public function withId(int $id): User {
		return new User(
			$id,
			$this->name,
			$this->email,
			$this->password,
			$this->is_admin
		);
	}
}
