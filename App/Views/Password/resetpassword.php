<?php use App\Flash; ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/css/new.css">
    <title>index</title>
    <script src="https://code.jquery.com/jquery-latest.min.js"></script>
    <script src="/js/new.js"></script>
</head>
<body>
<?php if (isset($_SESSION['user_id'])):
        header("Location: /posts/newsFeed");
        exit;
         else:?>
    <form action="/Password/reset" method="POST"> 
        <label for="repeat_password">Password</label>
        <input type="password" name="password" id="password" required pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$" title="Minimum 6 chars, at least one letter and number">
        <label for="repeat_password">Repeat Password</label>
        <input type="password" name="repeat_password" id="repeat_password" required>
        <input type="submit" value="Reset password">
</form>
<?php endif; ?>
</body>
</html>