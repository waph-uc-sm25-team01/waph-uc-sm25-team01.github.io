<?php
  require "session_auth.php";
  require "database.php";

  $rand = bin2hex(openssl_random_pseudo_bytes(16));
  $_SESSION["nocsrftoken"] = $rand;

  // Fetch current profile info for the logged-in user
  $user_details = get_userdetails();
  $current_fullname = $user_details ? $user_details['fullname'] : '';
  $current_email = $user_details ? $user_details['email'] : '';

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>WAPH - Manage Your Profile</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="styles/projectstyles.css">

  <script type="text/javascript">
    function displayTime() {
      const options = {
        month: 'short',
        day: '2-digit',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
        hour12: true
      };
      const formattedTime = new Date().toLocaleString('en-US', options).replace(/,/, '');
      document.getElementById('digit-clock').innerHTML = "Current time: " + formattedTime;
    }
    setInterval(displayTime, 500);
  </script>
</head>
<body class="bg-light">
  <div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card shadow p-4 w-100" style="max-width: 400px;">
      <h1 class="h4 text-center mb-3">Manage Profile</h1>
      <h2 class="h6 text-center text-muted mb-4">Travis Hurst</h2>
      <div class="text-center mb-3" id="digit-clock"></div>
      <p class="text-center text-muted">
        <?php echo "Visited time: " . date("M-d h:i:sa"); ?>
      </p>

    <form action="manageprofile.php" method="POST" class="form login">
      <div class="mb-3">
        <label for="username" class="form-label">User Profile: <?php echo htmlentities($_SESSION["username"]); ?></label>
      </div>
  
      <div class="mb-3">
          <label for="fullname" class="form-label">Full Name:</label>
          <input type="text" class="form-control text_field" name="newfullname" required
            value="<?php echo htmlentities($current_fullname); ?>"
           pattern="^[a-zA-Z0-9\s'.-]{2,50}$" title=" Name can contain letters, spaces, apostrophes, periods, or hyphens."
            onchange="this.setCustomValidity(this.validity.patternMismatch ? this.title : '')" /> <br>
      </div>
      
      <div class="mb-3">
          <label for="email" class="form-label">Email:</label>
          <input type="email" class="form-control text_field" name="newemail" required
            pattern="^[\w\.-]+@[\w\.-]+\.\w{2,}$"
            title="Please enter a valid email"
            value="<?php echo htmlentities($current_email); ?>"
            onchange="this.setCustomValidity(this.validity.patternMismatch ? this.title : '')" /> <br>
      </div>
  
      <input type="hidden" name="nocsrftoken" value="<?php echo $rand; ?>"/>
  
      <button class="btn btn-primary w-100" type="submit">Update Profile</button>
    </form>

    </div>
  </div>
    <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
