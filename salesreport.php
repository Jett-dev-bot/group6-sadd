<?php
include 'db.php';

// Query to get sales data by joining orders and order_items
$query = "
    SELECT o.id AS order_id, o.order_date, oi.menu_item_id, oi.quantity, oi.price, m.name AS item_name, m.image_path 
    FROM orders o
    JOIN order_items oi ON o.id = oi.order_id
    JOIN menu_items m ON oi.menu_item_id = m.id
    ORDER BY o.order_date DESC
";
$stmt = $pdo->query($query);
$salesData = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Sales Report</title>
  <style>
    /* Styles */
    * { box-sizing: border-box; }
    body { margin: 0; font-family: 'Segoe UI', sans-serif; background-color: #066b72; color: white; }
    .sidebar { width: 80px; background-color: #055a61; height: 100vh; position: fixed; top: 0; left: 0; display: flex; flex-direction: column; align-items: center; padding-top: 20px; }
    .sidebar img, .sidebar div { margin: 20px 0; font-size: 12px; text-align: center; cursor: pointer; }
    .current { background-color: #42c5c6; color: black; padding: 10px; border-radius: 10px; width: 100%; text-align: center; }
    .topbar { margin-left: 80px; padding: 20px; display: flex; justify-content: space-between; align-items: center; background-color: #066b72; }
    .topbar h2 { background-color: white; color: black; padding: 8px 15px; border-radius: 10px; }
    .topbar nav { display: flex; gap: 20px; }
    .topbar nav a { color: white; text-decoration: none; font-weight: bold; }
    .content { margin-left: 100px; padding: 20px; }
    .table-header, .table-row { display: grid; grid-template-columns: 1fr 3fr 1fr 1fr 1fr 1fr; gap: 10px; padding: 10px; border-radius: 6px; align-items: center; }
    .table-header { background-color: #338f97; font-weight: bold; margin-bottom: 10px; }
    .table-row { background-color: #2c2c2c; margin-bottom: 10px; }
    .product-info { display: flex; align-items: center; }
    .product-image { width: 60px; height: 60px; border-radius: 10px; object-fit: cover; margin-right: 10px; }
    .product-details h4 { margin: 0; }
    .product-details p { margin: 0; font-size: 12px; color: #90ee90; }
    .actions { display: flex; gap: 10px; }
    .actions button { background: none; border: none; cursor: pointer; font-size: 16px; color: white; }
    .actions button.delete { color: red; }
    .grand-total { display: flex; justify-content: flex-end; margin-top: 20px; }
    .grand-total button { background-color: #42c5c6; border: none; padding: 10px 20px; border-radius: 8px; color: white; font-weight: bold; font-size: 16px; }
  </style>
</head>
<body>

<div class="sidebar">
  <a href="menu.php" style="text-decoration: none; color: white;">
    <div><strong>MENU</strong></div>
  </a>
  <div class="current"><strong>SALES REPORT</strong></div>
  <div><strong>ORDERS</strong></div>
  <div><strong>SETTINGS</strong></div>
</div>

<div class="topbar">
  <h2>QUICK SALES</h2>
  <nav>
    <a href="#">HOME</a>
    <a href="#">ABOUT US</a>
  </nav>
</div>

<div class="content">
  <div class="table-header">
    <span>Order No.</span>
    <span>Product</span>
    <span>Quantity</span>
    <span>Price</span>
    <span>Actions</span>
  </div>

  <div id="sales-list">
    <!-- PHP will populate this -->
    <?php
    $total = 0;
    foreach ($salesData as $item) {
      $itemTotal = $item['price'] * $item['quantity'];
      $total += $itemTotal;
      echo "
        <div class='table-row'>
          <div>#{$item['order_id']}</div>
          <div class='product-info'>
            <img src='{$item['image_path']}' alt='{$item['item_name']}' class='product-image'/>
            <div class='product-details'>
              <h4>{$item['item_name']}</h4>
              <p>Price: ₱{$item['price']}</p>
            </div>
          </div>
          <div>{$item['quantity']}</div>
          <div>₱{$itemTotal}</div>
          <div class='actions'>
            <button class='edit'>✏️</button>
            <button class='delete' onclick='deleteItem({$item['order_id']})'>🗑️</button>
          </div>
        </div>
      ";
    }
    ?>
  </div>

  <div class="grand-total">
    <button id="totalPrice">Total Grand Price: ₱<?= number_format($total, 2) ?></button>
  </div>
</div>

<script>
  function deleteItem(orderId) {
    if (confirm('Are you sure you want to delete this order?')) {
      fetch(`delete_order.php?id=${orderId}`, { method: 'GET' })
        .then(res => res.json())
        .then(data => {
          if (data.status === 'success') {
            alert('Order deleted!');
            location.reload(); // Refresh the page
          } else {
            alert('Failed to delete the order.');
          }
        })
        .catch(err => alert('Error: ' + err));
    }
  }
</script>

</body>
</html>
