<?php
	/**
	 * Created by PhpStorm.
	 * User: julyan
	 * Date: 19-10-2017
	 * Time: 14:24
	 */

	namespace Navbar;

	interface INavigation
	{
		/**
		 * @return string
		 */
		public function toHTML();

		/**
		 * @param string $id
		 *
		 * @return bool|NavObject
		 */
		public function findById($id);
	}