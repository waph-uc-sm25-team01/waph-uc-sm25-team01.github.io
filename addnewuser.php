<?php
	require "database.php";

	// Sanitize inputs before passing to addnewuser
	$username = sanitize_input($_POST["username"]);
	$password = sanitize_input($_POST["password"], true); // passwords keep special chars
	$fullname = sanitize_input($_POST["fullname"]);
	$email    = sanitize_input($_POST["email"]);

        if(isset($username) and isset($password) and isset($fullname) and isset($email)) {
		if (addnewuser($username, $password, $fullname, $email)) {
			echo "Registration succeeded!";
		} else {
			echo "Registration failed!";
		}
	} else {
		echo "No valid username/password/fullname/email provided!";
	}
?>
<br>
<a href="projectform.php">Go to Welcome Page</a>
