<?php
  require "session_auth.php";
  require "database.php";

  $rand = bin2hex(openssl_random_pseudo_bytes(16));
  $_SESSION["nocsrftoken"] = $rand;

  // Fetch current profile info for the logged-in user
  $username = $_SESSION["username"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>WAPH - Create New Post</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="styles/projectstyles.css">
</head>
<body class="bg-light">
  <div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card shadow p-4 w-100" style="max-width: 60%;">
      <h1 class="h4 text-center mb-3">Create New Post</h1>
      <h2 class="h6 text-center text-muted mb-4">Travis Hurst</h2>

    <form action="addnewpost.php" method="POST" class="form">
      <div class="mb-3">
        <label for="username" class="form-label">User: <?php echo htmlentities($_SESSION["username"]); ?></label>
      </div>
  
      <div class="mb-3">
          <label for="title" class="form-label">Title:</label>
          <input type="text" class="form-control text_field" name="title" required
           pattern="^[a-zA-Z0-9\s'.-]{2,75}$" title="Title can contain letters, spaces, apostrophes, periods, or hyphens."
           onchange="this.setCustomValidity(this.validity.patternMismatch ? this.title : '')" /> <br>
      </div>
      
      <div class="mb-3">
          <textarea class="form-control text_field" name="content" required
          pattern="^[a-zA-Z0-9\s'.\-@]{2,250}$"
          title="Content can contain letters, numbers, spaces, and punctuation."
          onchange="this.setCustomValidity(this.validity.patternMismatch ? this.title : '')"
          rows="5"></textarea>
      </div>
  
      <input type="hidden" name="nocsrftoken" value="<?php echo $rand; ?>"/>
  
      <button class="btn btn-primary w-100" type="submit">Create Post</button>
    </form>

    </div>
  </div>
    <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
