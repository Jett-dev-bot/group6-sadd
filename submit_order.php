<?php
// Connect sa MySQL
$servername = "localhost";
$username = "root"; 
$password = "";     
$dbname = "food_orders"; 

$conn = new mysqli($servername, $username, $password, $dbname);

// Check ng connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Get form data
$menuItems = isset($_POST['menu']) ? implode(", ", $_POST['menu']) : '';
$paymentMethod = $_POST['payment_method'] ?? '';

if (empty($menuItems) || empty($paymentMethod)) {
  die("Error: Menu and payment method are required.");
}

// Save sa database
$stmt = $conn->prepare("INSERT INTO orders (menu_items, payment_method, order_time) VALUES (?, ?, NOW())");
$stmt->bind_param("ss", $menuItems, $paymentMethod);

if ($stmt->execute()) {
  header("Location: thankyou.html");
  exit();
} else {
  echo "Error saving order: " . $conn->error;
}

$conn->close();
?>
