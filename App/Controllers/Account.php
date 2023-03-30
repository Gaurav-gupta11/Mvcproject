<?php

namespace App\Controllers;

use \App\Models\User;

/**
 * Defines the Account controller.
 *
 * @ingroup app_controllers
 */
class Account extends \Core\Controller {

  /**
   * Validates if an email is available via AJAX for a new signup.
   *
   * @return void
   *   The JSON-encoded result of the validation.
   *
   * @throws \InvalidArgumentException
   *   Thrown if the required email parameter is not provided.
   */
  public function validateEmailAction() {
    if (!isset($_GET['email'])) {
      throw new \InvalidArgumentException('The email parameter is required.');
    }

    $is_valid = !User::emailExists($_GET['email'], $_GET['ignore_id'] ?? NULL);

    header('Content-Type: application/json');
    echo json_encode($is_valid);
  }

  /**
   * Gets the current session user ID.
   *
   * @return void
   *   The user ID stored in the session.
   */
  public function getSessionAction() {
    $session = $_SESSION['user_id'];
    echo $session;
  }

  

}
