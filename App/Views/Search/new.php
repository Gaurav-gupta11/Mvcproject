<!DOCTYPE html>
<html>
<head>
  <title>Login Page</title>
  <link rel="stylesheet" href="/css/search.css">
</head>
<body>
<header>
    <?php if(isset($_SESSION['user_id'])) {?>
		<nav>
			<a href="/Posts/newsFeed" class="nav-link">
				<img src="/images/home.png" alt="Home" class="nav-icon">
				<span class="nav-text">Home</span>
			</a>
			<a href="/items/index" class="nav-link">
				<img src="/images/profile.png" alt="Profile" class="nav-icon">
				<span class="nav-text">Profile</span>
			</a>
      <a href="/Search/new" class="nav-link">
				<img src="/images/search.png" alt="Logout" class="nav-icon">
				<span class="nav-text">Search</span>
			</a>
			<a href="/Login/destroy" class="nav-link">
				<img src="/images/logout.png" alt="Logout" class="nav-icon">
				<span class="nav-text">Logout</span>
			</a>
		</nav>
	</header>
<form id="search-form" method="post" action="/Search/search">
  <label for="search-query">Search:</label>
  <input type="text" id="search-query" name="search-query">
  <input type="submit" value="search">
  </form>
    
  <?php } if(isset($_SESSION['user_id']) && isset($user)): ?>
  <?php foreach ($user as $user): ?>
    <div class="profile-container">
      <?php if (!empty($user['img'])): ?>
        <img src="data:image/jpg;base64,<?=base64_encode($user['img'])?>" alt="<?=$user['name']?>" class="profile-image">
      <?php else: ?>
        <div class="profile-image-placeholder"></div>
      <?php endif; ?>
      <div class="profile-info">
      <a href="/Search/<?= $user['id'] ?>/profile">
      <div class="profile-name"><?=$user['name']?></div>
      </a>
      </div>
    </div>
  <?php endforeach; ?>
<?php else: ?>
  <div>No users</div>
<?php endif; ?>


</body>
</html>