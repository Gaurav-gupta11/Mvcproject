<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link rel="stylesheet" href="/css/activity.css">
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
<div class="post-grid">
    <?php foreach ($post as $post): ?>
        <div class="post">
            <?php if (!empty($post['image'])): ?>
                <div class="post-image-container">
                    <img src="data:image/jpg;base64,<?= base64_encode($post['image']) ?>" alt="post image">
                </div>
            <?php endif; ?>
            <div class="post-content">
                <p class="post-status"><?= $post['status'] ?></p>
                <div class="post-actions">
                    <a href="/Posts/<?= $post['post_id'] ?>/edit">edit</a>
                    <a href="/Posts/<?= $post['post_id'] ?>/delete">delete</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
</main>

<?php endif; ?>
</body>
</html>