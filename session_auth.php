<?php
	session_set_cookie_params(15*60,"/","hurstts.waph.io",TRUE,TRUE);
	session_start();

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
