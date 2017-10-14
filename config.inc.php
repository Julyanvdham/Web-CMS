<?php
	/**
	 * Created by PhpStorm.
	 * User: julyan
	 * Date: 9-10-2017
	 * Time: 14:19
	 */

	define("DB_HOST", "localhost");
	define("DB_USERNAME", "root");
	define("DB_PASSWORD", "");
	define("DB_NAME", "cms");
	define("DB_PORT", 3306);

	// Other definitions
	define("CRYPT_PASSWORD", "9V9qRB2R6cFKDSg");

	// Folder definitions
	define("ROOT_FOLDER", ".");
	define("ROOT_URL", "http://localhost/web/cms");

	define("HANDLER_URL", ROOT_URL . "/handler.php");
	define("LOGOUT_URL", HANDLER_URL . "?a=logout");
	define("LOGIN_URL", ROOT_URL . "/login");

	define("ADMIN_FOLDER", ROOT_FOLDER . "/admin");
	define("ADMIN_URL", ROOT_URL . "/admin");

	define("INCLUDES_FOLDER", ROOT_FOLDER . "/includes");
	define("INCLUDES_CSS", INCLUDES_FOLDER . "/css");
	define("INCLUDES_JS", INCLUDES_FOLDER . "/js");
	define("INCLUDES_PHP", INCLUDES_FOLDER . "/php");

	define("INCLUDES_FOLDER_URL", ROOT_URL . "/includes");
	define("INCLUDES_CSS_URL", INCLUDES_FOLDER_URL . "/css");
	define("INCLUDES_JS_URL", INCLUDES_FOLDER_URL . "/js");

	define("APP_FOLDER", ROOT_FOLDER . "/app");
	define("APP_TEMPLATES", APP_FOLDER . "/templates");
	define("APP_FILES", APP_FOLDER . "/files");
	define("APP_SYSTEM", APP_FOLDER . "/system");
	define("APP_LANG", APP_FOLDER . "/lang");

	// Folder Creation
	function mkDirIfNotExists($path = '')
	{
		if (!file_exists($path) || !is_dir($path))
			mkdir($path, 0777, true);
	}

	mkDirIfNotExists(ADMIN_FOLDER);
	mkDirIfNotExists(INCLUDES_FOLDER);
	mkDirIfNotExists(INCLUDES_CSS);
	mkDirIfNotExists(INCLUDES_JS);
	mkDirIfNotExists(INCLUDES_PHP);
	mkDirIfNotExists(APP_FOLDER);
	mkDirIfNotExists(APP_TEMPLATES);
	mkDirIfNotExists(APP_FILES);
	mkDirIfNotExists(APP_SYSTEM);
	mkDirIfNotExists(APP_LANG);
