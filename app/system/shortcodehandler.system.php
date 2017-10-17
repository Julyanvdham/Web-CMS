<?php
	/**
	 * Created by PhpStorm.
	 * User: julyan
	 * Date: 17-10-2017
	 * Time: 14:14
	 */

	namespace System;

	use Thunder\Shortcode\ShortcodeFacade;

	class ShortcodeHandler
	{
		private static $handler = false;

		/**
		 * @return ShortcodeFacade
		 */
		public static function GetFacade() {
			if (self::$handler == false)
				self::$handler = new ShortcodeFacade();

			return self::$handler;
		}

		/**
		 * @param string $input
		 *
		 * @return string
		 */
		public static function Parse($input) {
			return self::GetFacade()->process($input);
		}

		/**
		 * @param string   $name
		 * @param callable $function
		 *
		 * @return ShortcodeFacade
		 */
		public static function AddHandler($name = '', callable $function) {
			return self::GetFacade()->addHandler($name, $function);
		}
	}