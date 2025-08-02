<?php
	require "database.php";
	session_set_cookie_params(15*60,"/","hurstts.waph.io",TRUE,TRUE);
	session_start();

	// Sanitize user input
	$username = sanitize_input($_POST["username"]);
	$password = sanitize_input($_POST["password"], true);


	if(isset($username) and isset($password)) {
	  if (checklogin_mysql($username,$password)) {
	    $_SESSION['authenticated'] = TRUE;
	    $_SESSION['username'] = $_POST["username"];
	    $_SESSION['browser'] = $_SERVER["HTTP_USER_AGENT"];
	  }else{
	  	session_destroy();
		echo "<script>alert('Invalid username/password');window.location='projectform.php';</script>";
		die();
	  }
	}
	if(!isset($_SESSION['authenticated']) or $_SESSION['authenticated'] != TRUE) {
	  session_destroy();
	  echo "<script>alert('You are not logged in. Please log in first!')</script>";
	  header("Refresh: 0; url=projectform.php");
	  die();
	}
	if($_SESSION['browser'] != $_SERVER["HTTP_USER_AGENT"]) {
	  // it is a session hijacking attack since it comes from a different browser
	  session_destroy();
	  echo "<script>alert('Session hijacking attack is detected!')</script>";
	  header("Refresh: 0; url=projectform.php");
	  die();
	}

	$posts = get_all_posts(); // Fetch posts
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

