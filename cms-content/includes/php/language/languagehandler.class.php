<?php
	/**
	 * Created by PhpStorm.
	 * User: julyan
	 * Date: 19-10-2017
	 * Time: 21:48
	 */

	namespace System;

	class LanguageHandler
	{
		const LANG_DIR = __DIR__ . DIRECTORY_SEPARATOR . "lang_files";

		/**
		 * @param string $key
		 * @param array  ...$args
		 *
		 * @return string
		 */
		public static function GetKeyTranslationFormat($key = '', ...$args) {
			$key = self::GetKeyTranslation($key);
			array_unshift($args, $key);

			return call_user_func_array("sprintf", $args);
		}

		/**
		 * @param string $key
		 *
		 * @return string
		 */
		public static function GetKeyTranslation($key = '') {
			$handle = fopen(self::LANG_DIR . "/" . self::GetLanguage() . ".lang", 'r');
			while (($line = fgets($handle)) !== false) {
				$tkey = self::SplitKey($line);
				if ($tkey[0] == $key)
					return $tkey[1];
			}
			fclose($handle);

			return "UNDEFINED KEY";
		}

		/**
		 * @return string
		 */
		public static function GetLanguage() {
			preg_match_all(
				'/([a-z]{1,8})' .       // M1 - First part of language e.g en
				'(_[a-z]{1,8})*\s*' .   // M2 -other parts of language e.g _us
				// Optional quality factor M3 ;q=, M4 - Quality Factor
				'(;\s*q\s*=\s*((1(\.0{0,3}))|(0(\.[0-9]{0,3}))))?/i',
				$_SERVER['HTTP_ACCEPT_LANGUAGE'],
				$langParse);
			if (isset($langParse[0]) && count($langParse[0]) >= 2)
				if (isset($langParse[0][0]) && isset($langParse[0][1]) && file_exists(self::LANG_DIR . "/" . strtolower($langParse[0][0] . "_" . $langParse[0][1]) . ".lang"))
					return strtolower($langParse[0][0] . "_" . $langParse[0][1]);

			return "en_us";
		}

		/**
		 * @param $key
		 *
		 * @return array
		 */
		private static function SplitKey($key) {
			return explode('=', $key, 2);
		}
	}