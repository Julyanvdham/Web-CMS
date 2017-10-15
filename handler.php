<?php
	/**
	 * Created by PhpStorm.
	 * User: julyan
	 * Date: 15-10-2017
	 * Time: 19:06
	 */

	require_once(__DIR__ . "/system.php");

	if (isset($_GET['logout'])) {
		session_unset();
		session_destroy();

		if (session_status() == PHP_SESSION_NONE)
			session_start();
	}

	if (isset($_POST['action']))
		switch($_POST['action']) {
			case "login":
				$username = $_POST['username'];

				$crypt = new \System\Crypt();
				$password = $crypt->Encrypt($_POST['password']);

				$user = \System\User::GetFromUsername($username);
				if ($user->getPassword() == $password) {
					$user->toSession();
				}

				break;
		}

	header("Location: " . ROOT_URL);