<?php
	/**
	 * Created by PhpStorm.
	 * User: jvjum
	 * Date: 13-10-2017
	 * Time: 11:49
	 */

	namespace Navbar;

	use System\User;

	class UserNav extends Nav
	{
		/**
		 * UserNav constructor.
		 *
		 * @param int $alignment
		 */
		public function __construct($alignment = NavAlignment::Right)
		{
			parent::__construct($alignment);
		}

		/**
		 * @deprecated Overridden but not usable
		 * @return null
		 */
		public function getItems()
		{
			return null;
		}

		/**
		 * @param NavObject $item
		 * @deprecated Overridden but not usable, always returns false
		 * @return false
		 */
		public function addItem(NavObject $item)
		{
			return false;
		}

		/**
		 * @return string
		 */
		public function toHTML()
		{
			$alignment = "";

			switch ($this->getAlignment()) {
				case NavAlignment::Left:
					$alignment = 'ml-auto';
					break;

				case NavAlignment::Right:
					$alignment = 'mr-auto';
					break;
			}


			$drop = (new UserDropdown())->$this->toHTML();
			return "
					<ul class='navbar-nav $alignment'>
						$drop
					</ul>
				";
		}

	}