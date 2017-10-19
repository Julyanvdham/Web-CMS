<?php
	/**
	 * Created by PhpStorm.
	 * User: julyan
	 * Date: 19-10-2017
	 * Time: 12:32
	 */

	$dir = realpath(__DIR__);
	$root = realpath($_SERVER['DOCUMENT_ROOT']);

	$relative = str_replace($root, "", $dir);

	$root_url = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['SERVER_NAME'] . str_replace("\\", "/", $relative);

	define("ROOT_URL", $root_url);