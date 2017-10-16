<?php
	/**
	 * Created by PhpStorm.
	 * User: julyan
	 * Date: 16-10-2017
	 * Time: 21:53
	 */

	require_once(__DIR__ . "/../../system.php");

	if (session_status() == PHP_SESSION_NONE)
		session_start();

	use \System\MessageHandler;
	use \System\Rights;

	if (!isset($_SESSION['user']) || !Rights::GetFromUsername($_SESSION['user']['username'])->isAdmin()) {
		if (class_exists("MessageHandler"))
			MessageHandler::pushMessage("You must be logged in as administrator to view this page.");

		header("Location: " . ROOT_URL);
		return;
	}