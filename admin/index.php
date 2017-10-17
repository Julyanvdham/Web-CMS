<?php
	/**
	 * Created by PhpStorm.
	 * User: julyan
	 * Date: 9-10-2017
	 * Time: 21:58
	 */

	require_once(__DIR__ . "/../system.php");
	include_once(APP_UTILITIES . "/require_admin.php");

	use \System\LanguageHandler;
	use \System\ShortcodeHandler;

	$page = __DIR__ . "/pages/dashboard.php";
	$title = "";
	if (isset($_GET['a'])) {
		switch ($_GET['a']) {
			case 'dashboard':
				$page = __DIR__ . "/pages/dashboard.php";
				$title = LanguageHandler::GetKeyTranslation("ADMIN_DASHBOARD");
				break;

			case 'users':
				$page = __DIR__ . "/pages/users.php";
				$title = LanguageHandler::GetKeyTranslation("ADMIN_USERS");
				break;

			case 'pages':
				$page = __DIR__ . "/pages/pages.php";
				$title = LanguageHandler::GetKeyTranslation("ADMIN_PAGES");
				break;
		}
	} else {
		$page = __DIR__ . "/pages/dashboard.php";
	}

	include_once(__DIR__ . "/templates/header.php");

	echo "
		<div class='card-header'>
			<h4 class='card-title my-0'>$title</h4>
		</div>
	";

	include_once(__DIR__ . "/templates/navigator_header.php");

	ob_start();
	include_once($page);
	echo ShortcodeHandler::Parse(ob_get_clean());

	include_once(__DIR__ . "/templates/navigator_footer.php");
	include_once(__DIR__ . "/templates/footer.php");
