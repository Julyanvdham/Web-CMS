<?php
	/**
	 * Created by PhpStorm.
	 * User: julyan
	 * Date: 19-10-2017
	 * Time: 18:26
	 */

	$colors = array_keys(\System\Colors::GetCommonColors(ABSOLUTE_ASSETS . "/bg.jpg"));
	$navbar = new Navbar\Navbar(SITE_NAME, ROOT_URL, \Navbar\NavbarPosition::StickyTop, \Navbar\NavbarColor::GetCustomColor("#" . $colors[0], \System\Colors::IsDark("#" . $colors[0])));

	$user = \System\User::GetCurrent();
	$usernav = new Navbar\UserNav(\Navbar\Alignment::Right, $user);
	$navbar->addNav($usernav);
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<?php foreach (glob(ABSOLUTE_INCLUDES . "/css/*.css") as $file): ?>
			<link rel="stylesheet" href="<?php echo URL_INCLUDES . "/css/" . basename($file); ?>">
		<?php endforeach; ?>

		<title><?php echo SITE_NAME; ?></title>

		<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
	</head>
	<body>
		<?php echo $navbar->toHTML(); ?>
		<div id="site_content" class="container">
