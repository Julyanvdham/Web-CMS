<?php
	/**
	 * Created by PhpStorm.
	 * User: julyan
	 * Date: 9-10-2017
	 * Time: 14:43
	 */

	if (session_status() == PHP_SESSION_NONE)
		session_start();

	require_once(__DIR__ . "/../../system.php");

	if (file_exists(APP_FILES . "/navbar.nav")) {
		$navbar = \Navbar\Navbar::Load(APP_FILES . "/navbar.nav");
	} else {
		$navbar = new \Navbar\Navbar(\Navbar\NavbarPosition::FixedTop, 'CMS', true, \Navbar\NavbarColor::Transparent);
		$usernav = new \Navbar\UserNav();
		$navbar->addNav($usernav);
		$navbar->Save(APP_FILES . "/navbar.nav");
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
		<?php foreach (glob(INCLUDES_CSS . "/*.css") as $file): ?>
			<link rel="stylesheet" type="text/css" href="<?php echo INCLUDES_CSS_URL . DIRECTORY_SEPARATOR . basename($file); ?>">
		<?php endforeach; ?>

		<?php foreach (glob(INCLUDES_JS . "/*.js") as $file): ?>
			<script src="<?php echo INCLUDES_JS_URL . DIRECTORY_SEPARATOR . basename($file); ?>"></script>
		<?php endforeach; ?>

		<title>CMS</title>
	</head>
	<body>
		<?php echo $navbar->toHTML(); ?>
		<div class="container content">
			<?php echo \System\MessageHandler::getMessagesAsHTML(true); ?>