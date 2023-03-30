<?php use App\Flash; ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link rel="stylesheet" href="/css/feed.css">
</head>
<body>
<?php if (isset($_SESSION['user_id'])): ?>
    <header>
		<nav>
			<a href="/Posts/newsFeed" class="nav-link">
				<img src="/images/home.png" alt="Home" class="nav-icon">
				<span class="nav-text">Home</span>
			</a>
			<a href="/items/index" class="nav-link">
				<img src="/images/profile.png" alt="Profile" class="nav-icon">
				<span class="nav-text">Profile</span>
			</a>
			<a href="/Login/destroy" class="nav-link">
				<img src="/images/logout.png" alt="Logout" class="nav-icon">
				<span class="nav-text">Logout</span>
			</a>
		</nav>
	</header>
	<main>
		<form method="POST" action="/Posts/updateActivity" enctype="multipart/form-data">
			<h1 class="form-title">What's on your mind?</h1>   
			<div class="form-group">
				<label for="profile_pic" class="form-label">Profile Picture (JPG format only):</label>
				<input type="file" id="profile_pic" name="profile_pic" class="form-control">
			</div>
			<div class="form-group">
				<label for="status" class="form-label">Status:</label>
				<textarea id="status" name="status" rows="4" class="form-control"></textarea>
			</div>
			<button type="submit" class="form-btn">Post</button>
		</form>
	</main>

    <?php if (isset($post)): ?>
  <div class="posts-container">
    <?php foreach ($post as $post): ?>
      <div class="post">
        <div class="post-header">
          <?php if (!empty($post['img'])): ?>
            <?php $image = base64_encode($post['img']); ?>
            <img src="data:image/jpg;base64,<?= $image ?>" class="post-image">
          <?php endif; ?>
          <h2 class="post-title"><?= $post['name'] ?></h2>
        </div>
        <?php if (!empty($post['image'])): ?>
          <?php $image = base64_encode($post['image']); ?>
          <div class="post-image-container">
            <img src="data:image/jpg;base64,<?= $image ?>" class="post-full-image">
          </div>
        <?php endif; ?>
        <div class="post-footer">
          <p class="post-status"><?= $post['status'] ?></p>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>


        <?php endif; ?>
        <?php
    if (isset($_SESSION['flash_notifications'])) {
        foreach($_SESSION['flash_notifications'] as $row) {
            echo $row;
            Flash::getMessages();
        }
    }
    ?>
</body>
</html>
