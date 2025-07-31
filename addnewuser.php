<?php
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
	$mysqli = new mysqli('localhost','hurstts' /*Database username */,'changeme' /*Database password*/,
        'waph' /*Database name */);
	$username = sanitize_input($_POST['username']);
	$fullname = sanitize_input($_POST['fullname']);
	$email = sanitize_input($_POST['email']);
	$password = sanitize_input($_POST['password'], true); // passwords keep special chars
	

	if (strlen($username) === 0 || strlen($password) === 0 || strlen($fullname) === 0 || strlen($email) === 0) {
	   echo "Debug> 1 or more empty input.";
	   return FALSE;
	}
	
	if (!preg_match("/^[a-zA-Z0-9\s'.-]{2,50}$/", $username)) {
	   echo "Debug> Invalid characters in username.";
	   return FALSE;
	}
	
	if (!preg_match("/^[a-zA-Z0-9\s'.-]{2,50}$/", $fullname)) {
	   echo "Debug> Invalid characters in fullname.";
	   return FALSE;
	}

	// Built in email validation filter
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	   echo "Debug> Invalid email format.";
	   return FALSE;
	}
	
	if ($mysqli->connect_errno) {
            printf("Database connection failed: %s\n", $mysqli->connect_error);
            return FALSE;
	}
	$prepared_sql = "INSERT INTO users (username,password,fullname,email) VALUES (?, md5(?), ?, ?)";
	$stmt = $mysqli->prepare($prepared_sql);
	$stmt->bind_param("ssss", $username, $password, $fullname, $email);
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
<a href="projectform.php">Go to Welcome Page</a>
