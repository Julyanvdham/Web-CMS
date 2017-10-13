<?php
	/**
	 * Created by PhpStorm.
	 * User: julyan
	 * Date: 10-10-2017
	 * Time: 22:31
	 */

	namespace Navbar;

	use System\LanguageHandler;
	use System\User;
	use System\Rights;

	class UserDropdown extends Dropdown
	{

		/**
		 * UserDropdown constructor.
		 *
		 * @param int $alignment
		 *
		 */
		public function __construct($alignment = DropdownAlignment::DownLeft)
		{
			if ($this->getUser())
				parent::__construct($this->getUser()->getUsername(), $alignment);
			else
				parent::__construct((class_exists('LanguageHandler') ? LanguageHandler::GetKeyTranslation("SYSTEM_UNDEFINED") : "UNDEFINED"), $alignment);
		}

		/**
		 * @return User|boolean
		 */
		public function getUser()
		{
			return User::GetCurrentUser();
		}

		/**
		 * @deprecated Function is unused but overridden.
		 * @return null
		 */
		public function getItems()
		{
			return null;
		}

		public function toHTML()
		{
			$direction = "";
			switch ($this->getAlignment()) {
				case DropdownAlignment::DownRight:
					$direction = "dropdown-menu-right";
					break;

				case DropdownAlignment::DownLeft:
					$direction = "";
					break;
			}

			if ($this->getUser()) {
				$admin_visible = (Rights::GetFromUsername($this->getUser()->getUsername())->isAdmin()) ? "" : "invisible";

				return "
						<li class='nav-item dropdown' id='" . $this->getId() . "'>
							<a class='nav-link dropdown-toggle' href='#' aria-expanded='false' data-toggle='dropdown' aria-haspopup='false'>" . $this->getText() . "</a>
							<div class='dropdown-menu $direction'>
								<h6 class='dropdown-header'>" . $this->getUser()->getFullName() . "</h6>
								<img src='' class='rounded-circle'>
								<div class='dropdown-divider'></div>
								<a class='dropdown-item' href='" . ADMIN_URL . "'><strong>" . LanguageHandler::GetKeyTranslation("SYSTEM_ADMINISTRATOR_URL") . "</strong></a>
								<a class='dropdown-item $admin_visible' href='" . LOGOUT_URL . "'>" . LanguageHandler::GetKeyTranslation("SYSTEM_LOGOUT") . "</a>
							</div>
						</li>
						";
			} else
				return "";
		}
	}