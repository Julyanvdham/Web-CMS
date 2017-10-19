<?php
	/**
	 * Created by PhpStorm.
	 * User: julyan
	 * Date: 19-10-2017
	 * Time: 13:40
	 */

	namespace Navbar;

	use System\Guid;

	abstract class NavObject implements INavigation
	{
		private $id;

		protected function __construct() {
			$this->id = Guid::GetGUID(true);
		}

		/**
		 * @return string
		 */
		public function getId() {
			return $this->id;
		}
	}