<?php

namespace App;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Config;

/**
 * Mail
 *
 * PHP version 7.0
 */
class Mail
{

	/**
	 * Send a message
	 *
	 * @param string $to Recipient
	 * @param string $subject Subject
	 * @param string $text Text-only content of the message
	 * @param string $html HTML content of the message
	 *
	 * @throws Exception
	 *   Thrown if an error occurs while sending the email.
	 */
	public static function send($to, $subject, $text, $html)
	{
		$mail = new PHPMailer(true);
		$mail->isSMTP();
		$mail->Host = Config::SMTP_HOST;
		$mail->SMTPAuth = true;
		$mail->Username = Config::SMTP_USERNAME;
		$mail->Password = Config::SMTP_PASSWORD;
		$mail->SMTPSecure = Config::SMTP_ENCRYPTION;
		$mail->Port = Config::SMTP_PORT;

		$mail->setFrom(Config::SMTP_FROM_EMAIL);
		$mail->addAddress($to);
		$mail->isHTML(true);
		$mail->Subject = $subject;
		$mail->Body = $html;
		$mail->AltBody = $text;

		$mail->send();
	}
}
