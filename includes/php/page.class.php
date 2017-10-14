<?php
	/**
	 * Created by PhpStorm.
	 * User: julyan
	 * Date: 10-10-2017
	 * Time: 16:15
	 */

	namespace Page;

	use System\Database;
	use System\MessageHandler;
	use System\MessageType;
	use System\User;

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

		public function toHTML() {
			if (file_exists(APP_TEMPLATES . "/page.php")) {
				$content = file_get_contents(APP_TEMPLATES . "/page.php");
				$content = str_replace("%%TITLE%%", $this->getTitle(), $content);
				$content = str_replace("%%CONTENT%%", htmlspecialchars_decode($this->getContent()), $content);
				$content = str_replace("%%AUTHOR%%", $this->getAuthor()->getUsername(), $content);
				$content = str_replace("%%CREATIONDATE%%", $this->getCreationDate(), $content);
				$content = str_replace("%%LASTMODIFIED%%", $this->getLastModified(), $content);
				$content = str_replace("%%SLUG%%", $this->getSlug(), $content);

				return $content;
			} else
				return "
					<div class='card'>
						<div class='card-body'>
							<h4 class='card-title'>" . $this->getTitle() . "</h4>
							<div class='card-text'>
								" . htmlspecialchars_decode($this->getContent()) . "
							</div>
						</div>
					</div>
				";
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

			$row = Database::FetchAssoc(Database::PreparedQuery("SELECT * FROM pages WHERE ID=? LIMIT 1", "i", $id));

			if (isset($row))
				return new Page($row['title'], $row['slug'], $row['content'], User::GetFromID($row['author']), $row['creation_date'], $row['last_modified']);
			else
				MessageHandler::pushMessage("A page with the ID $id cannot be found.");

			return false;
		}

		/**
		 * @param string $slug
		 *
		 * @return bool|Page
		 */
		public static function GetFromSlug($slug = '') {
			$slug = Database::RealEscapeString($slug);

			if (!isset($slug))
				return false;

			$row = Database::FetchAssoc(Database::PreparedQuery("SELECT * FROM pages WHERE slug=? LIMIT 1", "s", $slug));

			if (isset($row))
				return new Page($row['title'], $row['slug'], $row['content'], User::GetFromID($row['author']), $row['creation_date'], $row['last_modified']);
			else
				MessageHandler::pushMessage("A page with the slug $slug cannot be found.");

			return false;
		}
	}