<?php
	/**
	 * Created by PhpStorm.
	 * User: julyan
	 * Date: 19-10-2017
	 * Time: 22:05
	 */

	use System\LanguageHandler;

?>
<div class="card">
	<div class="card-header"><h4 class="card-title"><?php echo LanguageHandler::GetKeyTranslation("LOGIN_TITLE"); ?></h4></div>
	<div class="card-body">
		<form id="needs_validation" action="<?php echo HANDLER_URL; ?>" method="post" novalidate>
			<div class="form-group">
				<label for="username"><?php echo LanguageHandler::GetKeyTranslation("LOGIN_USERNAME"); ?></label>
				<input class="form-control" type="text" name="username" placeholder="<?php echo LanguageHandler::GetKeyTranslation("LOGIN_USERNAME"); ?>" required minlength="3">
			</div>
			<div class="form-group">
				<label for="username"><?php echo LanguageHandler::GetKeyTranslation("LOGIN_PASSWORD"); ?></label>
				<input class="form-control" type="password" name="password" placeholder="<?php echo LanguageHandler::GetKeyTranslation("LOGIN_PASSWORD"); ?>" required minlength="3">
			</div>
			<input type="hidden" name="action" value="login">
			<button class="btn btn-dark" type="submit"><?php echo LanguageHandler::GetKeyTranslation("LOGIN_SUBMIT"); ?></button>
		</form>
	</div>
</div>
