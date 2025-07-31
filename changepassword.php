<?php
   require "session_auth.php";
   $username= $_SESSION["username"];
   $password= $_REQUEST["newpassword"];
   $token = $_POST["nocsrftoken"];

   if (!isset($token) OR ($token != $_SESSION["nocsrftoken"])) {
   		echo "CSRF Attack is detected";
   		die();
   }

   if (isset($username) AND isset($password)){
   		//echo "DEBUG: changepassword.php->Got: username=$username; newpassword=$password\n<br>";
   		if (changepassword($username,$password)) {
   			echo "Password has been changed!";
   			}else{
   				echo "Change password failed!";
   			}
   } else{
   		echo "No username/password provided.";
   		exit();
   }

   if (strlen($username) === 0 || strlen($password) === 0) {
	   echo "Debug> 1 or more empty input.";
	   return FALSE;
	}
	
  if (!preg_match("/^[a-zA-Z0-9\s'.-]{2,50}$/", $username)) {
      echo "Debug> Invalid characters in username.";
      return FALSE;
   }

   function changepassword($username, $password) {
		$mysqli = new mysqli('localhost',
				     'hurstts' /*Database username */,
				     'changeme' /*Database password*/,
				     'waph' /*Database name */);
		if ($mysqli->connect_errno) {
			printf("Database connection failed: %s\n", $mysqli->connect_error);
			return FALSE;
		}
		$prepared_sql = "UPDATE users SET password = md5(?) WHERE username =?;";
		$stmt = $mysqli->prepare($prepared_sql);
		$stmt->bind_param("ss", $password, $username);
		if($stmt->execute()) return TRUE;
		return FALSE;
  	}

   function sanitize_input($input, $isPassword = false) {
       $input = trim($input);
       $input = stripslashes($input);

       if (!$isPassword) {
        // Remove anything not letters, digits, space, apostrophe, period, hyphen, or @
        $input = preg_replace("/[^a-zA-Z0-9\s'\.\-@]/", '', $input);
        $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
       }
       return $input;
   }
?>
<br>
<a href="index.php">Go to Welcome Page</a>
