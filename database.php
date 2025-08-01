<?php

	$mysqli = new mysqli('localhost','travish111' /*Database username */,'changeme' /*Database password*/,
        'waph_team' /*Database name */);

	if ($mysqli->connect_errno) {
        printf("Database connection failed: %s\n", $mysqli->connect_error);
        return FALSE;
	}



	function changepassword($username, $password) {

		$username = sanitize_input($_POST['username']);
	    $password = sanitize_input($_POST['password'], true); // passwords keep special chars

		$prepared_sql = "UPDATE users SET password = md5(?) WHERE username =?;";
		$stmt = $mysqli->prepare($prepared_sql);
		$stmt->bind_param("ss", $password, $username);
		if($stmt->execute()) return TRUE;
		return FALSE;

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


    function checklogin_mysql($username, $password) {

    	$username = sanitize_input($_POST['username']);
	    $password = sanitize_input($_POST['password'], true); // passwords keep special chars

		$sql = "SELECT * FROM users WHERE username=? AND password=md5(?)";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param("ss", $username, $password);
		$stmt->execute();
		$result = $stmt->get_result();
		if($result->num_rows ==1) return TRUE;
		return FALSE;

  	}

  	function get_userdetails() {

		// Fetch current profile info for the logged-in user
		$current_fullname = '';
		$current_email = '';

		$stmt = $mysqli->prepare("SELECT fullname, email FROM users WHERE username = ?");
		$stmt->bind_param("s", $_SESSION["username"]);
		$stmt->execute();
		$stmt->bind_result($current_fullname, $current_email);
		$stmt->fetch();
		$stmt->close();

		$current_fullname = sanitize_input($_POST['fullname']);
		$current_email = sanitize_input($_POST['email']);

  	}


   function sanitize_input($input, $isPassword = false) {
       $input = trim($input);
       $input = stripslashes($input);

       if (!$isPassword) {
       	  $input = stripslashes($input);
          // Remove anything not letters, digits, space, apostrophe, period, hyphen, or @
          $input = preg_replace("/[^a-zA-Z0-9\s'\.\-@]/", '', $input);
          $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
       }

       if (strlen($input) === 0) {
		   echo "Debug> 1 or more empty input.";
		   return FALSE;
	   }

       return $input;
   }

?>