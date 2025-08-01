<?php
	require "session_auth.php";
    require "database.php";

    // CSRF token check
	if (!isset($_POST["nocsrftoken"]) || $_POST["nocsrftoken"] !== $_SESSION["nocsrftoken"]) {
	    echo "CSRF Attack is detected";
	    die();
	}

	session_set_cookie_params(15*60,"/","waph-team1.minifacebook.com",TRUE,TRUE);
	session_start();
	if(isset($_POST["username"]) and isset($_POST["password"])) {
	  if (checklogin_mysql($_POST["username"],$_POST["password"])) {
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

  	function checklogin_mysql($username, $password) {

		$sql = "SELECT * FROM users WHERE username=? AND password=md5(?)";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param("ss", $username, $password);
		$stmt->execute();
		$result = $stmt->get_result();
		if($result->num_rows ==1) return TRUE;
		return FALSE;

  	}

?>	
	<h2> Welcome <?php echo htmlentities($_SESSION['username']); ?> !</h2>	
	<a href="changepasswordform.php">Change password</a> | <a href="manageprofileform.php">Manage profile</a> | <a href="logout.php">Logout</a>
