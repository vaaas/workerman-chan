<?php
namespace App\Entities;

use Lib\Arr;

class BoardSummary {
	/** @param Arr<mixed> $threads */
	public function __construct(
		public Board $board,
		public Arr $threads,
	) {}
}
