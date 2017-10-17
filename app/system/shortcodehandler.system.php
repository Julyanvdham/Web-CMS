<?php
	/**
	 * Created by PhpStorm.
	 * User: julyan
	 * Date: 17-10-2017
	 * Time: 14:14
	 */

	namespace System;

	use Thunder\Shortcode\ShortcodeFacade;
	use Thunder\Shortcode\Shortcode\ShortcodeInterface;

	class ShortcodeHandler
	{
		private static $handler = false;

		/**
		 *  ShortcodeHandler Initializer
		 */
		public static function Init() {
			self::AddHandler('youtube', function (ShortcodeInterface $s) {
				$url = $s->getParameter('url');

				if (is_null($url))
					return "";

				parse_str(parse_url($url, PHP_URL_QUERY), $parts);

				if (!isset($parts['v']))
					return "";

				$vid = $parts['v'];
				$embed_url = "https://www.youtube-nocookie.com/embed/$vid";

				return "<div class='embed-responsive embed-responsive-16by9'><iframe class='embed-responsive-item' src='$embed_url' allowfullscreen></iframe></div>";
			});

			self::AddHandler('userprofile', function (ShortcodeInterface $s) {
				$align = $s->getParameter("align", "left");
				if ($align == "left")
					$align = "float-left";
				elseif ($align == "right")
					$align = "float-right";

				$username = $s->getParameter('username', 'admin');
				if (is_null($username)) {
					$user = User::GetCurrentUser();
					if (!$user)
						return "";
				} else {
					$user = User::GetFromUsername($username);
				}

				if ($user)
					return "
				<div class='card d-inline-block $align'>
					<div class='card-body'>
						<div class='text-center'>
							<img src='" . $user->getGravatar(128) . "' class='rounded-circle'>
						</div>
						<hr>
						<strong>" . $user->getUsername() . "</strong><br>
						" . $user->getFullName() . "<br>
						<a href='mailto:" . $user->getEmail() . "'>" . $user->getEmail() . "</a><br>
						<small>Member since " . $user->getCreationdate() . "</small>
					</div>
				</div>
			";

				return "<div>Unable to find user with username '$username'</div>";
			});

			self::AddHandler('spoiler', function (ShortcodeInterface $s) {
				$content = $s->getContent();
				if (is_null($content))
					return "";

				$title = $s->getParameter('title', "Spoiler");
				if (!is_null($title))
					$title = "Spoiler: $title";

				$guid = \System::GetGUID(true);

				return "
					<div>
						<button class='btn btn-outline-dark' type='button' data-toggle='collapse' data-target='#collapse_$guid'>$title</button>
						<div class='collapse' id='collapse_$guid'><div class='card card-body mt-2'>$content</div></div>
					</div>
				";
			});

			self::AddHandler('sitetitle', function () {
				return SITE_TITLE;
			});

			self::AddHandler('badge', function (ShortcodeInterface $s) {
				$content = $s->getParameter("value");
				if (is_null($content))
					$content = "Badge";

				return "<span class='badge badge-secondary'>$content</span>";
			});

			self::AddHandler('code', function (ShortcodeInterface $s) {
				$content = $s->getContent();
				if (is_null($content))
					return "";

				return "<pre><code>$content</code></pre>";
			});
		}

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