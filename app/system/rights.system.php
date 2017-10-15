<?php
	/**
	 * Created by PhpStorm.
	 * User: julyan
	 * Date: 10-10-2017
	 * Time: 22:43
	 */

	namespace System;

	class Rights
	{
		private $is_admin = false;
		private $can_create_pages = false;
		private $can_delete_pages = false;
		private $can_modify_pages = false;
		private $can_create_users = false;
		private $can_delete_users = false;
		private $can_modify_users = false;

		/**
		 * Rights constructor.
		 *
		 * @param bool $is_admin
		 * @param bool $can_create_pages
		 * @param bool $can_delete_pages
		 * @param bool $can_modify_pages
		 * @param bool $can_create_users
		 * @param bool $can_delete_users
		 * @param bool $can_modify_users
		 */
		protected function __construct($is_admin = false, $can_create_pages = false, $can_delete_pages = false, $can_modify_pages = false, $can_create_users = false, $can_delete_users = false, $can_modify_users = false)
		{
			$this->is_admin = $is_admin;
			$this->can_create_pages = $can_create_pages;
			$this->can_delete_pages = $can_delete_pages;
			$this->can_modify_pages = $can_modify_pages;
			$this->can_create_users = $can_create_users;
			$this->can_delete_users = $can_delete_users;
			$this->can_modify_users = $can_modify_users;
		}

		/**
		 * @return bool
		 */
		public function isAdmin()
		{
			return $this->is_admin;
		}

		/**
		 * @return bool
		 */
		public function canCreatePages()
		{
			return $this->can_create_pages;
		}

		/**
		 * @return bool
		 */
		public function canDeletePages()
		{
			return $this->can_delete_pages;
		}

		/**
		 * @return bool
		 */
		public function canModifyPages()
		{
			return $this->can_modify_pages;
		}

		/**
		 * @return bool
		 */
		public function canCreateUsers()
		{
			return $this->can_create_users;
		}

		/**
		 * @return bool
		 */
		public function canDeleteUsers()
		{
			return $this->can_delete_users;
		}

		/**
		 * @return bool
		 */
		public function canModifyUsers()
		{
			return $this->can_modify_users;
		}

		/**
		 * @param string $username
		 * @return bool|Rights
		 */
		public static function GetFromUsername($username = '') {
			$row = Database::FetchAssoc(Database::PreparedQuery("SELECT * FROM view_user_rights WHERE username=? LIMIT 1", "s", $username));
			if (isset($row)) {
				return new Rights($row['is_admin'] == 1, $row['can_create_pages'] == 1, $row['can_delete_pages'] == 1, $row['can_modify_pages'] == 1, $row['can_create_users'] == 1, $row['can_delete_users'] == 1, $row['can_modify_users'] == 1);
			}

			return false;
		}
	}