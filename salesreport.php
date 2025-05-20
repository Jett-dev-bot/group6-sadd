<?php
include 'db.php';

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
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
</head>
<body class="bg-gray-900 text-white font-sans">

  <!-- Sidebar -->
  <aside class="fixed top-0 left-0 w-64 h-screen bg-teal-900 shadow-lg p-6">
    <h1 class="text-2xl font-bold mb-8">QuickSales</h1>
    <nav class="space-y-4">
      <a href="menu.php" class="block hover:underline">📋 Menu</a>
      <a href="salesreport.php" class="block font-semibold underline text-yellow-300">📊 Sales Report</a>
      <a href="dashboard.php" class="block hover:underline">📈 Dashboard</a>
      <a href="profile.php" class="block hover:underline">👤 Profile</a>
    </nav>
  </aside>

  <!-- Main Content -->
  <main class="ml-64 p-6">
    
    <!-- Topbar -->
    <header class="bg-teal-800 p-4 rounded-lg mb-6 flex justify-between items-center">
      <h2 class="text-xl font-bold">Sales Report</h2>
    </header>

    <!-- Sales Table -->
    <section class="bg-gray-800 p-6 rounded-lg shadow">
      <div class="grid grid-cols-5 font-semibold text-sm border-b border-gray-600 pb-2 mb-4">
        <div>Order No.</div>
        <div>Product</div>
        <div>Quantity</div>
        <div>Price</div>
        <div>Actions</div>
      </div>

      <?php
      $total = 0;
      foreach ($salesData as $item):
        $itemTotal = $item['price'] * $item['quantity'];
        $total += $itemTotal;
      ?>
        <div class="grid grid-cols-5 items-center mb-4 bg-gray-700 p-3 rounded">
          <div>#<?= $item['order_id'] ?></div>
          <div class="flex items-center gap-4">
            <img src="<?= $item['image_path'] ?>" alt="<?= $item['item_name'] ?>" class="w-14 h-14 rounded object-cover">
            <div>
              <p class="font-bold text-sm"><?= $item['item_name'] ?></p>
              <p class="text-green-300 text-xs">₱<?= number_format($item['price'], 2) ?></p>
            </div>
          </div>
          <div><?= $item['quantity'] ?></div>
          <div>₱<?= number_format($itemTotal, 2) ?></div>
          <div class="space-x-2 text-lg">
            <button title="Edit">✏️</button>
            <button class="text-red-400" onclick="deleteItem(<?= $item['order_id'] ?>)" title="Delete">🗑️</button>
          </div>
        </div>
      <?php endforeach; ?>
    </section>

    <!-- Total -->
    <div class="mt-6 text-right">
      <span class="bg-yellow-300 text-gray-900 font-bold px-6 py-3 rounded inline-block text-lg">
        Total Grand Price: ₱<?= number_format($total, 2) ?>
      </span>
    </div>

  </main>

  <script>
    function deleteItem(orderId) {
      if (confirm('Are you sure you want to delete this order?')) {
        fetch(`delete_order.php?id=${orderId}`, { method: 'GET' })
          .then(res => res.json())
          .then(data => {
            if (data.status === 'success') {
              alert('Order deleted!');
              location.reload();
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
