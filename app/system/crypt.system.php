<?php
	/**
	 * Created by PhpStorm.
	 * User: jvjum
	 * Date: 6-10-2017
	 * Time: 10:00
	 */

	namespace System;
	class Crypt
	{
		private $password;
		private $method;
		private $iv;

		/**
		 * crypt constructor.
		 *
		 * @param string $password
		 * @param string $method
		 */
		public function __construct($password = CRYPT_PASSWORD, $method = 'aes-256-cbc')
		{
			$this->password = substr(hash('sha256', $password, true), 0, 32);
			$this->method = $method;
			$this->iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
		}

		/**
		 * @param string $input
		 *
		 * @return string
		 */
		public function Encrypt($input = '')
		{
			return base64_encode(openssl_encrypt($input, $this->method, $this->password, OPENSSL_RAW_DATA, $this->iv));
		}

		public function Decrypt($input = '')
		{
			return openssl_decrypt(base64_decode($input), $this->method, $this->password, OPENSSL_RAW_DATA, $this->iv);
		}
	}