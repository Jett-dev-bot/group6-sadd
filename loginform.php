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
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-900 text-white min-h-screen flex items-center justify-center font-sans">

  <form method="POST" class="bg-gray-800 p-8 rounded-2xl shadow-lg w-full max-w-md">
    <h2 class="text-2xl font-bold text-center mb-2">QuickSales</h2>
    <div class="text-4xl text-center mb-6">🛒</div>

    <div class="space-y-4">
      <input type="text" name="name" placeholder="Username" required
             class="w-full p-3 rounded-lg bg-gray-700 text-white focus:outline-none placeholder-gray-400" />

      <input type="password" name="password" placeholder="Password" required
             class="w-full p-3 rounded-lg bg-gray-700 text-white focus:outline-none placeholder-gray-400" />
    </div>

    <div class="text-right mt-2">
      <a href="forgot-password.php" class="text-sm text-gray-300 hover:text-yellow-300">Forgot password?</a>
    </div>

    <?php if (!empty($msg)): ?>
      <div class="bg-red-600 text-white p-2 rounded mt-4 text-sm text-center">
        <?= htmlspecialchars($msg) ?>
      </div>
    <?php endif; ?>

    <button type="submit" name="login"
            class="mt-6 w-full bg-yellow-300 text-gray-900 font-bold py-3 rounded-lg hover:bg-yellow-400 transition">
      Login
    </button>

    <p class="text-center text-sm text-gray-300 mt-4">
      Don't have an account?
      <a href="register.php" class="text-yellow-300 font-semibold hover:underline ml-1">Create one →</a>
    </p>
  </form>

</body>
</html>
