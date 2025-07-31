<?php
  require "session_auth.php";
  $rand = bin2hex(openssl_random_pseudo_bytes(16));
  $_SESSION["nocsrftoken"] = $rand;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>WAPH - Change PAssword</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="projects/project2/projectstyles.css">
  <script type="text/javascript">
    // Display real-time clock
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

    // Password strength check
    function checkPasswordStrength(input) {
      const message = document.getElementById('password-message');
      const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).{8,}$/;
      if (regex.test(input.value)) {
        message.textContent = "Password is strong";
        message.style.color = "green";
      } else {
        message.textContent = "Password must have 8+ chars, uppercase, lowercase, number, and special character.";
        message.style.color = "red";
      }
    }

    // Confirm password match checker
    function checkPasswordMatch() {
      const pw = document.getElementsByName('newpassword')[0].value;
      const repw = document.getElementsByName('repassword')[0].value;
      const matchMessage = document.getElementById('match-message');

      if (repw === "") {
        matchMessage.textContent = "";
        return;
      }

      if (pw === repw) {
        matchMessage.textContent = "Passwords match";
        matchMessage.style.color = "green";
        document.getElementsByName('repassword')[0].setCustomValidity('');
      } else {
        matchMessage.textContent = "Passwords do not match";
        matchMessage.style.color = "red";
        document.getElementsByName('repassword')[0].setCustomValidity('Passwords do not match');
      }
    }
    
</script>
</head>
<body class="bg-light">
  <div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card shadow p-4 w-100" style="max-width: 400px;">
      <h1 class="h4 text-center mb-3">Change Password</h1>
      <h2 class="h6 text-center text-muted mb-4">Travis Hurst</h2>
      <div class="text-center mb-3" id="digit-clock"></div>
      <p class="text-center text-muted">
        <?php echo "Visited time: " . date("M-d h:i:sa"); ?>
      </p>

    <form action="changepassword.php" method="POST" class="form login">
      <div class="mb-3">
        <label for="username" class="form-label">User Name: <?php echo htmlentities($_SESSION["username"]); ?></label>
      </div>
  
      <div class="mb-3">
          <label for="password" class="form-label">New Password:</label>
          <input type="password" class="form-control text_field" name="newpassword" required
            pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).{8,}$"
            placeholder="Your Password"
            title="Password must be at least 8 characters and include at least 1 uppercase, 1 lowercase, 1 number, and 1 special character (e.g., @$!%*?&)."
            onchange="this.setCustomValidity(this.value !== document.getElementsByName('newpassword')[0].value ? this.title : ''), form.newpassword.pattern = this.value;"
            onkeyup="checkPasswordStrength(this)" /> <br>
          <div id="password-message"></div>
      </div>
      
      <div class="mb-3">
          <label for="newpassword" class="form-label">Confirm Password:</label>
          <input type="password" class="form-control text_field" name="newpassword" required
            placeholder="Re-type your password"
            title="Please re-enter your password"
            oninput="checkPasswordMatch()" /> <br>
          <div id="match-message"></div>
      </div>
  
      <input type="hidden" name="nocsrftoken" value="<?php echo $rand; ?>"/>
  
      <button class="btn btn-primary w-100" type="submit">Change Password</button>
    </form>

    </div>
  </div>
    <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
