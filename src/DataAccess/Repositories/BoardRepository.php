<?php
namespace App\DataAccess\Repositories;

use App\DataAccess\Queries\Boards;
use App\Entities\Board;
use Lib\Arr;
use Lib\Database\IDatabase;
use Lib\Option\IOption;

class BoardRepository {
	public function __construct(private IDatabase $db) {}

	/** @return Arr<Board> */
	public function index(): Arr {
		return (new Boards\Index())->commit($this->db);
	}

	/** @return IOption<Board> */
	public function getByHandle(string $handle): IOption {
		return (new Boards\GetByHandle($handle))->commit($this->db);
	}
}
