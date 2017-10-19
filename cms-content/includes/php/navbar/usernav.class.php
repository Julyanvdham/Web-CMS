<?php
	/**
	 * Created by PhpStorm.
	 * User: julyan
	 * Date: 19-10-2017
	 * Time: 21:38
	 */

	namespace Navbar;

	use System\LanguageHandler;

	class UserNav extends Nav
	{
		private $user;

		public function __construct($alignment = Alignment::Right, $user) {
			parent::__construct($alignment);
			$this->user = $user;
		}

		/**
		 * @deprecated method should not be usable, always returns false.
		 *
		 * @param NavObject $object
		 *
		 * @return bool
		 */
		public function addItem(NavObject $object) {
			return false;
		}

		public function toHTML() {
			if ($this->getUser())
				array_push($this->children, new UserDropdown($this->getUser()));
			else
				array_push($this->children, new Link(LanguageHandler::GetKeyTranslation("SYSTEM_LOGIN"), LOGIN_URL));

			return parent::toHTML();
		}

		/**
		 * @return mixed
		 */
		public function getUser() {
			return $this->user;
		}
	}