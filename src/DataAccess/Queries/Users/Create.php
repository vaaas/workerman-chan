<?php
namespace App\DataAccess\Queries\Users;

use App\Entities\User;
use Lib\Arr;
use Lib\Database\IDatabase;
use Lib\Database\Statement;

final class Create extends Base {
	public function __construct(private User $user) {}

	public static function construct(User $user): Create {
		return new Create($user);
	}

	private function statement(): Statement {
		return new Statement(
			"insert into :table values (:name, :email :password, :is_admin) returning id",
			[
				'table' => self::table,
				'name' => $this->user->name,
				'email' => $this->user->email,
				'password' => $this->user->password,
				'is_admin' => $this->user->is_admin ? 1 : 0,
			]
		);
	}

	public function commit(IDatabase $db): User {
		/** @phpstan-ignore-next-line */
		return $this->transform($db->query($this->statement()));
	}

	/** @param Arr<array{id: int}> $results */
	private function transform(Arr $results): User {
		return $results
			->first()
			->map(fn($x) => $x['id'])
			->map($this->user->withId(...))
			->getOrThrow();
	}
}
