<?php
	/**
	 * Created by PhpStorm.
	 * User: julyan
	 * Date: 9-10-2017
	 * Time: 21:37
	 */

	namespace System;

	if (session_status() == PHP_SESSION_NONE)
		session_start();

	if (!isset($_SESSION['messages']))
		$_SESSION['messages'] = array();

	class MessageHandler
	{
		/**
		 * @param string $content
		 * @param int    $messagetype
		 */
		public static function pushMessage($content = '', $messagetype = MessageType::Danger) {
			array_push($_SESSION['messages'], array(
				'type'    => $messagetype,
				'content' => $content,
			));
		}

		public static function getMessages() {
			return $_SESSION['messages'];
		}

		/**
		 * @param bool $clear_existing
		 *
		 * @return string
		 */
		public static function getMessagesAsHTML($clear_existing = false) {
			$messages = self::getMessages();

			if ($clear_existing)
				$_SESSION['messages'] = array();

			$result = "";

			foreach ($messages as $message) {
				switch ($message['type']) {
					case MessageType::Danger:
						$type = 'danger';
						break;

					case MessageType::Success:
						$type = 'success';
						break;

					case MessageType::Warning:
						$type = 'warning';
						break;

					case MessageType::Primary:
						$type = 'primary';
						break;
				}
				$result .= "
						<div class='alert alert-$type fade show' role='alert'>
							<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
							    <span aria-hidden='true'>&times;</span>
							</button>
							" . $message['content'] . "
						</div>
					";
			}

			return $result;
		}
	}

	abstract class MessageType
	{
		const Danger = 1;
		const Success = 2;
		const Warning = 3;
		const Primary = 4;
	}