<?php
	/**
	 * Created by PhpStorm.
	 * User: julyan
	 * Date: 20-10-2017
	 * Time: 12:56
	 */

	namespace System;

	class Page
	{
		private $ID;
		private $title;
		private $slug;
		private $content;
		private $author;
		private $creationdate;
		private $lastmodified;

		/**
		 * Page constructor.
		 *
		 * @param int    $ID
		 * @param string $title
		 * @param string $slug
		 * @param string $content
		 * @param User   $author
		 * @param string $creationdate
		 * @param string $lastmodified
		 */
		private function __construct($ID, $title = '', $slug = '', $content = '', User $author, $creationdate, $lastmodified) {
			$this->ID = $ID;
			$this->title = $title;
			$this->slug = $slug;
			$this->content = $content;
			$this->author = $author;
			$this->creationdate = $creationdate;
			$this->lastmodified = $lastmodified;
		}

		/**
		 * @param string $slug
		 *
		 * @return bool|Page
		 */
		public static function GetFromSlug($slug = '') {
			$query = Database::PreparedQuery("SELECT * FROM view_pages WHERE slug=? LIMIT 1", "s", $slug);

			if (!$query || Database::IsEmpty($query))
				return false;

			$row = $query->fetch_assoc();

			return new Page($row['ID'], $row['title'], $row['slug'], $row['content'], User::GetFromUsername($row['username']), $row['creation_date'], $row['last_modified']);
		}

		public function toHTML() {
			$id = $this->getID();
			$title = $this->getTitle();
			$slug = $this->getSlug();
			$content = htmlspecialchars_decode($this->getContent());
			$author = $this->getAuthor()->getUsername();
			$creationdate = $this->getCreationDate();
			$lastmodified = $this->getLastModified();

			$page_link = sprintf(PAGES_URL, $slug);

			return "
				<div class='card pagecard'>
					<div class='card-header'><h4 class='card-title'><a class='text-dark' href='$page_link'>$title</a></h4></div>
					<div class='card-body'>
						$content
					</div>
					<div class='card-footer'>
						<a class='text-muted' data-toggle='collapse' href='#collapse_$id'>Details...</a>
						<div class='collapse' id='collapse_$id'>
							<small class='text-muted'>
								<strong>ID:</strong> $id<br>
								<strong>Title:</strong> $title<br>
								<strong>Slug:</strong> $slug<br>
								<strong>Author:</strong> $author<br>
								<strong>Creation Date:</strong> $creationdate<br>
								<strong>Last Modified:</strong> $lastmodified
							</small>
						</div>
					</div>
				</div>
			";
		}

		/**
		 * @return int
		 */
		public function getID() {
			return $this->ID;
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
		 * @return string
		 */
		public function getContent() {
			return $this->content;
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
		public function getCreationDate() {
			return $this->creationdate;
		}

		/**
		 * @return string
		 */
		public function getLastModified() {
			return $this->lastmodified;
		}
	}