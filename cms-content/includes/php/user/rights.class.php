<?php
	/**
	 * Created by PhpStorm.
	 * User: julyan
	 * Date: 19-10-2017
	 * Time: 21:24
	 */

	namespace System;

	class Rights
	{
		private $ID;
		private $name;
		private $rights;

		/**
		 * Rights constructor.
		 *
		 * @param int    $ID
		 * @param string $name
		 * @param array  $rights
		 */
		protected function __construct($ID, $name, $rights) {
			$this->ID = $ID;
			$this->name = $name;
			$this->rights = $rights;
		}

		/**
		 * @param string $username
		 *
		 * @return bool|Rights
		 */
		public static function GetFromUsername($username = '') {
			$query = Database::PreparedQuery("SELECT * FROM view_username_rights WHERE username=? LIMIT 1", "s", $username);

			if (!$query || Database::IsEmpty($query))
				return false;

			$row = Database::FetchAssoc($query);
			$ID = $row['ID'];
			$name = $row['name'];

			unset($row['ID'], $row['name'], $row['user_id'], $row['username']);

			return new Rights($ID, $name, $row);
		}

		/**
		 * @param string $role
		 *
		 * @return bool|Rights
		 */
		public static function GetFromRole($role = '') {
			$query = Database::PreparedQuery("SELECT * FROM view_username_rights WHERE name=? LIMIT 1", "s", $role);

			if (!$query || Database::IsEmpty($query))
				return false;

			$row = Database::FetchAssoc($query);
			$ID = $row['ID'];
			$name = $row['name'];

			unset($row['ID'], $row['name'], $row['user_id'], $row['username']);

			return new Rights($ID, $name, $row);
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
		public function getName() {
			return $this->name;
		}

		/**
		 * @return array
		 */
		public function getRightsArray() {
			return $this->rights;
		}

		/**
		 * @param string $right
		 *
		 * @return bool
		 */
		public function hasRight($right = '') {
			if (isset($this->rights[$right]) && $this->rights[$right] == 1)
				return true;

			return false;
		}
	}