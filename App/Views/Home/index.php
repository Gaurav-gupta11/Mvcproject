<?php
/**
 * @file
 * Template file for the homepage.
 *
 */
 
use App\Flash; // Use statement for the Flash class.

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Home</title>
  <link rel="stylesheet" href="/css/index.css">
</head>
<body>
  <h1>Welcome</h1>

  <?php if (isset($_SESSION['user_id'])):
    // If the user is logged in, redirect them to the newsFeed page and exit.
    header("Location: /posts/newsFeed");
    exit;
  else:?>
    <!-- If the user is not logged in, show Signup and Login links. -->
    <a href="/Signup/new">Signup</a>
    <a href="/Login/new">Login</a><br><br>
  <?php endif; ?>

  <?php
    // Check for any flash notifications and display them.
    if (isset($_SESSION['flash_notifications'])) {
      foreach($_SESSION['flash_notifications'] as $row){
        echo $row;
        Flash::getMessages();
      }
    }
  ?>
</body>
</html>
