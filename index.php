<?php
    session_set_cookie_params(15*60,"/","waph-team1.minifacebook.com",TRUE,TRUE);
    session_start();

    require "database.php";
    require "session_auth.php";

    // Security checks
    if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== TRUE) {
         session_destroy();
        echo "<script>alert('You are not logged in. Please log in first!')</script>";
        header("Refresh: 0; url=projectform.php");
        die();
    }

    if ($_SESSION['browser'] !== $_SERVER["HTTP_USER_AGENT"]) {
        session_destroy();
        echo "<script>alert('Session hijacking attack is detected!')</script>";
        header("Refresh: 0; url=projectform.php");
        die();
    }

    $posts = get_all_posts();
    include("header.php");
?>

<div class="text-end mb-3">
  <a class="btn btn-primary" href="newpost.php">+ Add New Post</a>
</div><br>

<h2>Posts</h2>
<?php if (!empty($posts)): ?>
    <?php foreach ($posts as $post): ?>
        <div class="post">
            <h3><?php echo htmlspecialchars($post['title']); ?></h3>
            <p><em>Posted by <?php echo htmlspecialchars($post['owner']); ?> at <?php echo htmlspecialchars($post['timestamp']); ?></em></p>
            <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
            <hr>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>No posts found.</p>
<?php endif; ?>

