<?php

/**
 * @file
 * Contains the Postsdb model class.
 */

namespace App\Models;

use \Core\View;
use \App\Mail;

/**
 * Defines the Postsdb model class.
 */
class Postsdb extends \Core\Model {

  /**
   * The post name.
   *
   * @var string
   */
  protected $name;

  /**
   * The post status.
   *
   * @var string
   */
  protected $status;

  /**
   * The user email.
   *
   * @var string
   */
  protected $email;

  /**
   * The user password.
   *
   * @var string
   */
  protected $password = "";

  /**
   * The user profile picture.
   *
   * @var string
   */
  protected $profile_pic;

  /**
   * The post ID.
   *
   * @var int
   */
  public $id;

  /**
   * The repeated password.
   *
   * @var string
   */
  protected $repeat_password;

  /**
   * The hashed password.
   *
   * @var string
   */
  protected $password_hash;

  /**
   * The list of errors.
   *
   * @var array
   */
  public $errors = [];

  /**
   * Constructs a Postsdb object.
   *
   * @param array $data
   *   The data to populate the object with.
   */
  public function __construct($data =[]){
    foreach ($data as $key => $value) {
        $this->{$key} = $value;
    }
  }

   /**
   * Updates a user's activity.
   *
   * @param array $data
   *   The data to update the activity with.
   *
   * @return bool
   *   TRUE if the update was successful, otherwise FALSE.
   */
  public function updateActivity($data = []){
    if (!empty($_FILES['profile_pic']['name'])) {
      $img_name = $_FILES['profile_pic']['name'];
      $image = $_FILES['profile_pic']['tmp_name'];
      $imgData = addslashes(file_get_contents($image));
    }
        
    $db = self::getDB();
    $status = mysqli_real_escape_string($db, $this->status);
    $id = $_SESSION['user_id'];

    if (!empty($_FILES['profile_pic']['name'])) {
      $sql = "INSERT INTO posts (user_id, status, img_name, image) VALUES ($id, '$status', '$img_name', '$imgData')";
    } else {
      $sql = "INSERT INTO posts (user_id, status) VALUES ($id, '$status')";
    }

    return mysqli_query($db, $sql);
  }

  /**
   * Finds posts by ID.
   *
   * @param int $id
   *   The user ID to search for.
   *
   * @return array
   *   An array of matching posts.
   */
  public static function findByIDPosts($id){
    $db = static::getDB();
    $sql = "SELECT * FROM posts WHERE user_id='$id'";
    $result = mysqli_query($db, $sql);
    $data=[];

    while ($row = mysqli_fetch_assoc($result)) {
      array_push($data, $row);
    }
    return $data;
  }

  /**
   * Retrieves a post by its ID.
   *
   * @param int $id
   *   The ID of the post to retrieve.
   *
   * @return array
   *   An array of post data.
   */
  public static function findByIDActivity($id){
    $db = static::getDB();
    $sql = "SELECT * FROM posts WHERE post_id='$id'";
    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row;
  }

  /**
   * Updates a post.
   *
   * @param array $data
   *   An array of post data.
   *
   * @return bool
   *   TRUE if the update was successful, otherwise FALSE.
   */

  public function updatePostActivity($data = []){
    if (!empty($_FILES['profile_pic']['name'])) {
      $img_name = $_FILES['profile_pic']['name'];
      $image = $_FILES['profile_pic']['tmp_name'];
      $imgData = addslashes(file_get_contents($image));
    }
    $db = static::getDB();
    $status = mysqli_real_escape_string($db, $this->status);
    $post_id = $_SESSION['post_id'];
    $sql = "UPDATE posts SET status = '$status'" .
           (empty($img_name) ? "" : ", img_name='$img_name'") .
           (empty($imgData) ? "" : ", image='$imgData'") .
           "WHERE post_id = '$post_id'";
    return mysqli_query($db, $sql);
  }

  /**
   * Deletes a post.
   *
   * @return bool
   *   TRUE if the post was deleted, otherwise FALSE.
   */
  public static function deletePostActivity(){
    $db = static::getDB();
    $post_id = $_SESSION['post_id'];
    $sql = "DELETE from posts where post_id='$post_id'";
    $result = mysqli_query($db, $sql);
    if ($result) {
      return true;
    } 
    else {
      echo "Error deleting record: " . mysqli_error($db);
      return false;
    }
  }

  /**
   * Retrieves all posts.
   *
   * @return array
   *   An array of post data.
   */
  public static function showAllPosts(){
    $db = static::getDB();
    $sql = "SELECT posts.*, users.name ,users.image_name , users.img
            FROM posts
            INNER JOIN users
            ON posts.user_id = users.id;";
    $result = mysqli_query($db, $sql);
    $data=[];
    while ($row = mysqli_fetch_assoc($result)) {
        array_push($data, $row);
    }
    return $data;
  }
}
?>