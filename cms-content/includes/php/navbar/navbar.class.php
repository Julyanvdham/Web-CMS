<?php
	/**
	 * Created by PhpStorm.
	 * User: julyan
	 * Date: 19-10-2017
	 * Time: 13:40
	 */

	namespace Navbar;

	class Navbar implements INavigation
	{
		private $brand;
		private $url;
		private $position;
		private $color;
		private $navs;

		public function __construct($brand = SITE_NAME, $url = ROOT_URL, $position = NavbarPosition::StickyTop, NavbarColor $color) {
			$this->brand = $brand;
			$this->url = $url;
			$this->position = $position;
			$this->color = $color;
			$this->navs = array();
		}

		/**
		 * @return string
		 */
		public function getBrand() {
			return $this->brand;
		}

		/**
		 * @return NavbarColor
		 */
		public function getColor() {
			return $this->color;
		}

		/**
		 * @return string
		 */
		public function getUrl() {
			return $this->url;
		}

		/**
		 * @param Nav $nav
		 *
		 * @return int
		 */
		public function addNav(Nav $nav) {
			return array_push($this->navs, $nav);
		}

		public function toHTML() {
			switch ($this->getPosition()) {
				case NavbarPosition::StickyTop:
					$position = "sticky-top";
					break;

				case NavbarPosition::FixedTop:
					$position = "fixed-top";
					break;

				case NavbarPosition::FixedBottom:
					$position = "fixed-bottom";
					break;
			}

			return "";
		}

		/**
		 * @return int
		 */
		public function getPosition() {
			return $this->position;
		}

		/**
		 * @param string $id
		 *
		 * @return bool|mixed
		 */
		public function findById($id) {
			foreach ($this->getNavs() as $nav)
				if ($nav->findById($id))
					return $nav;

			return false;
		}

		/**
		 * @return array
		 */
		public function getNavs() {
			return $this->navs;
		}
	}