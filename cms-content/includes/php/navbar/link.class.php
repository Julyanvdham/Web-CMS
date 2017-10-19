<?php
	/**
	 * Created by PhpStorm.
	 * User: julyan
	 * Date: 19-10-2017
	 * Time: 16:21
	 */

	namespace Navbar;

	class Link extends NavObject
	{
		private $text;
		private $url;

		/**
		 * Link constructor.
		 *
		 * @param string $text
		 * @param string $url
		 */
		public function __construct($text = '', $url = '#') {
			parent::__construct();

			$this->text = $text;
			$this->url = $url;
		}

		/**
		 * @return string
		 */
		public function toHTML() {
			$url = $this->getUrl();
			$text = $this->getText();

			return "<li class='nav-item'><a class='nav-link' href='$url'>$text</a></li>";
		}

		/**
		 * @return string
		 */
		public function getUrl() {
			return $this->url;
		}

		/**
		 * @return string
		 */
		public function getText() {
			return $this->text;
		}

		/**
		 * @param string $id
		 *
		 * @return $this|bool
		 */
		public function findById($id) {
			if ($id == $this->getId())
				return $this;

			return false;
		}
	}