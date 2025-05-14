<?php
ob_start();
session_start();

// DATABASE CONNECTION
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project pos";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check DB connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// HANDLE LOGIN
$msg = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['name'], $_POST['password'])) {
    $user = trim($_POST['name']);
    $pass = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT name, password FROM manager WHERE name = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($db_name, $hashed_password);
        $stmt->fetch();

        if (password_verify($pass, $hashed_password)) {
            $_SESSION['valid'] = true;
            $_SESSION['timeout'] = time();
            $_SESSION['name'] = $db_name;
            header("Location: profile.php");
            exit;
        } else {
            $msg = "Incorrect password.";
        }
    } else {
        $msg = "User not found.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login | Point of Sale</title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #022E36;
      color: white;
    }

    .container {
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .login-box {
      background-color: #014852;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
      width: 350px;
      text-align: center;
    }

    .login-box h2 {
      margin-bottom: 10px;
      font-size: 18px;
    }

    .cart-icon {
      font-size: 24px;
      margin-bottom: 20px;
    }

    .input-group {
      margin: 15px 0;
      position: relative;
    }

    .input-group input {
      width: 80%;
      padding: 10px 35px 10px 35px;
      border: 1px solid #ccc;
      border-radius: 4px;
      background-color: #014852;
      color: white;
    }

    .input-group input::placeholder {
      color: #ccc;
    }

    .input-group::before {
      content: attr(data-icon);
      position: absolute;
      left: 10px;
      top: 50%;
      transform: translateY(-50%);
      font-family: Arial, sans-serif;
      color: #ccc;
    }

    .forgot-password {
      font-size: 12px;
      color: #ccc;
      margin: 5px 0;
      display: block;
    }

    .sign-in-section {
      margin-top: 30px;
    }

    .sign-in-as {
      font-size: 13px;
      margin-bottom: 15px;
      color: #eee;
    }

    .button-group {
      display: flex;
      flex-direction: column;
      gap: 10px;
    }

    .button-group button {
      padding: 10px 16px;
      border: none;
      border-radius: 20px;
      background-color: white;
      color: #014852;
      font-weight: bold;
      cursor: pointer;
    }

    .button-group button:hover {
      background-color: #ccc;
    }

    .register-link {
      margin-top: 15px;
    }

    .register-link a {
      color: #fff;
      text-decoration: underline;
      font-size: 13px;
    }

    .error-message {
      color: red;
      font-size: 13px;
      margin-top: 10px;
    }
  </style>
</head>
<body>

<form action="" method="post"> 
  <div class="container">
    <div class="login-box">
      <h2>POINT OF SALE</h2>
      <div class="cart-icon">🛒</div>

      <div class="input-group" data-icon="👤">
        <input type="text" name="name" placeholder="USERNAME" required>
      </div>

      <div class="input-group" data-icon="🔒">
        <input type="password" name="password" placeholder="PASSWORD" required>
      </div>

      <a href="forgot-password.php" class="forgot-password">Forgot password?</a>

      <?php if (!empty($msg)): ?>
        <div class="error-message"><?= htmlspecialchars($msg) ?></div>
      <?php endif; ?>

      <div class="sign-in-section">
        <div class="sign-in-as">Sign in as</div>
        <div class="button-group">
          <button type="submit" name="login">Login</button>
        </div>
      </div>

      <div class="register-link">
        Don't have an account? <a href="register.php">Create one</a>
      </div>
    </div>
  </div>
</form>

</body>
</html>
