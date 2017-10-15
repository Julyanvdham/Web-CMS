<?php use \System\LanguageHandler; ?>
<div class="card">
	<div class="card-header"><h4 class="card-title"><?php echo LanguageHandler::GetKeyTranslation("LOGIN_TITLE"); ?></h4></div>
	<div class="card-body">
		<form action="handler.php" method="POST" novalidate id="needs-validation">
			<div class="form-group">
				<label for="username"><?php echo LanguageHandler::GetKeyTranslation("LOGIN_USERNAME"); ?></label>
				<input type="text" name="username" class="form-control" placeholder="<?php echo LanguageHandler::GetKeyTranslation("LOGIN_USERNAME"); ?>" required minlength="3">
			</div>
			<div class="form-group">
				<label for="password"><?php echo LanguageHandler::GetKeyTranslation("LOGIN_PASSWORD"); ?></label>
				<input type="password" name="password" class="form-control" placeholder="<?php echo LanguageHandler::GetKeyTranslation("LOGIN_PASSWORD"); ?>" required>
			</div>
			<input type="hidden" name="action" value="login">
			<button class="btn btn-outline-dark" type="submit"><?php echo LanguageHandler::GetKeyTranslation("LOGIN_SUBMIT"); ?></button>
		</form>
	</div>
</div>
<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
        "use strict";
        window.addEventListener("load", function() {
            $("#needs-validation").submit(function(event){
                if (this.checkValidity() == false) {
                    this.stopPropagation();
                    this.preventDefault();
				}
				this.classList.add("was-validated");
			});
        }, false);
    }());
</script>