<?php

namespace Core;

use \App\Models\User;
use \App\Models\Postsdb;
use \App\Flash;

/**
 * Provides a base controller for all other controllers to extend from.
 */
abstract class Controller
{
	/**
	 * Parameters from the matched route.
	 *
	 * @var array
	 */
	protected $route_params = [];

	/**
	 * Class constructor.
	 *
	 * @param array $route_params
	 *   Parameters from the route.
	 */
	public function __construct($route_params) {
		$this->route_params = $route_params;
	}

	/**
	 * Magic method called when a non-existent or inaccessible method is
	 * called on an object of this class. Used to execute before and after
	 * filter methods on action methods. Action methods need to be named
	 * with an "Action" suffix, e.g. indexAction, showAction etc.
	 *
	 * @param string $name
	 *   Method name.
	 * @param array $args
	 *   Arguments passed to the method.
	 *
	 * @throws \Exception
	 *   Throws an exception if the method is not found in the controller.
	 */
	public function __call($name, $args) {
		$method = $name . 'Action';
		if (method_exists($this, $method)) {
			if ($this->before() !== false) {
					call_user_func_array([$this, $method], $args);
					$this->after();
			}
		} else {
			throw new \Exception("Method $method not found in controller " . get_class($this));
		}
	}

	/**
	 * Before filter - called before an action method.
	 */
	protected function before()
	{
	}

	/**
	 * After filter - called after an action method.
	 */
	protected function after()
	{
	}

	/**
	 * Checks if the user is logged in. If not, redirects to the login page.
	 */
	public function requiredLogin() {
		if (!isset($_SESSION['user_id'])) {
			Flash::addMessage('Please Login first');
			$_SESSION['return_to'] = $_SERVER['REQUEST_URI'];
			header('Location: /Login/new');
			exit;
		}
	}

	/**
	 * Returns the currently logged in user.
	 *
	 * @return \App\Models\User|null
	 *   Returns the currently logged in user if available, otherwise null.
	 */
	public function getUser() {
		if (isset($_SESSION['user_id'])) {
			return User::findByID($_SESSION['user_id']);
		}

		return null;
	}

	public function getUserSearch() {
		if (isset($_SESSION['id'])) {
			return User::findByID($_SESSION['id']);
		}

		return null;
	}

	/**
	 * Returns all posts for the currently logged in user.
	 *
	 * @return \App\Models\Postsdb[]
	 *   Returns an array of all posts for the currently logged in user.
	 */
	public function getPosts() {
		if (isset($_SESSION['user_id'])) {
			return Postsdb::findByIDPosts($_SESSION['user_id']);
		}

		return [];
	}

	/**
   * Returns the activity for a specific post.
	 *
	 */
	public function getActivity() {
		if (isset($_SESSION['post_id'])){
			return Postsdb::findByIDActivity($_SESSION['post_id']);
		}
	}

	public function searchUser() {
		//var_dump($_POST);
		if (isset($_POST)){
			return User::searchActivity($_POST);
		}
	}

	/**
	 *
	 * Returns information about an email using the Mailboxlayer API.
	 * 
	 * @return string
	 * The API response as a JSON string.
	 */
	public static function checkEmailAction($email){
		$curl = curl_init();
		// Set cURL options.
		curl_setopt_array($curl, array(
		CURLOPT_URL => "https://api.apilayer.com/email_verification/check?email=" . $email,
		CURLOPT_HTTPHEADER => array(
		"Content-Type: text/plain",
		"apikey: zeja8boNZvP6BSTkN76bQGJEqgRMJ3S8"
		),
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "GET",
		));
		
		// Execute the cURL request and store the response.
		$response = curl_exec($curl);
		
		$array = json_decode($response);
		
		// Close the cURL session.
		curl_close($curl);

		//var_dump($response);
		// Check if the email is valid using the SMTP check.
		if ($array->smtp_check == '1') {
			return true;
		}
		else {
			return false;

		}
	}
	
}
?>