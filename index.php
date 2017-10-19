<?php
	/**
	 * Created by PhpStorm.
	 * User: julyan
	 * Date: 19-10-2017
	 * Time: 12:36
	 */

	include_once(__DIR__ . "/system.php");
	include_once(ABSOLUTE_TEMPLATES . "/header.php");

	ob_start();
	$template = "pages";
	if (isset($_GET['a']))
		switch ($_GET['a']) {
			case "login":
				$template = "login";
				break;
		}

	$template = sprintf(ABSOLUTE_TEMPLATES . DIRECTORY_SEPARATOR . "%s.php", $template);

	ob_start();
	include($template);
	$content = System\ShortcodeHandler::Process(ob_get_clean());
	echo $content;

	include_once(ABSOLUTE_TEMPLATES . "/footer.php");