<?php
$order_id = isset($_GET['order_id']) ? htmlspecialchars($_GET['order_id']) : 'Unknown';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Thank You</title>
  <link rel="stylesheet" href="thankyou.css">
</head>
<body>
  <h1>✅ Thank You for Your Order!</h1>
  <p>We'll start preparing it right away.</p>
  <p><strong>Order ID:</strong> <?= $order_id ?></p>

  <!-- New Order Button -->
  <a href="menu.php" class="btn">🆕 New Order</a>
</body>
</html>
