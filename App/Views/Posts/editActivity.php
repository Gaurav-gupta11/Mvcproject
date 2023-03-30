<?php use App\Flash; ?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="/css/new.css">
    <meta charset="UTF-8">
    <title>Home</title>
</head>
<body>
    <?php if(isset($_SESSION['post_id'])):
       //var_dump($post);?>
    <form method="POST" action="/Posts/editActivityAction" enctype="multipart/form-data">
    <h1>What's to change</h1>  
    <label for="profile_pic">Profile Picture (JPG format only):</label>
   <input type="file" id="profile_pic" name="profile_pic" ><br><br> 
     <label for="status">Status:</label>
    <textarea id="status" name="status" rows="4" cols="60"><?php echo $post['status'];?></textarea><br><br>
    <input type="submit" value="Update">
    <?php endif; ?>
</form>

</body>
</html>
