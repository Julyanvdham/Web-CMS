<?php
	/**
	 * Created by PhpStorm.
	 * User: julyan
	 * Date: 10-10-2017
	 * Time: 16:15
	 */

	namespace Page;

	use \System\MessageHandler;
	use \System\MessageType;
	use \System\User;
	use \System\Database;

	class Page
	{
		private $title;
		private $slug;
		private $content;
		private $author;
		private $creationdate;
		private $lastmodified;

		/**
		 * Page constructor.
		 *
		 * @param string $title
		 * @param string $slug
		 * @param string $content
		 * @param User   $author
		 * @param        $creationdate
		 * @param        $lastmodified
		 */
		protected function __construct($title = '', $slug = '', $content = '', User $author, $creationdate, $lastmodified) {
			$this->title = $title;
			$this->slug = $slug;
			$this->content = $content;
			$this->author = $author;
			$this->creationdate = $creationdate;
			$this->lastmodified = $lastmodified;
		}

		/**
		 * @return User
		 */
		public function getAuthor() {
			return $this->author;
		}

		/**
		 * @return string
		 */
		public function getContent() {
			return $this->content;
		}

		/**
		 * @return string
		 */
		public function getTitle() {
			return $this->title;
		}

		/**
		 * @return string
		 */
		public function getSlug() {
			return $this->slug;
		}

		/**
		 * @return mixed
		 */
		public function getCreationDate() {
			return $this->creationdate;
		}

		/**
		 * @return mixed
		 */
		public function getLastModified() {
			return $this->lastmodified;
		}

		/**
		 * @param int $id
		 *
		 * @return bool|Page
		 */
		public static function GetFromID($id = 0) {
			$id = intval($id) or MessageHandler::pushMessage('The ID argument is not a number!', MessageType::Warning);
			if (!isset($id))
				return false;

			$row = Database::FetchAssoc(Database::Query("SELECT * FROM pages WHERE ID= LIMIT 1"));

			if (!Database::IsEmpty($row))
				return new Page();
			else
				MessageHandler::pushMessage("A page with the ID $id cannot be found.");

			return false;
		}
	}