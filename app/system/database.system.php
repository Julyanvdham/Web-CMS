<?php
	/**
	 * Created by PhpStorm.
	 * User: julyan
	 * Date: 10-10-2017
	 * Time: 16:28
	 */

	namespace System;

	class Database
	{
		/**
		 * @param string $query
		 * @param int    $resultmode
		 *
		 * @return bool|\mysqli_result
		 */
		public static function Query($query, $resultmode = MYSQLI_STORE_RESULT) {
			$db = new \mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME, DB_PORT);
			if ($db->connect_error) {
				MessageHandler::pushMessage($db->connect_error);

				return false;
			}

			$result = $db->query($db->real_escape_string($query), $resultmode);

			if ($db->error) {
				MessageHandler::pushMessage($db->error);

				return false;
			}

			$db->close();

			return $result;
		}

		/**
		 * @param mysqli_result $query
		 *
		 * @return mixed
		 */
		public static function FetchAssoc(mysqli_result $query) {
			return $query->fetch_assoc();
		}

		/**
		 * @param \mysqli_result $query
		 * @param int            $resulttype
		 *
		 * @return mixed
		 */
		public static function FetchAll(\mysqli_result $query, $resulttype = MYSQLI_NUM) {
			return $query->fetch_all($resulttype);
		}

		/**
		 * @param \mysqli_result $query
		 *
		 * @return bool
		 */
		public static function IsEmpty(\mysqli_result $query) {
			return $query->num_rows > 0;
		}

		public static function RealEscapeString($input = '') {
			$db = new \mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME, DB_PORT);
			if ($db->connect_error) {
				MessageHandler::pushMessage($db->connect_error);

				return false;
			}

			$result = $db->real_escape_string($input);
			$db->close();

			return $result;
		}
	}