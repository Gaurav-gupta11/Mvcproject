<?php
/**
 * @file
 * Contains \App\Controllers\Posts.
 */

namespace App\Controllers;

use \Core\View;
use \App\Models\User;
use \App\Flash;

/**
 * Signup controller
 *
 * @category Controllers
 * @package  App\Controllers
 */
class Signup extends \Core\Controller
{

	/**
	 * Renders the sign up form
	 *
	 * @return void
	 */
	public function newAction()
	{
		View::render('Signup/new.php');
	}
	
	/**
	 * Creates a new user account
	 *
	 * @return void
	 */
	public function createAction()
	{
		if(self::checkEmailAction($_POST['email'])){
			$user = new User($_POST);
			if($user->save()) {
				$email = $_POST['email'];
				echo $email;
					Flash::addMessage('Account created sucessfully');
					header('Location: /Login/new');
			}
			else{
					View::render('Signup/new.php',[
							'user' => $user
					]);
			}
		}
		else{
			Flash::addMessage('Email does not exist');
					header('Location: /Signup/new');
		}
	}	

}
?>