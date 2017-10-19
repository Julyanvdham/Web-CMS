<?php
	/**
	 * Created by PhpStorm.
	 * User: julyan
	 * Date: 19-10-2017
	 * Time: 20:58
	 */

	namespace System;

	class User
	{
		private $ID;
		private $username;
		private $firstname;
		private $lastname;
		private $insertions;
		private $email;
		private $creationdate;
		private $lastmodified;
		private $rights;

		/**
		 * User constructor.
		 *
		 * @param int    $ID
		 * @param string $username
		 * @param string $firstname
		 * @param string $lastname
		 * @param string $insertions
		 * @param string $email
		 * @param string $creationdate
		 * @param string $lastmodified
		 * @param Rights $rights
		 */
		private function __construct($ID, $username, $firstname, $lastname, $insertions, $email, $creationdate, $lastmodified, Rights $rights) {
			$this->ID = $ID;
			$this->username = $username;
			$this->firstname = $firstname;
			$this->lastname = $lastname;
			$this->insertions = $insertions;
			$this->email = $email;
			$this->creationdate = $creationdate;
			$this->lastmodified = $lastmodified;
			$this->rights = $rights;
		}

		/**
		 * @param string $username
		 * @param string $password
		 *
		 * @return bool|User
		 */
		public static function GetFromLogin($username = '', $password = '') {
			$crypter = new Crypt();
			$crypt_password = $crypter->Encrypt($password);

			$query = Database::PreparedQuery("SELECT * FROM users WHERE username=? AND password=? LIMIT 1", "ss", $username, $crypt_password);
			if (!$query || Database::IsEmpty($query))
				return false;

			$row = Database::FetchAssoc($query);

			return new User($row['ID'], $row['username'], $row['firstname'], $row['lastname'], $row['insertions'], $row['email'], $row['creation_date'], $row['last_modified'], Rights::GetFromUsername($username));
		}

		/**
		 * @param $username
		 *
		 * @return bool|User
		 */
		public static function GetFromUsername($username) {
			$query = Database::PreparedQuery("SELECT * FROM users WHERE username=? LIMIT 1", "s", $username);
			if (!$query || Database::IsEmpty($query))
				return false;

			$row = Database::FetchAssoc($query);

			return new User($row['ID'], $row['username'], $row['firstname'], $row['lastname'], $row['insertions'], $row['email'], $row['creation_date'], $row['last_modified'], Rights::GetFromUsername($username));
		}

		/**
		 * @return bool|User
		 */
		public static function GetCurrent() {
			if (!isset($_SESSION['user']))
				return false;

			return unserialize($_SESSION['user']);
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
		public function getUsername() {
			return $this->username;
		}

		/**
		 * @return string
		 */
		public function getFullname() {
			return join(" ", array($this->getFirstname(), $this->getInsertions(), $this->getLastname()));
		}

		/**
		 * @return string
		 */
		public function getFirstname() {
			return $this->firstname;
		}

		/**
		 * @return string
		 */
		public function getInsertions() {
			return $this->insertions;
		}

		/**
		 * @return string
		 */
		public function getLastname() {
			return $this->lastname;
		}

		/**
		 * @return string
		 */
		public function getLastModified() {
			return $this->lastmodified;
		}

		/**
		 * @return string
		 */
		public function getCreationDate() {
			return $this->creationdate;
		}

		/**
		 * @return Rights
		 */
		public function getRights() {
			return $this->rights;
		}

		/**
		 * Get either a Gravatar URL or complete image tag for a specified email address.
		 *
		 * @param int    $s    Size in pixels, defaults to 80px [ 1 - 2048 ]
		 * @param string $d    Default imageset to use [ 404 | mm | identicon | monsterid | wavatar | retro ]
		 * @param string $r    Maximum rating (inclusive) [ g | pg | r | x ]
		 * @param bool   $img  True to return a complete IMG tag False for just the URL
		 * @param array  $atts Optional, additional key/value attributes to include in the IMG tag
		 *
		 * @return String containing either just a URL or a complete image tag
		 * @source https://gravatar.com/site/implement/images/php/
		 */
		public function getGravatar($s = 80, $d = 'retro', $r = 'g', $img = false, $atts = array()) {
			$email = $this->getEmail();
			$url = 'https://www.gravatar.com/avatar/';
			$url .= md5(strtolower(trim($email)));
			$url .= "?s=$s&d=$d&r=$r";
			if ($img) {
				$url = '<img src="' . $url . '"';
				foreach ($atts as $key => $val)
					$url .= ' ' . $key . '="' . $val . '"';
				$url .= ' />';
			}

			return $url;
		}

		/**
		 * @return string
		 */
		public function getEmail() {
			return $this->email;
		}
	}