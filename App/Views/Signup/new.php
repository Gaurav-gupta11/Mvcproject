<?php use App\Flash; ?>
<!DOCTYPE html>
<html>
<head>
  <title>Sign Up Form</title>
  <link rel="stylesheet" href="/css/new.css">
  <script src="https://code.jquery.com/jquery-latest.min.js"></script>
  <script src="/js/new.js"></script>
</head>
<body>
<?php if (isset($_SESSION['user_id'])):
        header("Location: /posts/newsFeed");
        exit;
         else:?>
  <form method="post" action="/Signup/create">
    <h2>Sign Up</h2>
    <label for="name">Name</label>
    <input type="text" name="name" id="name" required >
    <label for="email">Email</label>
    <input type="email" name="email" id="email" required type="email">
    <label for="password">Password</label>
    <input type="password" name="password" id="password" required pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$" title="Minimum 6 chars, at least one letter and number">
    <label for="repeat_password">Repeat Password</label>
    <input type="password" name="repeat_password" id="repeat_password" required>
    <input type="submit" value="Sign Up">
    <a href = "/login/new">Back to Login Page</a>
    <?php  if (isset($_SESSION['flash_notifications'])) {
        foreach($_SESSION['flash_notifications'] as $row){
          echo $row;
          Flash::getMessages();
        }
    }?>
  </form>
  <?php endif; ?>
  <?php if (!empty($user->errors)){
          foreach($user->errors as $error){
            echo"<li>";echo $error;echo"</li><br>";
          }
        }
  ?>
  
</body>
</html>
