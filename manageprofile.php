<?php
	require "session_auth.php";
	
	// CSRF token check
	if (!isset($_POST["nocsrftoken"]) || $_POST["nocsrftoken"] !== $_SESSION["nocsrftoken"]) {
	    echo "CSRF Attack is detected";
	    die();
	}
	
	// Sanitize inputs before use
	$username = $_SESSION["username"];
	$fullname = sanitize_input($_POST['newfullname']);
	$email    = sanitize_input($_POST['newemail']);
	
	// Input presence check
	if (empty($username) || empty($fullname) || empty($email)) {
	    echo "Debug> 1 or more empty input.";
	    exit();
	}
	
	// Validate format
	if (!preg_match("/^[a-zA-Z0-9\s'.-]{2,50}$/", $fullname)) {
	    echo "Debug> Invalid characters in fullname.";
	    exit();
	}
	
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	    echo "Debug> Invalid email format.";
	    exit();
	}
	
	// Call DB update function
	if (manageprofile($username, $fullname, $email)) {
	    echo "Profile has been changed!<br>";
	    echo '<a href="index.php">Go to Welcome Page</a>';
	} else {
	    echo "Update profile failed!";
	}
	
	function manageprofile($username, $fullname, $email) {
	    $mysqli = new mysqli('localhost', 'hurstts', 'changeme', 'waph');
	    if ($mysqli->connect_errno) {
	        printf("Database connection failed: %s\n", $mysqli->connect_error);
	        return FALSE;
	    }
	    $prepared_sql = "UPDATE users SET fullname = ?, email = ? WHERE username = ?";
	    $stmt = $mysqli->prepare($prepared_sql);
	    $stmt->bind_param("sss", $fullname, $email, $username);
	    return $stmt->execute();
	}
	
	function sanitize_input($input, $isPassword = false) {
	    $input = trim($input);
	    if (!$isPassword) {
	        $input = stripslashes($input);
	        $input = preg_replace("/[^a-zA-Z0-9\s'\.\-@]/", '', $input);
	        $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
	    }
	    return $input;
	}
?>
