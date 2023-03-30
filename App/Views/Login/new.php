<?php use App\Flash;
use App\Controllers\Password; ?>
<!DOCTYPE html>
<html>
<head>
  <title>Login Page</title>
  <link rel="stylesheet" href="/css/new.css">
</head>
<body>
<?php if (isset($_SESSION['user_id'])):
        header("Location: /posts/newsFeed");
        exit;
         else:?>
  <form action="/Login/create" method="POST">
    <h2>Login</h2>
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" value="<?php echo isset($email) ? $email : ''; ?>" required ><br>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required><br>
    <input type="submit" value="Login"><br>
    <a href="/password/forget">Forgot Password?</a>
    <span>New user?</span>
    <a href="/signup/new" class="button">Signup</a><br><br>
    <?php endif; ?>
  <?php  if (isset($_SESSION['flash_notifications'])) {
        foreach($_SESSION['flash_notifications'] as $row){
          echo $row;
          Flash::getMessages();
        }
    }?>
</form>
</body>
</html>