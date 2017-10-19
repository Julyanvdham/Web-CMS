<?php
	/**
	 * Created by PhpStorm.
	 * User: julyan
	 * Date: 19-10-2017
	 * Time: 21:39
	 */

	namespace Navbar;

	use System\LanguageHandler;
	use System\User;

	class UserDropdown extends Dropdown
	{
		private $user;

		/**
		 * UserDropdown constructor.
		 *
		 * @param User $user
		 */
		public function __construct($user) {
			parent::__construct($user->getUsername(), Alignment::Right);
			$this->user = $user;
		}

		/**
		 * @deprecated This function must be overridden, always returns false.
		 *
		 * @param Link $link
		 *
		 * @return bool
		 */
		public function addLink(Link $link) {
			return false;
		}

		public function toHTML() {
			$id = $this->getId();
			$text = $this->getUser()->getUsername();
			$fullname = $this->getUser()->getFullname();
			$avatar = $this->getUser()->getGravatar(128);

			$links = "";
			foreach ($this->getLinks() as $link)
				$links .= "<a class='dropdown-item' href='" . $link->getUrl() . "'>" . $link->getText() . "</a>";

			$alignment = $this->getAlignment() == Alignment::Left ? "" : "dropdown-menu-right";
			$admin_visible = $this->getUser()->getRights()->hasRight('is_admin') ? "" : "invisible";

			return "
					<li class='nav-item dropdown' id='$id'>
						<a class='nav-link dropdown-toggle' href='#' aria-expanded='false' data-toggle='dropdown' aria-haspopup='false'>$text</a>
						<div class='dropdown-menu $alignment'>
							<h6 class='dropdown-header'>$fullname</h6>
							<div class='text-center'>
								<img src='$avatar' class='rounded-circle'>
							</div>
							<div class='dropdown-divider'></div>
							<a class='dropdown-item' href='" . ADMIN_URL . "'><strong>" . LanguageHandler::GetKeyTranslation("SYSTEM_ADMIN_AREA") . "</strong></a>
							<a class='dropdown-item $admin_visible' href='" . LOGOUT_URL . "'>" . LanguageHandler::GetKeyTranslation("SYSTEM_LOGOUT") . "</a>
						</div>
					</li>
				";
		}

		/**
		 * @return User
		 */
		public function getUser() {
			return $this->user;
		}
	}