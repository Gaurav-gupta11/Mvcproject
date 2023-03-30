<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Profile</title>
    <link rel="stylesheet" href="/css/profile.css">
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
        <div class="container">
            <div class="profile-header">
                <?php if (!empty($user['img'])): ?>
                    <img src="data:image/jpg;base64,<?=base64_encode($user['img'])?>" alt="<?=$user['name']?>" class="profile-image">
                <?php endif; ?>
                <div class="profile-info">
                    <div class="profile-name"><?=$user['name']?></div>
                    <div class="profile-email"><?=$user['email']?></div>
                </div>
            </div>
            <div class="profile-actions">
                <a href="/Items/edit" class="profile-action">Edit Profile</a>
                <a href="/Posts/myActivity" class="profile-action">My Activity</a>
                <?php endif; ?>

</body>
</html>
