<?php
	/**
	 * Created by PhpStorm.
	 * User: julyan
	 * Date: 20-10-2017
	 * Time: 13:22
	 */

	include_once(__DIR__ . "/system.php");

	use System\Database;

	$count = 20;
	for ($index = 0; $index < $count; $index++) {
		Database::PreparedQuery("INSERT INTO pages (ID, title, slug, content, author, creation_date, last_modified) VALUES(NULL, ?, ?, ?, 1, NULL, NULL)", "sss", "TEST PAGE $index", "test-page-$index", "Test page $index");
	}