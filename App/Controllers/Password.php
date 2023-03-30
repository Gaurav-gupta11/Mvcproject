<?php

/**
 * @file
 * Contains App\Controllers\Password.
 */

namespace App\Controllers;

use App\Mail;
use App\Models\User;
use App\Flash;
use Core\Controller;
use Core\View;

/**
 * Handles password management.
 */
class Password extends Controller {

  /**
   * Renders the forgot password view.
   */
  public function forgetAction() {
    View::render('Password/forget.php');
  }

  /**
   * Sends a password reset email.
   */
  public function requestResetAction() {
    if (isset($_POST['email'])) {
      $this->sendPasswordReset($_POST['email']);
      View::render('Password/requestreset.php');
    }
    else {
      header('Location: /Home/index');
    }
  }

  /**
   * Sends the password reset email.
   *
   * @param string $email
   *   The user's email.
   */
  public static function sendPasswordReset($email) {
    $user = User::findByEmail($email);
    if ($user) {
      $_SESSION['email'] = $email;
      $otp = rand(10000, 999999);
      $_SESSION['otp'] = $otp;
      $subject = "Password generated";
      $string = "Your password OTP is $otp";
      $html = "<h1>OTP is $otp</h1>";
      Mail::send($email, $subject, $string, $html);
    }
    else {
      Flash::addMessage('Email not found');
      header('Location: /Home/index');
    }
  }

  /**
   * Checks the OTP and redirects to the password reset form.
   */
  public function checkOtpAction() {
    if ($_SESSION['otp'] == $_POST['otp']) {
      header('Location: /Password/resetPassword');
      exit;
    }
    else {
      Flash::addMessage('Wrong OTP');
      header('Location: /Login/new');
    }
  }

  /**
   * Destroys the session.
   */
  public function destroySession() {
    // Unset all of the session variables.
    $_SESSION = array();
    // Flash::addMessage('Logout successful');
    // If it's desired to kill the session, also delete the session cookie.
    // Note: This will destroy the session, and not just the session data!
    if (ini_get("session.use_cookies")) {
      $params = session_get_cookie_params();
      setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
      );
    }

    // Finally, destroy the session.
    session_destroy();
  }

  /**
   * Renders the password reset view.
   */
  public function resetPasswordAction() {
    if (isset($_SESSION['email'])) {
      View::render('Password/resetpassword.php');
    }
    else {
      header('Location: /Home/index');
    }
  }

  /**
   * Resets the password.
   */
  public function resetAction() {
    $user = User::startPasswordReset($_POST['password']);
    $this->destroySession();
    if ($user) {
      Flash::addMessage('Password updated');
      header('Location: /Login/new');
      exit;
    }
    else {
      Flash::addMessage('Password not updated');
      header('Location: /Login/new');
      exit;
    }
  }

}
