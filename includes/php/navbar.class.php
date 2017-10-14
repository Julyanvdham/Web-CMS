<?php
	/**
	 * Created by PhpStorm.
	 * User: julyan
	 * Date: 9-10-2017
	 * Time: 14:41
	 */

	namespace Navbar;

	use System\Colors;

	class Navbar
	{
		private $fluid;
		protected $children;
		private $position;
		private $brand;
		private $color;

		/**
		 * Navbar constructor.
		 *
		 * @param int    $position
		 * @param string $brand
		 * @param bool   $fluid
		 * @param int    $color
		 */
		public function __construct($position = NavbarPosition::FixedTop, $brand = '', $fluid = false, $color = NavbarColor::Light) {
			$this->children = array();
			$this->position = $position;
			$this->brand = $brand;
			$this->fluid = $fluid;
			$this->color = $color;
		}

		/**
		 * Sets if the navbar should be fluid.
		 *
		 * @param boolean $fluid
		 */
		public function setFluid($fluid) {
			$this->fluid = $fluid;
		}

		/**
		 * Returns true if the navbar is fluid
		 * @return boolean
		 */
		public function isFluid() {
			return $this->fluid;
		}

		/**
		 * Returns true if the navbar is dark.
		 * @return bool
		 */
		public function getColor() {
			return $this->color;
		}

		/**
		 * Sets the brand of this navbar.
		 *
		 * @param string $brand
		 */
		public function setBrand($brand) {
			$this->brand = $brand;
		}

		/**
		 * Returns the brand of this navbar.
		 * @return string
		 */
		public function getBrand() {
			return $this->brand;
		}

		/**
		 * Sets the position of this navbar.
		 *
		 * @param NavbarPosition $position
		 */
		public function setPosition($position) {
			$this->position = $position;
		}

		/**
		 * Returns the position of this navbar.
		 * @return NavbarPosition
		 */
		public function getPosition() {
			return $this->position;
		}

		/**
		 * Adds an item to this navbar.
		 *
		 * @param Nav $item
		 *
		 * @return boolean|int
		 */
		public function addNav(Nav $item) {
			return array_push($this->children, $item);
		}

		/**
		 * Returns a list of all the navs in this navbar.
		 * @return array
		 */
		private function getNavs() {
			return $this->children;
		}

		/**
		 * Converts this navbar to HTML.
		 * @return string
		 */
		public function toHTML() {
			$child = "";
			foreach ($this->getNavs() as $nav) {
				$child .= $nav->toHTML();
			}

			$type = "";
			switch ($this->position) {
				case NavbarPosition::FixedTop:
					$type = "fixed-top";
					break;

				case NavbarPosition::FixedBottom:
					$type = "fixed-bottom";
					break;

				case NavbarPosition::StickyTop:
					$type = "sticky-top";
					break;
			}

			$color = "";
			$dynamic = "";
			$color_2 = "#" . array_keys(Colors::GetCommonColors(APP_FILES . "/bg.jpg", 2))[1];
			switch ($this->getColor()) {
				case NavbarColor::Light:
					$color = "bg-light";
					break;

				case NavbarColor::Dark:
					$color = "bg-dark navbar-dark";
					break;

				case NavbarColor::Dynamic:
					$color = "navbar-dark";
					$dynamic = "style='background-color: $color_2;'";
					break;

				case NavbarColor::Transparent:
					$color = "navbar-dark transparent";
					break;
			}

			return "
					<nav class='navbar $type navbar-expand-lg $color' $dynamic>
						<div class='" . ($this->fluid ? 'container' : '') . "'>
							" . (empty($this->brand) ? "" : "
							<a class='navbar-brand' href='" . ROOT_URL . "'>" . $this->brand . "</a>") . "
							<button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#navbar' aria-controls='navbar' aria-expanded='false' aria-label='Toggle navigation'>
							<span class='navbar-toggler-icon'></span>
							</button>
							<div class='collapse navbar-collapse' id='navbar'>
								$child
							</div>
						</div>
					</nav>
				";
		}

		/**
		 * @param string $id
		 *
		 * @return boolean|NavObject
		 */
		public function findItemById($id = '') {
			foreach ($this->getNavs() as $nav) {
				$item = $nav->findItemById($id);
				if ($item)
					return $item;
			}

			return false;
		}

		/**
		 * @param string $id
		 *
		 * @return bool
		 */
		public function removeItemById($id = '') {
			foreach ($this->getNavs() as $nav)
				if ($nav->removeItemById($id))
					return true;

			return false;
		}

		/**
		 * Loads a navbar from a file.
		 *
		 * @param string $filename
		 *
		 * @return bool|Navbar
		 */
		public static function Load($filename = '') {
			return unserialize(file_get_contents($filename));
		}

		/**
		 * Saves this navbar to a file.
		 *
		 * @param string $filename
		 *
		 * @return bool|int
		 */
		public function Save($filename = '') {
			return file_put_contents($filename, serialize($this));
		}
	}

	class NavObject
	{
		private $id;
		private $type;

		/**
		 * UniqueItem constructor.
		 */
		protected function __construct() {
			$this->id = self::getGUID();
		}

		/**
		 * Returns the ID of this NavObject
		 * @return string
		 */
		public function getId() {
			return $this->id;
		}

		/**
		 * Sets the type of this NavObject. (Can only be used once)
		 *
		 * @param int $type
		 *
		 * @return boolean
		 */
		public function setType($type) {
			if (!isset($this->type)) {
				$this->type = $type;

				return true;
			}

			return false;
		}

		/**
		 * Returns the type of this NavObject
		 * @return int
		 */
		public function getType() {
			return $this->type;
		}

		/**
		 * @param string $id
		 *
		 * @return bool|NavObject
		 */
		public function findItemById($id = '') {
			return $this->containsID($id, $this);
		}

		/**
		 * @param string    $id
		 * @param NavObject $item
		 *
		 * @return boolean|NavObject
		 */
		private function containsID($id = '', NavObject $item) {
			switch ($item->getType()) {
				case ItemType::Dropdown:
					foreach ($item->getItems() as $child)
						if ($child->getId() == $id)
							return $child;
					break;

				case ItemType::Nav:
					foreach ($item->getItems() as $child)
						if ($item->containsID($id, $child))
							return $child;
					break;

				case ItemType::Link:
					if ($item->getId() == $id)
						return $item;
					break;
			}

			return false;
		}

		/**
		 * @deprecated Not implemented yet
		 *
		 * @param string $id
		 *
		 * @return bool
		 */
		public function removeItemById($id = '') {
			switch ($this->getType()) {
				case ItemType::Dropdown:

					break;

				case ItemType::Link:

					break;
			}

			return false;
		}

		private static function getGUID() {
			if (function_exists('com_create_guid')) {
				return com_create_guid();
			} else {
				mt_srand((double)microtime() * 10000);//optional for php 4.2.0 and up.
				$charid = strtoupper(md5(uniqid(rand(), true)));
				$hyphen = chr(45);// "-"
				$uuid = chr(123)// "{"
					. substr($charid, 0, 8) . $hyphen
					. substr($charid, 8, 4) . $hyphen
					. substr($charid, 12, 4) . $hyphen
					. substr($charid, 16, 4) . $hyphen
					. substr($charid, 20, 12)
					. chr(125);// "}"
				return $uuid;
			}
		}

		public function toHTML() {
		}
	}

	class Nav extends NavObject
	{
		private $alignment;
		private $children;

		/**
		 * Nav constructor.
		 *
		 * @param int $alignment
		 */
		public function __construct($alignment = NavAlignment::Left) {
			parent::__construct();
			$this->alignment = $alignment;
			$this->children = array();
			$this->setType(ItemType::Nav);
		}

		/**
		 * @param NavObject $item
		 *
		 * @return boolean|int
		 */
		public function addItem(NavObject $item) {
			if ($item->getType() == ItemType::Nav)
				return false;

			return array_push($this->children, $item);
		}

		/**
		 * @return array
		 */
		public function getItems() {
			return $this->children;
		}

		/**
		 * @return int
		 */
		public function getAlignment() {
			return $this->alignment;
		}

		public function toHTML() {
			$alignment = "";

			switch ($this->getAlignment()) {
				case NavAlignment::Left:
					$alignment = 'ml-auto';
					break;

				case NavAlignment::Right:
					$alignment = 'mr-auto';
					break;
			}

			$child = "";
			foreach ($this->getItems() as $item) {
				$child .= $item->toHTML();
			}

			return "
					<ul class='navbar-nav $alignment'>
						$child
					</ul>
				";
		}
	}

	class Link extends NavObject
	{
		private $text;
		private $link;

		/**
		 * Link constructor.
		 *
		 * @param string $text
		 * @param string $link
		 */
		public function __construct($text, $link = '#') {
			parent::__construct();
			$this->text = $text;
			$this->link = $link;
			$this->setType(ItemType::Link);
		}

		/**
		 * @return string
		 */
		public function getLink() {
			return $this->link;
		}

		/**
		 * @param string $link
		 */
		public function setLink($link) {
			$this->link = $link;
		}

		/**
		 * @return string
		 */
		public function getText() {
			return $this->text;
		}

		/**
		 * @param string $text
		 */
		public function setText($text) {
			$this->text = $text;
		}

		/**
		 * Converts this NavObject to HTML
		 * @return string
		 */
		public function toHTML() {
			return "<li class='nav-item' id='" . $this->getId() . "'><a class='nav-link' href='" . $this->getLink() . "'>" . $this->getText() . "</a></li>";
		}
	}

	class Dropdown extends Link
	{
		private $children;
		private $alignment;

		/**
		 * Dropdown constructor.
		 *
		 * @param string $text
		 * @param int    $alignment
		 */
		public function __construct($text, $alignment = DropdownAlignment::DownLeft) {
			parent::__construct($text, '#');
			$this->children = array();
			$this->setType(ItemType::Dropdown);
			$this->alignment = $alignment;
		}

		/**
		 * @param Link $item
		 *
		 * @return boolean|int
		 */
		public function addItem(Link $item) {
			return array_push($this->children, $item);
		}

		/**
		 * @return array
		 */
		public function getItems() {
			return $this->children;
		}

		/**
		 * @return int
		 */
		public function getAlignment() {
			return $this->alignment;
		}

		/**
		 * @param int $alignment
		 */
		public function setAlignment($alignment) {
			$this->alignment = $alignment;
		}

		/**
		 * Converts this NavObject to HTML.
		 * @return string
		 */
		public function toHTML() {
			$temp = "";
			foreach ($this->getItems() as $item) {
				$temp .= "<a id='" . $item->getId() . "' class='dropdown-item' href='" . $item->getLink() . "'>" . $item->getText() . "</a>";
			}

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
							$temp
						</div>
					</li>
				";
		}
	}

	abstract class NavbarColor
	{
		const Light = 1;
		const Dark = 2;
		const Dynamic = 3;
		const Transparent = 4;
	}

	abstract class NavbarPosition
	{
		const FixedTop = 1;
		const FixedBottom = 2;
		const StickyTop = 3;
	}

	abstract class ItemType
	{
		const Dropdown = 1;
		const Link = 2;
		const Nav = 3;
	}

	abstract class NavAlignment
	{
		const Left = 1;
		const Right = 2;
	}

	abstract class DropdownAlignment
	{
		const DownLeft = 1;
		const DownRight = 2;
	}
