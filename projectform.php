<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>WAPH - Login Page</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="projects/project2/projectstyles.css">

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
      <h1 class="h4 text-center mb-3">A Simple Login Form</h1>
      <h2 class="h6 text-center text-muted mb-4">Travis Hurst</h2>
      <div class="text-center mb-3" id="digit-clock"></div>
      <p class="text-center text-muted">
        <?php echo "Visited time: " . date("M-d h:i:sa"); ?>
      </p>

      <form action="index.php" method="POST" onsubmit="return validateForm();">
        <div class="mb-3">
          <label for="username" class="form-label">Username</label>
          <input type="text" class="form-control text_field" name="username" required
          pattern="^[a-zA-Z\s'.-]{2,50}$"
          title="Name can contain letters, spaces, apostrophes, periods, or hyphens."
          onchange="this.setCustomValidity(this.validity.patternMismatch ? this.title : '')" />
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" name="password" id="password" placeholder="Enter password" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Login</button>
      </form>
      <br>
      <a href="registrationform.php">Create Profile</a>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    function validateForm() {
      const user = document.getElementById("username").value.trim();
      const pass = document.getElementById("password").value.trim();
      if (!user || !pass) {
        alert("Please enter both username and password.");
        return false;
      }
      return true;
    }
  </script>
</body>
</html>
