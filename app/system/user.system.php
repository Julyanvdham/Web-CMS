<?php
	/**
	 * Created by PhpStorm.
	 * User: julyan
	 * Date: 10-10-2017
	 * Time: 22:43
	 */

	namespace System;

	class User
	{
		private $id;
		private $username;
		private $firstname;
		private $lastname;
		private $insertions;
		private $email;
		private $password;
		//TODO: rights

		/**
		 * User constructor.
		 *
		 * @param int    $id
		 * @param string $username
		 * @param string $firstname
		 * @param string $lastname
		 * @param string $insertions
		 * @param string $email
		 * @param string $password
		 */
		protected function __construct($id, $username, $firstname, $lastname, $insertions, $email, $password) {
			$this->id = $id;
			$this->username = $username;
			$this->firstname = $firstname;
			$this->lastname = $lastname;
			$this->insertions = $insertions;
			$this->email = $email;
			$this->password = $password;
		}

		/**
		 * @return int
		 */
		public function getId() {
			return $this->id;
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
		public function getEmail() {
			return $this->email;
		}

		/**
		 * @return mixed
		 */
		public function getPassword() {
			return $this->password;
		}

		/**
		 * @return string
		 */
		public function getFirstName() {
			return $this->firstname;
		}

		/**
		 * @return string
		 */
		public function getLastName() {
			return $this->lastname;
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
		public function getFullName() {
			return join(' ', array($this->getFirstName(), $this->getInsertions(), $this->getLastName()));
		}

		/**
		 * Get either a Gravatar URL or complete image tag for a specified email address.
		 *
		 * @param string $email The email address
		 * @param int    $s     Size in pixels, defaults to 80px [ 1 - 2048 ]
		 * @param string $d     Default imageset to use [ 404 | mm | identicon | monsterid | wavatar | retro ]
		 * @param string $r     Maximum rating (inclusive) [ g | pg | r | x ]
		 * @param bool   $img   True to return a complete IMG tag False for just the URL
		 * @param array  $atts  Optional, additional key/value attributes to include in the IMG tag
		 *
		 * @return String containing either just a URL or a complete image tag
		 * @source https://gravatar.com/site/implement/images/php/
		 */
		public function getGravatar($email, $s = 80, $d = 'retro', $r = 'g', $img = false, $atts = array()) {
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
		 * @return bool|Rights
		 */
		public function getRights() {
			return Rights::GetFromUsername($this->getUsername());
		}

		public function toSession() {
			$_SESSION['user'] = array(
				'username'   => $this->getUsername(),
				'firstname'  => $this->getFirstName(),
				'lastname'   => $this->getLastName(),
				'insertions' => $this->getInsertions(),
				'email'      => $this->getEmail(),
				'fullname'   => $this->getFullName(),
				'id'         => $this->getId(),
				'password'   => $this->getPassword(),
			);
		}

		/**
		 * @param int $id
		 *
		 * @return bool|User
		 */
		public static function GetFromID($id = 0) {
			$row = Database::FetchAssoc(Database::PreparedQuery("SELECT * FROM users WHERE ID=? LIMIT 1", "i", $id));
			if ($row)
				return new User($row['ID'], $row['username'], $row['firstname'], $row['lastname'], $row['insertions'], $row['email'], $row['password']);
			else
				MessageHandler::pushMessage("A user with the ID $id cannot be found!");

			return false;
		}

		/**
		 * @param string $username
		 *
		 * @return bool|User
		 */
		public static function GetFromUsername($username = '') {
			$row = Database::FetchAssoc(Database::PreparedQuery("SELECT * FROM users WHERE username=? LIMIT 1", "s", $username));
			if ($row)
				return new User($row['ID'], $row['username'], $row['firstname'], $row['lastname'], $row['insertions'], $row['email'], $row['password']);
			else
				MessageHandler::pushMessage("A user with the username $username cannot be found.");

			return false;
		}

		/**
		 * @return bool|User
		 */
		public static function GetCurrentUser() {
			if (isset($_SESSION['user']))
				return new User($_SESSION['user']['id'], $_SESSION['user']['username'], $_SESSION['user']['firstname'], $_SESSION['user']['lastname'], $_SESSION['user']['insertions'], $_SESSION['user']['email'], $_SESSION['user']['password']);

			return false;
		}
	}