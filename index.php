<?php
	/**
	 * Created by PhpStorm.
	 * User: julyan
	 * Date: 9-10-2017
	 * Time: 14:19
	 */

	require_once(__DIR__ . '/config.inc.php');
	require_once(__DIR__ . '/system.php');

	use \Page\Page;

	$pagecontent = "";
	if (isset($_GET['page'])) {
		$page = Page::GetFromSlug($_GET['page']);
		$pagecontent = $page->toHTML();
	} else {

	}

	include_once(APP_TEMPLATES . "/header.php");
	echo $pagecontent;
	include_once(APP_TEMPLATES . "/footer.php");