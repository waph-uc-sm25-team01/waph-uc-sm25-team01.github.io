<?php
	$mysqli = new mysqli('localhost','travish111' /*Database username */,'changeme' /*Database password*/,
        'waph_team' /*Database name */);

	if ($mysqli->connect_errno) {
	   printf("Database connection failed: %s\n", $mysqli->connect_error);
	   return FALSE;
	}

	function changepassword($username, $password) {
	    global $mysqli;

	    if (!preg_match("/^[a-zA-Z0-9\s'.\-@]{2,75}$/", $username)) {
	        echo "Debug> Invalid characters in username.";
	        return FALSE;
	    }
	
	    $prepared_sql = "UPDATE users SET password = md5(?) WHERE username = ?";
	    $stmt = $mysqli->prepare($prepared_sql);
	    $stmt->bind_param("ss", $password, $username);
	    if ($stmt->execute()) return TRUE;
            return FALSE;
	}

	function manageprofile($username, $fullname, $email) {
	    global $mysqli;
	
	    if (!preg_match("/^[a-zA-Z0-9\s'.\-]{2,50}$/", $fullname)) {
	        echo "Debug> Invalid characters in fullname.";
	        return FALSE;
	    }

	    if (!preg_match("/^[a-zA-Z0-9\s'.\-]{2,50}$/", $username)) {
	        echo "Debug> Invalid characters in fullname.";
	        return FALSE;
	    }
	
	    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	        echo "Debug> Invalid email format.";
	        return FALSE;
	    }
	
	    $prepared_sql = "UPDATE users SET fullname = ?, email = ? WHERE username = ?";
	    $stmt = $mysqli->prepare($prepared_sql);
	    $stmt->bind_param("sss", $fullname, $email, $username);
	    if ($stmt->execute()) return TRUE;
            return FALSE;
	}

	function addnewuser($username, $password, $fullname, $email) {
	    global $mysqli;
	
	    if (!preg_match("/^[a-zA-Z0-9\s'.\-@]{2,75}$/", $username)) {
	        echo "Debug> Invalid characters in username.";
	        return FALSE;
	    }
	
	    if (!preg_match("/^[a-zA-Z0-9\s'.\-@]{2,75}$/", $fullname)) {
	        echo "Debug> Invalid characters in fullname.";
	        return FALSE;
	    }
	
	    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	        echo "Debug> Invalid email format.";
	        return FALSE;
	    }
	
	    $prepared_sql = "INSERT INTO users (username, password, fullname, email) VALUES (?, md5(?), ?, ?)";
	    $stmt = $mysqli->prepare($prepared_sql);
	    $stmt->bind_param("ssss", $username, $password, $fullname, $email);
	    if ($stmt->execute()) return TRUE;
            return FALSE;
	}

	function checklogin_mysql($username, $password) {
	   global $mysqli;

	   if (!preg_match("/^[a-zA-Z0-9\s'.\-@]{2,75}$/", $username)) {
	        echo "Debug> Invalid characters in username.";
	        return FALSE;
	    }
	
	   $prepared_sql = "SELECT * FROM users WHERE username=? AND password=md5(?)";
	   $stmt = $mysqli->prepare($prepared_sql);
	   $stmt->bind_param("ss", $username, $password);
	   $stmt->execute();
	   $result = $stmt->get_result();
	   if($result->num_rows ==1) return TRUE;
	   return FALSE;
	
	}

	function get_userdetails() {
	    global $mysqli;
	
	    $fullname = '';
	    $email = '';
	
	    if (!isset($_SESSION["username"])) {
	        echo "Debug> No user session.";
	        return FALSE;
	    }
	
	    $stmt = $mysqli->prepare("SELECT fullname, email FROM users WHERE username = ?");
	    $stmt->bind_param("s", $_SESSION["username"]);
	    $stmt->execute();
	    $stmt->bind_result($fullname, $email);
	
	    if ($stmt->fetch()) {
	        $stmt->close();
	        return array(
	            'fullname' => $fullname,
	            'email' => $email
	        );
	    } else {
	        $stmt->close();
	        echo "Debug> User not found.";
	        return FALSE;
	    }
	}

	function add_post($title, $content, $timestamp, $owner) {
	    global $mysqli;
	
	    if (!preg_match("/^[a-zA-Z0-9\s'.\-@]{2,75}$/", $title)) {
	        echo "Debug> Invalid characters in title.";
	        return FALSE;
	    }
	
	    if (!preg_match("/^[a-zA-Z0-9\s'.\-@]{2,250}$/", $content)) {
	        echo "Debug> Invalid characters in content.";
	        return FALSE;
	    }

	    if (!preg_match("/^[a-zA-Z0-9\s'.\-@]{2,250}$/", $owner)) {
	        echo "Debug> Invalid characters in owner.";
	        return FALSE;
	    }
	
	    $prepared_sql = "INSERT INTO posts (title, content, timestamp, owner) VALUES (?, ?, ?, ?)";
	    $stmt = $mysqli->prepare($prepared_sql);
	    $stmt->bind_param("ssss", $title, $content, $timestamp, $owner);
	
	    if ($stmt->execute()) return TRUE;
	    return FALSE;
	}

	function get_all_posts() {
	    global $mysqli;

	    $prepared_sql = "SELECT post_id, title, content, timestamp, owner FROM posts ORDER BY timestamp DESC";
	    $stmt = $mysqli->prepare($prepared_sql);
	    if (!$stmt->execute()) {
	        return [];
	    }
	
	    $result = $stmt->get_result();
	    $posts = [];
	
	    while ($row = $result->fetch_assoc()) {
	        $posts[] = $row;
	    }
	
	    $stmt->close();
	    $mysqli->close();
	
	    return $posts;
	}

	function sanitize_input($input, $isPassword = false) {
	   $input = trim($input);
	   $input = stripslashes($input);
	
	   if (!$isPassword) {
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
