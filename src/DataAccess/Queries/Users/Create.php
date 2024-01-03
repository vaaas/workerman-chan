<?php
namespace App\DataAccess\Queries\Users;

use App\Database;
use App\Entities\User;
use Lib\Arr;
use Lib\Database\IDatabase;
use Stringable;

class Create extends Base implements Stringable {
	public function __construct(private User $user) {}

	public function __toString() {
		$table = self::table;
		$name = Database::escape($this->user->name);
		$email = Database::escape($this->user->email);
		$is_admin = $this->user->is_admin ? 1 : 0;
		return "
			insert into $table (name, email, password, is_admin)
			values ($name, $email, $is_admin)
			returning id
		";
	}

	public function commit(IDatabase $db): User {
		/** @phpstan-ignore-next-line */
		return $this->transform($db->query($this));
	}

	/** @param Arr<array{id: int}> $results */
	private function transform(Arr $results): User {
		return $results
			->first()
			->map(fn($x) => new User(
				$x['id'],
				$this->user->name,
				$this->user->email,
				$this->user->password,
				$this->user->is_admin,
			))
			->getOrThrow();
	}
}
