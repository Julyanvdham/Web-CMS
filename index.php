<?php
	/**
	 * Created by PhpStorm.
	 * User: julyan
	 * Date: 9-10-2017
	 * Time: 14:19
	 */

	require_once('config.inc.php');
	require_once('system.php');

	$pagecontent = "";
	if (isset($_GET['p'])) {
		$db = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME, DB_PORT);

		$slug = mysqli_real_escape_string($db, $_GET['p']);

		$sql = "SELECT * FROM pages WHERE slug='$slug' LIMIT 1";
		$query = mysqli_query($db, $sql) or \System\MessageHandler::pushMessage(mysqli_error($db));
	} else {

	}

	include_once(APP_TEMPLATES . "/header.php");
	echo htmlspecialchars_decode($pagecontent);
	include_once(APP_TEMPLATES . "/footer.php");