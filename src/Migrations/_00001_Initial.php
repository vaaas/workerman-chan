<?php
namespace App\Migrations;

use Lib\Database\IDatabase;
use Lib\Database\IMigration;
use Lib\Database\Statement;

class _00001_Initial implements IMigration {
	public static function run(IDatabase $db): void {
		$db->exec(new Statement('create table boards (
			id integer primary key autoincrement,
			handle text unique not null,
			title text not null,
			description text not null
		)'));

		$db->exec(new Statement('create table posts (
			id integer primary key autoincrement,
			thread integer,
			board integer,
			title text,
			contents text,
			created_at integer not null
		)'));

		$db->exec(new Statement('create table attachments (
			post integer primary key,
			name text not null,
			contents blob not null,
			thumbnail blob,
			sfw integer not null
		)'));

		$db->exec(new Statement('create table users (
			id integer primary key autoincrement,
			name text unique not null,
			email text unique not null,
			password text not null,
			is_admin integer not null
		)'));
	}
}
