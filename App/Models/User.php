<?php

/**
 * @file
 * Contains the User model.
 */

namespace App\Models;

use Core\Model;
use mysqli;

/**
 * Defines the User model.
 */
class User extends Model {

  /**
   * The user's name.
   *
   * @var string
   */
  protected $name;

  /**
   * The user's title.
   *
   * @var string
   */
  protected $title;

  /**
   * The user's status.
   *
   * @var string
   */
  protected $status;

  /**
   * The user's email address.
   *
   * @var string
   */
  protected $email;

  /**
   * The user's password.
   *
   * @var string
   */
  protected $password = '';

  /**
   * The user's profile picture.
   *
   * @var string
   */
  protected $profile_pic;

  /**
   * The user's ID.
   *
   * @var int
   */
  public $id;

  /**
   * The user's repeated password.
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
   * An array of error messages.
   *
   * @var array
   */
  public $errors = [];

  /**
   * Constructs a User object.
   *
   * @param array $data
   *   An array of data for the User object.
   */
  public function __construct($data =[]) {
    foreach ($data as $key => $value) {
      $this->{$key} = $value;
  	}
  }

	/**
   * Saves the user data to the database.
   *
   * @return bool
   *   TRUE if the data was successfully saved, FALSE otherwise.
   */
	public function save() {
    $this->validate();
    if (empty($this->errors)) {
      $password_hash = password_hash($this->password, PASSWORD_DEFAULT);
		  $db = self::getDB();
      $name = mysqli_real_escape_string($db, $this->name);
      $email = mysqli_real_escape_string($db, $this->email);
      $password_hash = mysqli_real_escape_string($db, $password_hash);
      $this->password_hash = $password_hash;
    	$sql = "INSERT INTO users (name, email, password_hash)
              VALUES ('$name', '$email', '$password_hash')";
				return mysqli_query($db, $sql);
    	}
      	return false;
    }

	/**
   * Validates the user data.
   */
  public function validate() {
		if ($this->name == '') {
			$this->errors[] = 'Name is required';
		}

		if (filter_var($this->email, FILTER_VALIDATE_EMAIL) === false) {
			$this->errors[] = 'Invalid email';
		}

		if ($this->password != $this->repeat_password) {
			$this->errors[] = 'Password must match comnfirmation';
		}
		if (static::emailExists($this->email)) {
			$this->errors[] = 'Email already taken';
		}
	}

	/**
   * Checks if the given email exists in the database.
   *
   * @param string $email
   *   The email to check.
   * @param int|null $ignoreId
   *   The ID to ignore.
   *
   * @return bool
   *   TRUE if the email exists, FALSE otherwise.
   */
  public static function emailExists($email, $ignore_id = null) {
		$user = static::findByEmail($email);
		if ($user) {
			if ($user->id != $ignore_id) {
				return true;
			}
		}
		return false;
	}

	/**
   * Gets a user object by email.
   *
   * @param string $email
   *   The email to search for.
   *
   * @return object|null
   *   A user object if found, NULL otherwise.
   */
  public static function findByEmail($email) {
		$db = static::getDB();
		$email = mysqli_real_escape_string($db, $email);
		$sql = "SELECT * FROM users WHERE email='$email'";
		$result = mysqli_query($db, $sql);
		$row = mysqli_fetch_assoc($result);

		// Convert the row to an object
		$user = null;
		if ($row) {
			$user = new static();
			foreach ($row as $key => $value) {
					$user->$key = $value;
			}
		}

		return $user;
  }

  /**
   * Authenticates a user by email and password.
   *
   * @param string $email
   *   The user's email address.
   * @param string $password
   *   The user's password.
   *
   * @return object|false
   *   A user object if authenticated, FALSE otherwise.
   */
  public static function authenticate($email, $password) {
    $user = static::findByEmail($email);
      if($user) {
        if(password_verify($password, $user->password_hash)) { 
            return $user;
        }
      }
      return false;
  }

	/**
   * Gets a user object by ID.
   *
   * @param int $id
   *   The ID of the user to search for.
   *
   * @return object|null
   *   A user object if found, NULL otherwise.
   */
  public static function findByID($id) {
    $db = static::getDB();
    $sql = "SELECT * FROM users WHERE id='$id'";
    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_assoc($result);
      return $row;
  }

	/**
   * Starts a password reset for the current user.
   *
   * @param string $password
   *   The new password to set.
   *
   * @return bool
   *   TRUE if successful, FALSE otherwise.
   */
  public static function startPasswordReset($password) {
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $email = $_SESSION['email'];
    $db = static::getDB();
    $sql = "UPDATE users SET password_hash = '$password_hash' WHERE email = '$email'";
      return mysqli_query($db, $sql);    
  }

	/**
   * Updates a user object.
   *
   * @param array $data
   *   An array of data to update.
   *
   * @return bool
   *   TRUE if successful, FALSE otherwise.
   */
  public  function update($data = []) {
    if(empty($this->password)) {
      if(!empty($_FILES['profile_pic']['name'])) {
        $img_name = $_FILES['profile_pic']['name'];
        $image = $_FILES['profile_pic']['tmp_name'];
        $imgData = addslashes(file_get_contents($image)); 
      }        
      $db = self::getDB();
      $name = mysqli_real_escape_string($db, $this->name);
      $email = mysqli_real_escape_string($db, $this->email);
      $id = $_SESSION['user_id'];
      $sql = "UPDATE users SET name='$name', email='$email' " .
             (empty($img_name) ? "" : ", image_name='$img_name'") .
             (empty($imgData) ? "" : ", img='$imgData'") .
             "WHERE id=$id";
        return mysqli_query($db, $sql);     
    }
    else {
      if(!empty($_FILES['profile_pic']['name'])){         
				$img_name = $_FILES['profile_pic']['name'];
				$image = $_FILES['profile_pic']['tmp_name'];
				$imgData = addslashes(file_get_contents($image));
			}
      $password_hash = password_hash($this->password, PASSWORD_DEFAULT);
      $db = self::getDB();
      $name = mysqli_real_escape_string($db, $this->name);
      $email = mysqli_real_escape_string($db, $this->email);
      $id = $_SESSION['user_id'];
      $password_hash = mysqli_real_escape_string($db, $password_hash);
      $sql = "UPDATE users SET name='$name', email='$email' " .
             (empty($img_name) ? "" : ", image_name='$img_name'") .
             (empty($imgData) ? "" : ", img='$imgData'") .
             "WHERE id=$id";
      return mysqli_query($db, $sql);        
    }
  }

  public static function searchActivity($data){
    $name = $data['search-query'];
    $db = self::getDB();
    $id = $_SESSION['user_id'];
    $sql = "SELECT * FROM users 
    WHERE name = '$name' AND id != '$id'";
    $result = mysqli_query($db, $sql);
    $data =[];
    while ($row = mysqli_fetch_assoc($result)) {
      array_push($data, $row);
  }
  return $data;  
  }
}
?>