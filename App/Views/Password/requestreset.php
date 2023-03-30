<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/css/new.css">
    <title>index</title>
</head>
<body>
<?php if (isset($_SESSION['user_id'])):
        header("Location: /posts/newsFeed");
        exit;
         else:?>
    <form action="/Password/checkOtp" method="POST">
        <h2>Please check your mail</h2>
        <label for="otp">OTP:</label>
        <input type="text" name="otp" id="otp" required >
        <input type="submit" value="Check OTP">

    </form>
    <?php endif; ?>
</body>
</html>
