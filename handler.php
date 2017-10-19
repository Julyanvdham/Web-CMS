<?php
	/**
	 * Created by PhpStorm.
	 * User: julyan
	 * Date: 19-10-2017
	 * Time: 22:02
	 */

	include_once(__DIR__ . "/system.php");

	use System\User;

	if (isset($_GET['a']))
		switch ($_GET['a']) {
			case 'logout':
				unset($_SESSION['user']);
				break;
		}

	if (isset($_POST['action']))
		switch ($_POST['action']) {
			case 'login':
				$user = User::GetFromLogin($_POST['username'], $_POST['password']);
				if ($user)
					$_SESSION['user'] = serialize($user);
				break;
		}

	header("Location: " . ROOT_URL);