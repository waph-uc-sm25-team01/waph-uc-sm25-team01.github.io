<?php
	require "session_auth.php";
	require "database.php";

	// CSRF token check
	if (!isset($_POST["nocsrftoken"]) || $_POST["nocsrftoken"] !== $_SESSION["nocsrftoken"]) {
	    echo "CSRF Attack is detected";
	    die();
	}

	$username = $_SESSION["username"];
	$fullname = sanitize_input($_POST['newfullname']);
	$email    = sanitize_input($_POST['newemail']);

	if (isset($username) && isset($fullname) && isset($email)) {
	    if (manageprofile($username, $fullname, $email)) {
	        echo "Profile has been changed!<br>";
	        echo '<a href="index.php">Go to Welcome Page</a>';
	    } else {
	        echo "Update profile failed!";
	    }
	} else {
	    echo "Missing or invalid input.";
	}
?>
