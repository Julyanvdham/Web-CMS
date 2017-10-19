<?php
	/**
	 * Created by PhpStorm.
	 * User: julyan
	 * Date: 19-10-2017
	 * Time: 13:54
	 */

	namespace Navbar;

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
		public function __construct($text = '', $alignment = Alignment::Left) {
			parent::__construct($text);

			$this->children = array();
			$this->alignment = $alignment;
		}

		/**
		 * @param Link $link
		 *
		 * @return int
		 */
		public function addLink(Link $link) {
			return array_push($this->children, $link);
		}

		public function toHTML() {
			$id = $this->getId();
			$text = $this->getText();

			$links = "";
			foreach ($this->getLinks() as $link)
				$links .= "<a class='dropdown-item' href='" . $link->getUrl() . "'>" . $link->getText() . "</a>";

			$alignment = $this->getAlignment() == Alignment::Left ? "" : "dropdown-menu-right";

			return "
				<li class='nav-item dropdown'>
			        <a class='nav-link dropdown-toggle' href='#' id='dropdown_$id' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
			          $text
			        </a>
			        <div class='dropdown-menu $alignment' aria-labelledby='dropdown_$id'>
			        	$links
					</div>
				</li>
			";
		}

		public function findById($id) {
			if ($this->getId() == $id)
				return $this;

			foreach ($this->getLinks() as $link)
				if ($link->findById($id))
					return $link;

			return false;
		}

		/**
		 * @return array
		 */
		public function getLinks() {
			return $this->children;
		}

		/**
		 * @return int
		 */
		public function getAlignment() {
			return $this->alignment;
		}
	}