<?php

namespace App\Migrations;

use Lib\Database\IDatabase;
use Lib\Database\IMigration;

class _00001_Initial implements IMigration {
	public static function run(IDatabase $db): void {
		$db->query('create table boards (
			id integer primary key autoincrement,
			handle text unique not null,
			title text not null,
			description text not null
		)');

		$db->query('create table posts (
			id integer primary key autoincrement,
			thread integer,
			board integer,
			title text,
			contents text,
			created_at integer not null
		)');

		$db->query('create table attachments (
			post integer primary key,
			name text not null,
			contents blob not null,
			thumbnail blob,
			sfw integer not null
		)');
	}
}
