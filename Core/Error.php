<?php
namespace Core;

/**
 * The Error class contains methods for handling errors and exceptions in the application.
 */
class Error{

	/**
	 * Handles PHP errors by throwing an \ErrorException exception.
	 *
	 * @param int $level The error level.
	 * @param string $message The error message.
	 * @param string $file The filename where the error occurred.
	 * @param int $line The line number where the error occurred.
	 * @throws \ErrorException
	 */
	public static function errorHandler($level, $message, $file, $line){
		if(error_reporting() !== 0){
				throw new \ErrorException($message, 0, $level, $file, $line);

		}
	}

	/**
   * Handles uncaught exceptions in the application.
   *
   * @param \Exception $exception The uncaught exception.
   */
	public static function exceptionHandler($exception){
		$code = $exception->getCode();
		if ($code != 404) {
			$code = 500;
		}
		http_response_code($code);
		if (\App\Config::SHOW_ERRORS) {
			echo "<h1>Fatal error</h1>";
			echo "<p>Uncaught exception: '" . get_class($exception) . "'</p>";
			echo "<p>Message: '" . $exception->getMessage() . "'</p>";
			echo "<p>Stack trace:<pre>" . $exception->getTraceAsString() . "</pre></p>";
			echo "<p>Thrown in '" . $exception->getFile() . "' on line " . $exception->getLine() . "</p>";
		} else {
			$log = dirname(__DIR__) . '/logs/' . date('Y-m-d') . '.txt';
			ini_set("log_errors", 1);
			ini_set('error_log', $log);

			$message = "Uncaught exception: '" . get_class($exception) . "'";
			$message .= " with message '" . $exception->getMessage() . "'";
			$message .= "\nStack trace: " . $exception->getTraceAsString();
			$message .= "\nThrown in '" . $exception->getFile() . "' on line " . $exception->getLine();

			error_log($message);
			//echo "<h1>An error occurred</h1>";
			if ($code == 404) {
				echo "<h1>Page not found</h1>";
			} else {
				echo "<h1>An error occurred</h1>";
			}
		}
	}
}
?>