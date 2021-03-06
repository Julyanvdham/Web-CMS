<?php
	/**
	 * Created by PhpStorm.
	 * User: julyan
	 * Date: 9-10-2017
	 * Time: 21:49
	 */

	if (session_status() == PHP_SESSION_NONE)
		session_start();

	require_once('config.inc.php');

	require_once(INCLUDES_PHP . "/vendor/autoload.php");

	foreach (glob(APP_SYSTEM . "/*.system.php") as $utility)
		require_once("$utility");

	foreach (glob(INCLUDES_PHP . "/*.class.php") as $class)
		require_once("$class");

	\System\ShortcodeHandler::Init();