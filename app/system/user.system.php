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
		 */
		protected function __construct($id, $username, $firstname, $lastname, $insertions, $email) {
			$this->id = $id;
			$this->username = $username;
			$this->firstname = $firstname;
			$this->lastname = $lastname;
			$this->insertions = $insertions;
			$this->email = $email;
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
		 * @param int $id
		 *
		 * @return bool|User
		 */
		public static function GetFromID($id = 0) {
			$id = intval($id) or MessageHandler::pushMessage('The ID Argument is not a valid integer!');
			if (!isset($id))
				return false;

			$row = Database::FetchAssoc(Database::Query("SELECT * FROM users WHERE ID=$id LIMIT 1"));
			if ($row)
				return new User($row['ID'], $row['username'], $row['firstname'], $row['lastname'], $row['insertions'], $row['email']);
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
			$username = Database::RealEscapeString($username);
			$row = Database::FetchAssoc(Database::Query("SELECT * FROM users WHERE username='$username' LIMIT 1"));
			if ($row)
				return new User($row['ID'], $row['username'], $row['firstname'], $row['lastname'], $row['insertions'], $row['email']);
			else
				MessageHandler::pushMessage("A user with the username $username cannot be found.");

			return false;
		}

		/**
		 * @return bool|User
		 */
		public static function GetCurrentUser() {
			if (isset($_SESSION['user']))
				return new User($_SESSION['user']['id'], $_SESSION['user']['username'], $_SESSION['user']['firstname'], $_SESSION['user']['lastname'], $_SESSION['username']['insertions'], $_SESSION['email']);

			return false;
		}
	}