<?php
namespace App\DataAccess\Repositories;

use App\DataAccess\Queries\Boards;
use App\Entities\Board;
use Lib\Arr;
use Lib\Database\IDatabase;

class BoardRepository {
	public function __construct(private IDatabase $db) {}

	/** @return Arr<Board> */
	public function index(): Arr {
		return (new Boards\Index())->commit($this->db);
	}
}
