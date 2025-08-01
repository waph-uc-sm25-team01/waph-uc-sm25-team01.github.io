<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Mini Facebook</title>
</head>
<body>
<h2>Welcome <?php echo htmlentities($_SESSION['username']); ?> !</h2>
<a href="changepasswordform.php">Change password</a> |
<a href="manageprofileform.php">Manage profile</a> |
<a href="logout.php">Logout</a>
<hr>
