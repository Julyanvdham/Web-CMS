<?php
	/**
	 * Created by PhpStorm.
	 * User: julyan
	 * Date: 19-10-2017
	 * Time: 17:47
	 */

	namespace System;

	use Thunder\Shortcode\ShortcodeFacade;

	class ShortcodeHandler
	{
		private static $facade = false;

		/**
		 * @param string $content
		 *
		 * @return string
		 */
		public static function Process($content = '') {
			return self::GetFacade()->process($content);
		}

		/**
		 * @return ShortcodeFacade
		 */
		public static function GetFacade() {
			if (self::$facade == false)
				self::$facade = new ShortcodeFacade();

			return self::$facade;
		}

		/**
		 * @param string   $name
		 * @param callable $function
		 *
		 * @return bool
		 */
		public static function AddHandler($name = '', callable $function) {
			try {
				self::GetFacade()->addHandler($name, $function);

				return true;
			} catch (Exception $e) {
				append_log("An error has occured: " . $e->getTraceAsString());
			}

			return false;
		}
	}