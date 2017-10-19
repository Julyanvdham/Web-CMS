<?php
	/**
	 * Created by PhpStorm.
	 * User: julyan
	 * Date: 19-10-2017
	 * Time: 14:12
	 */

	namespace Navbar;

	class NavbarColor
	{
		private $color;
		private $is_custom = false;
		private $is_dark = false;

		/**
		 * NavbarColor constructor.
		 *
		 * @param string $color
		 * @param bool   $is_custom
		 * @param bool   $is_dark
		 */
		private function __construct($color = '', $is_custom = false, $is_dark = false) {
			$this->color = $color;
			$this->is_custom = $is_custom;
			$this->is_dark = $is_dark;
		}

		/**
		 * @param string $color
		 * @param bool   $is_dark
		 *
		 * @return NavbarColor
		 */
		public static function GetCustomColor($color = '#000000', $is_dark = false) {
			return new self($color, true, $is_dark);
		}

		/**
		 * @return NavbarColor
		 */
		public static function GetDark() {
			return new self('#343a40', false, true);
		}

		/**
		 * @return NavbarColor
		 */
		public static function GetLight() {
			return new self('#f8f9fa', false, false);
		}

		/**
		 * @return bool
		 */
		public function isCustom() {
			return $this->is_custom;
		}

		/**
		 * @return bool
		 */
		public function isDark() {
			return $this->is_dark;
		}

		/**
		 * @return bool
		 */
		public function isLight() {
			return !$this->is_dark;
		}

		/**
		 * @return string
		 */
		public function getColor() {
			return $this->color;
		}
	}