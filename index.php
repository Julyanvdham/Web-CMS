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

	include_once(APP_TEMPLATES . "/header.php");

	if (isset($_GET['page'])) {
		$page = Page::GetFromSlug($_GET['page']);
		echo $page->toHTML();
		echo "
			<script>
			    $(document).ready(function () {
			        Page.setTitle('" . $page->getTitle() . "');
			    });
			</script>
		";
	} elseif (isset($_GET['login'])) {
		include_once(APP_TEMPLATES . "/login.php");
	}
	include_once(APP_TEMPLATES . "/footer.php");