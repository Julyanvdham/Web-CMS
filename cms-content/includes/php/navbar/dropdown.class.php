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

		public function __construct($text = '') {
			parent::__construct($text);

			$this->children = array();
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
	}