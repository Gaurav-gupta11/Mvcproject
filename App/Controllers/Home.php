<?php

namespace App\Controllers;

use \Core\View;

/**
 * Defines the Home controller
 */
class Home extends \Core\Controller {

  /**
   * {@inheritdoc}
   */
  protected function before() {
    // This method is empty intentionally.
  }

  /**
   * {@inheritdoc}
   */
  protected function after() {
    // This method is empty intentionally.
  }

  /**
   * Displays the index page.
   *
   * @return void
   *   The rendered output of the index page.
   */
  public function indexAction() {
    $user = static::getUSer();
    View::render('Home/index.php', ['user' => $user]);
  }
}
