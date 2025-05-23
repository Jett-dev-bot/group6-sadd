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
  <meta charset="UTF-8" />
  <title>Login | QuickSales POS</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="loginform.css">
</head>
<body>

  <form method="POST">
    <h2>QuickSales</h2>
    <div class="icon">🛒</div>

    <input type="text" name="name" placeholder="Username" required />
    <input type="password" name="password" placeholder="Password" required />

    <div class="forgot">
      <a href="forgot-password.php">Forgot password?</a>
    </div>

    <?php if (!empty($msg)): ?>
      <div class="error"><?= htmlspecialchars($msg) ?></div>
    <?php endif; ?>

    <button type="submit" name="login">Login</button>

    <p>
      Don't have an account?
      <a href="register.php">Create one →</a>
    </p>
  </form>

</body>
</html>
