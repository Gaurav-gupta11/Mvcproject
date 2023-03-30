<?php use App\Flash; ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/css/new.css">
    <script src="https://code.jquery.com/jquery-latest.min.js"></script>
    <script src="/js/profile.js"></script>
    <title>Home</title>
</head>
<body>
<form action="/Items/update" method="post" enctype="multipart/form-data">
   <label for="profile_pic">Profile Picture (JPG format only):</label>
   <input type="file" id="profile_pic" name="profile_pic" ><br><br>

  <label for="name">Name:</label>
  <input type="text" id="name" name="name" value="<?php echo $user['name'];?>"><br><br>

  <label for="email">Email:</label>
  <input type="email" id="email" name="email" value="<?php echo $user['email'];?>"><br><br>

  <label for="password">Password:</label>
  <input type="password" id="password" name="password"><br><br>

  <input type="submit" value="Submit"><br>
  <?php  if (isset($_SESSION['flash_notifications'])) {
        foreach($_SESSION['flash_notifications'] as $row){
          echo $row;
          Flash::getMessages();
        }
    }?>
</form>

</body>
</html>
