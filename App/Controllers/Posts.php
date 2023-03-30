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
class Posts extends Controller {

  /**
   * Function to call before executing any action.
   */
  protected function before() {
    $this->requiredLogin();
  }

  /**
   * Displays the activity view.
   */
  public function activityAction() {
    View::render('Posts/activity.php');
  }

  /**
   * Updates the activity.
   */
  public function updateActivityAction() {
    $post = new Postsdb($_POST);
    if ($post->updateActivity($_FILES)) {
      header('Location: /Posts/newsFeed');
    }
  }

  /**
   * Displays user's activity view.
   */
  public function myActivityAction() {
    $post = static::getPosts();
    View::render('Posts/myActivity.php', ['post' => $post]);
  }

  /**
   * Displays the activity edit view.
   */
  public function editAction() {
    $this->idFetch($_SERVER['REQUEST_URI']);
    $post = static::getActivity();
    View::render('Posts/editActivity.php', ['post' => $post]);
  }

  /**
   * Extracts the post ID from the URL.
   */
  public function idFetch($url) {
    // Parse the URL to get its different parts.
    $url_parts = parse_url($url);

    // Get the path of the URL.
    $path = $url_parts['path'];

    // Extract the post ID from the path using regular expressions.
    $pattern = '/\/Posts\/(\d+)\/(\w+)/';
    if (preg_match($pattern, $path, $matches)) {
      // The post ID is in the first captured group.
      $post_id = $matches[1];
      $_SESSION['post_id'] = $post_id;
    }
  }

  /**
   * Updates the post activity.
   */
  public function editActivityAction() {
    $post = new Postsdb($_POST);
    if ($post->updatePostActivity($_FILES)) {
      header('Location: /Posts/myActivity');
    }
  }

  /**
   * Deletes the post activity.
   */
  public function deleteAction() {
    $this->idFetch($_SERVER['REQUEST_URI']);
    if (Postsdb::deletePostActivity() === TRUE) {
      header('Location: /Posts/myActivity');
    }
  }

  /**
   * Displays the news feed view.
   */
  public function newsFeedAction() {
    $post = Postsdb::showAllPosts();
    View::render('Posts/newsFeed.php', ['post' => $post]);
  }



}
