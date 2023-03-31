<?php

namespace App;

/**
 * Application configuration
 *
 */
class Config
{

	/**
	 * Database host
	 * @var string
	 */
	const DB_HOST = 'localhost';

	/**
	 * Database name
	 * @var string
	 */
	const DB_NAME = 'mvclogin';

	/**
	 * Database user
	 * @var string
	 */
	const DB_USER = 'gaurav';

	/**
	 * Database password
	 * @var string
	 */
	const DB_PASSWORD = 'Gaurav@123';

	/** 
   * Whether to show or hide error messages on screen.
   *
   * @var boolean
   */
	const SHOW_ERRORS = false;

	/**
	 * The SMTP host for sending emails.
	 *
	 * @var string
	 */
	const SMTP_HOST = 'smtp.gmail.com';

	/**
	 * The SMTP port for sending emails.
	 *
	 * @var int
	 */
	const SMTP_PORT = 465;

	/**
	 * The SMTP username for authentication.
	 *
	 * @var string
	 */
	const SMTP_USERNAME = 'gauravrocksd5@gmail.com';

	/**
	 * The SMTP password for authentication.
	 *
	 * @var string
	 */
	const SMTP_PASSWORD = 'aoculiwjcnrqixfv';

	/**
	 * The SMTP encryption method.
	 *
	 * @var string
	 */
	const SMTP_ENCRYPTION = 'ssl';

	/**
	 * The SMTP  method.
	 *
	 * @var string
	 */
	const SMTP_FROM_EMAIL = 'your-sender@your-domain.com';
}
?>