<?php
	/**
	 * Created by PhpStorm.
	 * User: julyan
	 * Date: 10-10-2017
	 * Time: 22:31
	 */

	namespace Navbar;

	use \System\User;

	class UserDropdown extends Dropdown
	{
		private $user;

		/**
		 * UserDropdown constructor.
		 *
		 * @param User $user
		 */
		public function __construct(User $user) {
			parent::__construct($user->getUsername());
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

			$hidden = $this->isVisible() ? '' : 'invisible';
			return "
					<li class='nav-item dropdown $hidden' id='" . $this->getId() . "'>
						<a class='nav-link dropdown-toggle' href='#' aria-expanded='false' data-toggle='dropdown' aria-haspopup='false'>" . $this->getText() . "</a>
						<div class='dropdown-menu $direction'>
							<h6 class='dropdown-header'>" . $this->getUser()->getFullName() . "</h6>
							<img src='' class='rounded-circle'>
							<div class='dropdown-divider'></div>
						</div>
					</li>
				";
		}
	}