<?php
   require "session_auth.php";
   require "database.php";

   $username = $_SESSION["username"];
   $password = sanitize_input($_REQUEST["newpassword"], true); // Important: sanitize here
   $token = $_POST["nocsrftoken"];

   if (!isset($token) || $token != $_SESSION["nocsrftoken"]) {
       echo "CSRF Attack is detected";
       die();
   }

   if (isset($username) AND isset($password)){
       if (changepassword($username, $password)) {
           echo "Password has been changed!";
       } else {
           echo "Change password failed!";
       }
   } else {
       echo "No username/password provided.";
       exit();
   }
?>
<br>
<a href="index.php">Go to Welcome Page</a>
