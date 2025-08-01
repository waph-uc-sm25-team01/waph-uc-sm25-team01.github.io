<?php
	require "database.php";

    $username = $_POST["username"];
    $password = $_POST["password"];
    $fullname = $_POST["fullname"];
    $email = $_POST["email"];

    if(isset($username) and isset($password) and isset($fullname) and isset($email)) {
	//echo "Debug> got  username=$username; password=$password";
	if (addnewuser($username,$password,$fullname,$email)) {
	    echo "Registration succeeded!";
	} else {
	    echo "Registration failed!";
	} 
    } else {
	echo "No username/password/fullname/email provided!";
    }

    function addnewuser($username, $password, $fullname, $email) {

		$username = sanitize_input($_POST['username']);
		$fullname = sanitize_input($_POST['fullname']);
		$email = sanitize_input($_POST['email']);
		$password = sanitize_input($_POST['password'], true); // passwords keep special chars

		
		if (!preg_match("/^[a-zA-Z0-9\s'.-]{2,75}$/", $username)) {
		   echo "Debug> Invalid characters in username.";
		   return FALSE;
		}
		
		if (!preg_match("/^[a-zA-Z0-9\s'.-]{2,75}$/", $fullname)) {
		   echo "Debug> Invalid characters in fullname.";
		   return FALSE;
		}

		// Built in email validation filter
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		   echo "Debug> Invalid email format.";
		   return FALSE;
		}
		
		$prepared_sql = "INSERT INTO users (username,password,fullname,email) VALUES (?, md5(?), ?, ?)";
		$stmt = $mysqli->prepare($prepared_sql);
		$stmt->bind_param("ssss", $username, $password, $fullname, $email);
		if($stmt->execute()) return TRUE;
		return FALSE;
    }
    
?>
<br>
<a href="projectform.php">Go to Welcome Page</a>
