<?php
	/**
	 * Created by PhpStorm.
	 * User: julyan
	 * Date: 17-10-2017
	 * Time: 22:22
	 */

	use \System\LanguageHandler;

?>
<div class="card-body">
	<div class="row">
		<div class="col-xl-2 col-lg-3 col-md-4 col-sm-12 col-xs-12">
			<ul class="nav flex-xl-column flex-lg-column flex-md-column">
				<li class="nav-item">
					<a class="nav-link" href="<?php echo ADMIN_URL . "/dashboard"; ?>"><?php echo LanguageHandler::GetKeyTranslation("ADMIN_DASHBOARD"); ?></a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="<?php echo ADMIN_URL . "/dashboard/users"; ?>"><?php echo LanguageHandler::GetKeyTranslation("ADMIN_USERS"); ?></a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="<?php echo ADMIN_URL . "/dashboard/pages"; ?>"><?php echo LanguageHandler::GetKeyTranslation("ADMIN_PAGES"); ?></a>
				</li>
			</ul>
		</div>
		<div class="col-xl-10 col-lg-9 col-md-8 col-sm-12 col-xs-12">
