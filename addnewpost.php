<?php
	require "session_auth.php";
	require "database.php";

	// CSRF token check
	if (!isset($_POST["nocsrftoken"]) || $_POST["nocsrftoken"] !== $_SESSION["nocsrftoken"]) {
	    echo "CSRF Attack is detected";
	    die();
	}

	$title = sanitize_input($_POST["title"]);
	$content = sanitize_input($_POST["content"]);
	$timestamp = date("Y-m-d H:i:s");
	$owner = $_SESSION["username"];
	
	if (add_post($title, $content, $timestamp, $owner)) {
	    header("Location: index.php");
	    exit();
	} else {
	    echo "Post failed. <a href='index.php'>Go back</a>";
	}
?>
