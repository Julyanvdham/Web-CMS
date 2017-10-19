<?php
	/**
	 * Created by PhpStorm.
	 * User: julyan
	 * Date: 19-10-2017
	 * Time: 17:55
	 */

	use System\ShortcodeHandler;
	use Thunder\Shortcode\Shortcode\ShortcodeInterface;

	ShortcodeHandler::AddHandler('youtube', function (ShortcodeInterface $s) {
		$url = $s->getParameter('url');
		if (is_null($url))
			$url = $s->getContent();

		if (is_null($url))
			return "";

		parse_str(parse_url($url, PHP_URL_QUERY), $parts);

		if (!isset($parts['v']))
			return "";

		$vid = $parts['v'];
		$embed_url = "https://www.youtube-nocookie.com/embed/$vid";

		return "<div class='embed-responsive embed-responsive-16by9'><iframe class='embed-responsive-item' src='$embed_url' allowfullscreen></iframe></div>";
	});