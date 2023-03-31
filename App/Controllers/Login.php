<?php

namespace App\Controllers;

use \Core\View;
use App\Models\User;
use \App\Flash;

/**
 * Defines the Login controller.
 */
class Login extends \Core\Controller {

  /**
   * Displays the login form.
   *
   * @return void
   *   The rendered output of the login form.
   */
  public function newAction() {
    View::render('Login/new.php');
  }

  /**
   * Authenticates the user and logs them in.
   *
   * @return void
   *   Redirects to the news feed page or the login page with an error message.
   */
  public function createAction() {
    $user = User::authenticate($_POST['email'], $_POST['password']);
    if ($user) {
      session_regenerate_id(true);
      $_SESSION['user_id'] = $user->id;
      $_SESSION['id']= $user->id;
      if (!empty($_SESSION['return_to'])) {
        $request = $_SESSION['return_to'];
        header('Location:' . $request);
        exit;
      }
      header('Location: /Posts/newsFeed');
      exit;
    }
    else {
      Flash::addMessage('Login unsuccessful Wrong password or email');
      View::render('Login/new.php', ['email' => $_POST['email']]);
    }
  }

  /**
   * Logs the user out.
   *
   * @return void
   *   Redirects to the logout confirmation page.
   */
  public function destroyAction() {
    // Unset all of the session variables.
    $_SESSION = array();
    // If it's desired to kill the session, also delete the session cookie.
    // Note: This will destroy the session, and not just the session data!
    if (ini_get("session.use_cookies")) {
      $params = session_get_cookie_params();
      setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
      );
      header('Location: /login/showLogout');
    }
    // Finally, destroy the session.
    session_destroy();
    header('Location: /Login/showLogout');
  }

  /**
   * Displays the logout confirmation page.
   *
   * @return void
   *   The rendered output of the logout confirmation page.
   */
  public function showLogoutAction() {
    Flash::addMessage('Logout successful');
    header('Location: /Home/index');
    exit;
  }

}
