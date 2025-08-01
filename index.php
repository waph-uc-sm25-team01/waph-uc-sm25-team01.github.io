<?php
	require "database.php";
	require "session_auth.php";
	
	// CSRF token check
	if (!isset($_POST["nocsrftoken"]) || $_POST["nocsrftoken"] !== $_SESSION["nocsrftoken"]) {
	    echo "CSRF Attack is detected";
	    die();
	}

	// Sanitize user input
	$username = sanitize_input($_POST["username"]);
	$password = sanitize_input($_POST["password"], true);

	session_set_cookie_params(15*60,"/","waph-team1.minifacebook.com",TRUE,TRUE);
	session_start();

	if (isset($username) && isset($password) && checklogin_mysql($username, $password)) {
		// Session setup AFTER successful login
		$_SESSION['authenticated'] = TRUE;
		$_SESSION['username'] = $username;
		$_SESSION['browser'] = $_SERVER["HTTP_USER_AGENT"];
	} else {
		session_destroy();
		echo "<script>alert('Invalid username/password');window.location='projectform.php';</script>";
		die();
	}

	if(!isset($_SESSION['authenticated']) or $_SESSION['authenticated'] != TRUE) {
	  session_destroy();
	  echo "<script>alert('You are not logged in. Please log in first!')</script>";
	  header("Refresh: 0; url=projectform.php");
	  die();
	}

	if($_SESSION['browser'] != $_SERVER["HTTP_USER_AGENT"]) {
	  //It is a session hijacking attack since it comes from a different browser
	  session_destroy();
	  echo "<script>alert('Session hijacking attack is detected!')</script>";
	  header("Refresh: 0; url=projectform.php");
	  die();
	}
?>	
<h2> Welcome <?php echo htmlentities($_SESSION['username']); ?> !</h2>	
<a href="changepasswordform.php">Change password</a> | <a href="manageprofileform.php">Manage profile</a> | <a href="logout.php">Logout</a>


