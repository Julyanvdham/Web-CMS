<?php
	/**
	 * Created by PhpStorm.
	 * User: julyan
	 * Date: 19-10-2017
	 * Time: 12:36
	 */

	define("DB_HOST", "localhost");
	define("DB_USER", "root");
	define("DB_PASSWORD", "");
	define("DB_NAME", "cms");
	define("DB_PORT", 3306);

	if (file_exists(__DIR__ . "/getrooturl.php"))
		include_once(__DIR__ . "/getrooturl.php");
	else
		define("ROOT_URL", "http://localhost/web/cms");

	define("SITE_NAME", "CMS");

	define("ABSOLUTE_ROOT", __DIR__);
	define("ABSOLUTE_CONTENT", ABSOLUTE_ROOT . DIRECTORY_SEPARATOR . "cms-content");
	define("ABSOLUTE_INCLUDES", ABSOLUTE_CONTENT . DIRECTORY_SEPARATOR . "includes");
	define("ABSOLUTE_TEMPLATES", ABSOLUTE_CONTENT . DIRECTORY_SEPARATOR . "templates");

	define("URL_CONTENT", ROOT_URL . "/cms-content");
	define("URL_INCLUDES", URL_CONTENT . "/includes");

	define("LOG_FILE", ABSOLUTE_ROOT . "/log.txt");