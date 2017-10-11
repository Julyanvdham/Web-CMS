<?php
	/**
	 * Created by PhpStorm.
	 * User: julyan
	 * Date: 10-10-2017
	 * Time: 22:31
	 */

	namespace Navbar;

	use System\LanguageManager;
	use System\User;

	class UserDropdown extends Dropdown
	{
		private $user;

		/**
		 * UserDropdown constructor.
		 *
		 * @param User $user
		 * @param int  $alignment
		 */
		public function __construct(User $user, $alignment = DropdownAlignment::DownLeft) {
			parent::__construct($user->getUsername(), $alignment);
			$this->user = $user;
		}

		/**
		 * @return User
		 */
		public function getUser() {
			return $this->user;
		}

		public function getItems() {
			return null;
		}

		public function toHTML() {
			$direction = "";
			switch ($this->getAlignment()) {
				case DropdownAlignment::DownRight:
					$direction = "dropdown-menu-right";
					break;

				case DropdownAlignment::DownLeft:
					$direction = "";
					break;
			}

			return "
					<li class='nav-item dropdown' id='" . $this->getId() . "'>
						<a class='nav-link dropdown-toggle' href='#' aria-expanded='false' data-toggle='dropdown' aria-haspopup='false'>" . $this->getText() . "</a>
						<div class='dropdown-menu $direction'>
							<h6 class='dropdown-header'>" . $this->getUser()->getFullName() . "</h6>
							<img src='' class='rounded-circle'>
							<div class='dropdown-divider'></div>
							<a class='dropdown-item' href='" . LOGOUT_URL . "'>" . LanguageManager::GetKeyTranslation("SYSTEM_LOGOUT") . "</a>
						</div>
					</li>
				";
		}
	}