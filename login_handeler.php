<?php
session_set_cookie_params(15*60,"/","waph-team1.minifacebook.com",TRUE,TRUE);
session_start();

require "database.php";
require "session_auth.php";

// CSRF check
if (!isset($_POST["nocsrftoken"]) || $_POST["nocsrftoken"] !== $_SESSION["nocsrftoken"]) {
    echo "CSRF Attack is detected";
    die();
}

// Sanitize and validate
$username = sanitize_input($_POST["username"]);
$password = sanitize_input($_POST["password"], true);

if (checklogin_mysql($username, $password)) {
    $_SESSION['authenticated'] = TRUE;
    $_SESSION['username'] = $username;
    $_SESSION['browser'] = $_SERVER["HTTP_USER_AGENT"];
    header("Location: index.php");
    exit();
} else {
    session_destroy();
    echo "<script>alert('Invalid username/password');window.location='projectform.php';</script>";
    exit();
}
?>
