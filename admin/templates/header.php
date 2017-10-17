<?php
	/**
	 * Created by PhpStorm.
	 * User: julyan
	 * Date: 16-10-2017
	 * Time: 21:50
	 */

	require_once(__DIR__ . "/../../system.php");
	require_once(APP_UTILITIES . "/require_admin.php");

	use \Navbar\Navbar;
	use \Navbar\UserNav;
	use \Navbar\NavbarColor;
	use \Navbar\NavbarPosition;
	use \Navbar\NavAlignment;

	$navbar = new Navbar(NavbarPosition::StickyTop, SITE_TITLE, true, NavbarColor::Transparent);
	$usernav = new UserNav(NavAlignment::Right);

	$navbar->addNav($usernav);
?>
<!DOCTYPE html>
	<html>
	<head>
		<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
		<script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=4vtwtvxc2s2x16mrx70lq0pykk53cvronq5ui7tnr7rt58yv"></script>
		<?php foreach (glob(INCLUDES_CSS . "/*.css") as $file): ?>
			<link rel="stylesheet" type="text/css" href="<?php echo INCLUDES_CSS_URL . DIRECTORY_SEPARATOR . basename($file); ?>">
		<?php endforeach; ?>

		<?php foreach (glob(INCLUDES_JS . "/*.js") as $file): ?>
			<script src="<?php echo INCLUDES_JS_URL . DIRECTORY_SEPARATOR . basename($file); ?>"></script>
		<?php endforeach; ?>

		<title>CMS</title>
		<link rel="apple-touch-icon" sizes="57x57" href="<?php echo APP_FILES_URL . "/favicon/"; ?>apple-icon-57x57.png">
		<link rel="apple-touch-icon" sizes="60x60" href="<?php echo APP_FILES_URL . "/favicon/"; ?>apple-icon-60x60.png">
		<link rel="apple-touch-icon" sizes="72x72" href="<?php echo APP_FILES_URL . "/favicon/"; ?>apple-icon-72x72.png">
		<link rel="apple-touch-icon" sizes="76x76" href="<?php echo APP_FILES_URL . "/favicon/"; ?>apple-icon-76x76.png">
		<link rel="apple-touch-icon" sizes="114x114" href="<?php echo APP_FILES_URL . "/favicon/"; ?>apple-icon-114x114.png">
		<link rel="apple-touch-icon" sizes="120x120" href="<?php echo APP_FILES_URL . "/favicon/"; ?>apple-icon-120x120.png">
		<link rel="apple-touch-icon" sizes="144x144" href="<?php echo APP_FILES_URL . "/favicon/"; ?>apple-icon-144x144.png">
		<link rel="apple-touch-icon" sizes="152x152" href="<?php echo APP_FILES_URL . "/favicon/"; ?>apple-icon-152x152.png">
		<link rel="apple-touch-icon" sizes="180x180" href="<?php echo APP_FILES_URL . "/favicon/"; ?>apple-icon-180x180.png">
		<link rel="icon" type="image/png" sizes="192x192" href="<?php echo APP_FILES_URL . "/favicon/"; ?>android-icon-192x192.png">
		<link rel="icon" type="image/png" sizes="32x32" href="<?php echo APP_FILES_URL . "/favicon/"; ?>favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="96x96" href="<?php echo APP_FILES_URL . "/favicon/"; ?>favicon-96x96.png">
		<link rel="icon" type="image/png" sizes="16x16" href="<?php echo APP_FILES_URL . "/favicon/"; ?>favicon-16x16.png">
		<link rel="manifest" href="<?php echo APP_FILES_URL . "/favicon/"; ?>manifest.json">
		<meta name="msapplication-TileColor" content="#ffffff">
		<meta name="msapplication-TileImage" content="<?php echo APP_FILES_URL . "/favicon/"; ?>ms-icon-144x144.png">
		<meta name="theme-color" content="#ffffff">
	</head>
	<body>
		<?php echo $navbar->toHTML(); ?>
		<div class="container content">
			<?php echo \System\MessageHandler::getMessagesAsHTML(true); ?>
			<textarea class="tinymce"></textarea>
