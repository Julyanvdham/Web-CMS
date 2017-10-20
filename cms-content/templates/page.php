<?php
	/**
	 * Created by PhpStorm.
	 * User: julyan
	 * Date: 20-10-2017
	 * Time: 13:41
	 */

	use System\Page;

	if (isset($_GET['p'])) {
		$page = Page::GetFromSlug($_GET['p']);
		if ($page) {
			$title = $page->getTitle();
			echo $page->toHTML();
			echo "<script>document.title = '$title'</script>";

			return;
		}
	}

	header("Location: " . ROOT_URL);