<?php
	/**
	 * Created by PhpStorm.
	 * User: julyan
	 * Date: 19-10-2017
	 * Time: 13:03
	 */

	require_once(__DIR__ . "/config.inc.php");

	function append_log($content) {
		$date = date("Y-m-d H:i:s");
		file_put_contents(LOG_FILE, "[$date] $content\r\n", FILE_APPEND);
	}

	function if_empty(&$original, $default) {
		if (isset($original))
			return $original;

		return $default;
	}

	if (session_status() == PHP_SESSION_NONE)
		session_start();

	if (!isset($_SESSION['modules']))
		$_SESSION['modules'] = array();

	$depth = 1;

	$directory = new RecursiveDirectoryIterator(ABSOLUTE_INCLUDES . "/php");
	$recIterator = new RecursiveIteratorIterator($directory);
	$recIterator->setMaxDepth($depth);
	$pattern = "/.+\\" . DIRECTORY_SEPARATOR . "module.php/i";
	$regex = new RegexIterator($recIterator, $pattern, RegexIterator::GET_MATCH);

	foreach ($regex as $item) {
		$item = $item[0];
		include_once(realpath($item));

		append_log("Importing module '" . realpath($item) . "'");
	}

	foreach ($_SESSION['modules'] as $key => $value) {
		if (!isset($_SESSION['modules'][$key]['classes']))
			$_SESSION['modules'][$key]['classes'] = array();

		if (!isset($_SESSION['modules'][$key]['interfaces']))
			$_SESSION['modules'][$key]['interfaces'] = array();

		foreach (glob($value['path'] . "/*.php") as $file) {
			if (in_array(basename($file), array("module.php", "init.php")))
				continue;

			$content = file_get_contents($file);
			preg_match_all("/(class|interface) (\w+)/", $content, $matches);
			if ($matches[1][0] == "class")
				$_SESSION['modules'][$key]['classes'][$matches[2][0]] = basename($file);
			elseif ($matches[1][0] == "interface")
				$_SESSION['modules'][$key]['interfaces'][$matches[2][0]] = basename($file);
		}
	}

	spl_autoload_register(function ($classname) {
		try {
			if (strpos($classname, "\\") === 0)
				$classname = substr($classname, 1);

			$parts = explode("\\", $classname);

			$classname = end($parts);
			$namespace = "";
			if (count($parts) >= 2) {
				array_pop($parts);
				$namespace = join("\\", $parts);
			}

			$regex = "/(namespace ([\w\\\\]+)|class (\w+)|interface (\w+))/";

			$dir = new RecursiveDirectoryIterator(ABSOLUTE_INCLUDES . "/php");
			$ite = new RecursiveIteratorIterator($dir);
			$ite->setMaxDepth(1);
			$reg = new RegexIterator($ite, "/.+\.(interface|class)\.php/i", RegexIterator::GET_MATCH);

			foreach ($reg as $item) {
				$file = realpath($item[0]);
				$content = file_get_contents($file);
				preg_match_all($regex, $content, $matches);

				if (count($matches) == 5) {
					$match_namespace = if_empty($matches[2][0], "");
					$match_class = $matches[3][1];
					$match_interface = $matches[4][1];
					if (($classname == $match_class || $classname == $match_interface) && $namespace == $match_namespace) {
						append_log("Module '$classname' found at '$file'");

						require_once($file);

						return;
					}
				}
			}
		} catch (Exception $e) {
			append_log("An error has occured: " . $e->getTraceAsString());
		}

		die("Unable to locate class '$classname'");
	});

	$pattern = "/.+\\" . DIRECTORY_SEPARATOR . "init.php/i";
	$regex = new RegexIterator($recIterator, $pattern, RegexIterator::GET_MATCH);

	foreach ($regex as $item)
		include_once($item[0]);

