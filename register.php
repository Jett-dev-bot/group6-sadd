<?php
$error = $_GET['error'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Register - QuickSales POS</title>
  <link rel="stylesheet" href="register.css">
</head>
<body class="register-body">

  <!-- Register Card -->
  <div class="register-card">
    <h2 class="register-title">QuickSales</h2>
    <div class="register-icon">🛒</div>

    <form action="actionpage.php" method="POST" class="register-form">
      <div>
        <input type="text" name="name" placeholder="Name" required class="form-input" />
      </div>
      <div>
        <input type="password" name="password" placeholder="Password" required class="form-input" />
      </div>
      <div>
        <input type="submit" value="Register" class="submit-button" />
      </div>
    </form>

    <p class="login-link">
      Already have an account?
      <a href="loginform.php">Login →</a>
    </p>
  </div>

  <!-- Error Modal -->
  <?php if ($error === 'username'): ?>
  <div id="errorModal" class="modal-overlay">
    <div class="modal-box">
      <h3>⚠️ Username Already Exists</h3>
      <p>Please choose a different username.</p>
      <button onclick="document.getElementById('errorModal').style.display='none';" class="modal-close">Close</button>
    </div>
  </div>
  <?php endif; ?>

</body>
</html>
