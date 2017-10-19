<?php
	/**
	 * Created by PhpStorm.
	 * User: julyan
	 * Date: 19-10-2017
	 * Time: 14:26
	 */

	namespace Navbar;

	class Nav extends NavObject
	{
		private $alignment;
		private $children;

		/**
		 * Nav constructor.
		 *
		 * @param int $alignment
		 */
		public function __construct($alignment = Alignment::Left) {
			$this->alignment = $alignment;
			$this->children = array();
		}

		/**
		 * @return string
		 */
		public function toHTML() {

		}

		/**
		 * @param NavObject $object
		 *
		 * @return bool|int
		 */
		public function addItem(NavObject $object) {
			if ($object instanceof Nav)
				return false;

			return array_push($this->children, $object);
		}

		public function findById($id) {
			if ($this->getId() == $id)
				return $this;

			foreach ($this->getItems() as $item)
				if ($item->findById($item))
					return $item;

			return false;
		}

		/**
		 * @return array
		 */
		public function getItems() {
			return $this->children;
		}
	}