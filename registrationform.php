<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>WAPH - Registration Page</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="projects/project2/projectstyles.css">
  <script type="text/javascript">

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
      <h1 class="h4 text-center mb-3">New User Registration</h1>
      <h2 class="h6 text-center text-muted mb-4">Travis Hurst</h2>

      <form action="addnewuser.php" method="POST" class="form login">
        <div class="mb-3">
          <label for="username" class="form-label">User Name:</label>
          <input type="text" class="form-control text_field" name="username" required
         pattern="^[a-zA-Z0-9\s'.-]{2,50}$"
          title="Name can contain letters, spaces, apostrophes, periods, or hyphens."
          onchange="this.setCustomValidity(this.validity.patternMismatch ? this.title : '')" />
        </div>
    
        <div class="mb-3">
            <label for="password" class="form-label">Password:</label>
            <input type="password" class="form-control text_field" name="password" required
              pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).{8,}$"
              placeholder="Your Password"
              title="Password must be at least 8 characters and include at least 1 uppercase, 1 lowercase, 1 number, and 1 special character (e.g., @$!%*?&)."
              onchange="this.setCustomValidity(this.validity.patternMismatch ? this.title : ''), form.repassword.pattern = this.value;"
              onkeyup="checkPasswordStrength(this)" /> <br>
            <div id="password-message"></div>
        </div>
        
        <div class="mb-3">
            <label for="repassword" class="form-label">Confirm Password:</label>
            <input type="password" class="form-control text_field" name="repassword" required
            placeholder="Re-type your password"
            title="Please re-enter your password"
            oninput="checkPasswordMatch()" /> <br>
            <div id="match-message"></div>
        </div>
  
        <div class="mb-3">
          <label for="fullname" class="form-label">Full Name:</label>
          <input type="text" class="form-control text_field" name="fullname" required 
         pattern="^[a-zA-Z0-9\s'.-]{2,50}$"
          title="Full Name can contain letters, spaces, apostrophes, periods, or hyphens."
          onchange="this.setCustomValidity(this.validity.patternMismatch ? this.title : '')" />
        </div>
  
        <div class="mb-3">
          <label for="email" class="form-label">Email:</label>
          <input type="email" class="form-control text_field" name="email" required
            pattern="^[\w\.-]+@[\w\.-]+\.\w{2,}$"
            title="Please enter a valid email"
            placeholder="Your email address"
            onchange="this.setCustomValidity(this.validity.patternMismatch ? this.title : '')" />
        </div>
    
        <button class="btn btn-primary w-100" type="submit">Register</button>
            
      </form>

    </div>
  </div>
    <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
