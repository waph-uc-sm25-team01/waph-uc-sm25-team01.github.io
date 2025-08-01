<?php
   require "session_auth.php";
   require "database.php";

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

   function changepassword($username, $password) {
		$prepared_sql = "UPDATE users SET password = md5(?) WHERE username =?;";
		$stmt = $mysqli->prepare($prepared_sql);
		$stmt->bind_param("ss", $password, $username);
		if($stmt->execute()) return TRUE;
		return FALSE;
  	}

?>
<br>
<a href="index.php">Go to Welcome Page</a>
