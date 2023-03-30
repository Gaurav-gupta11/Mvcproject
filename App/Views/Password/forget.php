<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/css/new.css">
    <title>Password reset</title>
</head>
<body>
<?php if (isset($_SESSION['user_id'])):
        header("Location: /posts/newsFeed");
        exit;
         else:?>
    <form action="/Password/requestreset" method="post">
        <h2>Request password reset</h2>
        <label for="inputEmail">Email</label>
        <input type="email" id="inputEmail" name="email" placeholder="Email address" required>
        <input type="submit" value="Password reset">
        <a href = "/login/new">Back to Login Page</a>
    </form>
    <?php endif; ?>
</body>
</html>