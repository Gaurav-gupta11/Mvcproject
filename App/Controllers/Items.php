<?php

namespace App\Controllers;

use \App\Models\User;
use Core\View;
use \App\Flash;

/**
 * Defines the Items controller.
 */
class Items extends \Core\Controller {

  /**
   * Runs before all methods in the Items controller.
   *
   * @return void
   *   The required login.
   */
  protected function before() {
    $this->requiredLogin();
  }

  /**
   * Displays the index page.
   *
   * @return void
   *   The rendered output of the index page.
   */
  public function indexAction() {
    $user = static::getUSer();
    View::render('Items/index.php', ['user' => $user]);
  }

  /**
   * Displays the edit page.
   *
   * @return void
   *   The rendered output of the edit page.
   */
  public function editAction() {
    $user = static::getUSer();
    View::render('Items/edit.php', ['user' => $user]);
  }

  /**
   * Updates an item.
   *
   * @return void
   *   Redirects to the index page.
   */
  public function updateAction() {
    if(self::checkEmailAction($_POST['email'])){
      $user = new User($_POST);
      if ($user->update($_FILES)) {
        header('Location: /Items/index');
      }
    }
    else{
			Flash::addMessage('Email does not exist');
					header('Location: /Items/edit');
		}
	}
}
?>


