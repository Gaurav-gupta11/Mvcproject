<?php
/**
 * @file
 * Contains \App\Controllers\Posts.
 */

namespace App\Controllers;

use App\Models\Postsdb;
use App\Models\User;
use Core\Controller;
use Core\View;

/**
 * Controller class for Posts.
 */
class Search extends Controller {
  public function newAction() {
    View::render('Search/new.php');
  }

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
   * Displays the search results.
   *
   * @return void
   *   The rendered view of the search results.
   */
  public function searchAction() {
		$user = static::searchUSer();
		View::render('Search/new.php', ['user' => $user]);
  }

  /**
   * Fetches the id of the user from the url.
   *
   * @param string $url
   *   The url from which to extract the id.
   *
   * @return void
   *   The id of the user.
   */
	public function idFetch($url) {
    // Parse the URL to get its different parts.
    $url_parts = parse_url($url);

    // Get the path of the URL.
    $path = $url_parts['path'];
    // Extract the post ID from the path using regular expressions.
    $pattern = '/\/Search\/(\d+)\/(\w+)/';
    if (preg_match($pattern, $path, $matches)) {
      // The post ID is in the first captured group.
      $id = $matches[1];
      $_SESSION['id'] = $id;
    }
  }
    
  /**
   * Displays the user profile.
   *
   * @return void
   *   The rendered view of the user profile.
   */
  public function profileAction() {
    $this->idFetch($_SERVER['REQUEST_URI']);
    $user = static::getUSerSearch();
    View::render('Items/index.php', ['user' => $user]);
  }

}