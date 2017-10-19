<?php
	/**
	 * Created by PhpStorm.
	 * User: julyan
	 * Date: 19-10-2017
	 * Time: 21:00
	 */

	namespace System;

	class Database
	{
		/**
		 * @param string $query
		 *
		 * @return bool|\mysqli_result
		 */
		public static function Query($query = '', $resultmode = MYSQLI_NUM) {
			$db = self::getConnection();
			if ($db->connect_error) {
				append_log("Unable to connect to database: " . $db->connect_error);

				return false;
			}

			$query = $db->query($db->real_escape_string($query), $resultmode);
			$db->close();

			if ($query)
				return $query;

			append_log("A database error has occured: " . $db->error);

			return false;
		}

		/**
		 * @return \mysqli
		 */
		private static function getConnection() {
			return new \mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT);
		}

		/**
		 * @param string $query
		 * @param string $type
		 * @param array  ...$args
		 *
		 * @return bool|\mysqli_result
		 */
		public static function PreparedQuery($query = '', $type = '', ...$args) {
			$db = self::getConnection();

			$l_args = array();
			foreach ($args as $key => $value)
				$l_args[$key] = &$args[$key];

			$prepared = $db->prepare($query);
			$ref = new \ReflectionClass('mysqli_stmt');
			$method = $ref->getMethod('bind_param');
			$method->invokeArgs($prepared, array_merge(array($type), $args));

			if (!$prepared->execute()) {
				append_log("A database error has occured: " . $prepared->error);

				return false;
			}

			$result = $prepared->get_result();
			$db->close();

			return $result;
		}

		/**
		 * @param \mysqli_result $result
		 * @param int            $resulttype
		 *
		 * @return mixed
		 */
		public static function FetchAll(\mysqli_result $result, $resulttype = MYSQLI_NUM) {
			return $result->fetch_all($resulttype);
		}

		/**
		 * @param \mysqli_result $result
		 *
		 * @return array
		 */
		public static function FetchAssoc(\mysqli_result $result) {
			return $result->fetch_assoc();
		}

		/**
		 * @param \mysqli_result $result
		 *
		 * @return bool
		 */
		public static function IsEmpty(\mysqli_result $result) {
			return (!isset($result) || $result->num_rows == 0);
		}
	}