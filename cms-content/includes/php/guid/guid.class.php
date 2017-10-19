<?php
	/**
	 * Created by PhpStorm.
	 * User: julyan
	 * Date: 19-10-2017
	 * Time: 13:42
	 */

	namespace System;

	class Guid
	{
		/**
		 * @param bool $short
		 *
		 * @return string
		 */
		public static function GetGUID($short = false) {
			if (function_exists('com_create_guid')) {
				return com_create_guid();
			} else {
				mt_srand((double)microtime() * 10000);//optional for php 4.2.0 and up.
				$charid = strtoupper(md5(uniqid(rand(), true)));
				$hyphen = chr(45);// "-"
				$uuid = chr(123)// "{"
					. substr($charid, 0, 8) . $hyphen
					. substr($charid, 8, 4) . $hyphen
					. substr($charid, 12, 4) . $hyphen
					. substr($charid, 16, 4) . $hyphen
					. substr($charid, 20, 12)
					. chr(125);// "}"
				if ($short)
					return explode('-', str_replace("{", "", str_replace("}", "", $uuid)))[0];
				else
					return $uuid;
			}
		}
	}