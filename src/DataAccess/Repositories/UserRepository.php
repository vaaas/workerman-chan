<?php
namespace App\DataAccess\Repositories;

use App\DataAccess\Queries\Users\Create;
use App\Entities\User;
use Lib\Database\IDatabase;

class UserRepository {
	public function __construct(private IDatabase $db) {}

	public function create(User $user): User {
		return (new Create($user))->commit($this->db);
	}
}
