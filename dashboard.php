<?php
include 'db.php';

// Total Sales
$stmtSales = $pdo->query("SELECT SUM(oi.quantity * oi.price) AS total_sales FROM order_items oi");
$totalSales = $stmtSales->fetchColumn() ?? 0;

// Total Orders
$stmtOrders = $pdo->query("SELECT COUNT(DISTINCT id) FROM orders");
$totalOrders = $stmtOrders->fetchColumn() ?? 0;

// Items in Stock
$stmtStock = $pdo->query("SELECT COUNT(stock) FROM menu_items");
$totalStock = $stmtStock->fetchColumn() ?? 0;

// Weekly Sales Data (Past 7 Days)
$stmtWeekly = $pdo->query("
    SELECT DATE(order_date) as day, SUM(oi.quantity * oi.price) AS daily_total
    FROM orders o
    JOIN order_items oi ON o.id = oi.order_id
    WHERE order_date >= DATE_SUB(CURDATE(), INTERVAL 6 DAY)
    GROUP BY DATE(order_date)
    ORDER BY day
");
$weeklyData = $stmtWeekly->fetchAll(PDO::FETCH_ASSOC);

// Prepare ng chart data
$days = [];
$totals = [];
$weekMap = [];

foreach ($weeklyData as $row) {
    $weekMap[$row['day']] = $row['daily_total'];
}

for ($i = 6; $i >= 0; $i--) {
    $date = date('Y-m-d', strtotime("-$i days"));
    $days[] = date('D', strtotime($date));
    $totals[] = $weekMap[$date] ?? 0;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>QuickSales Dashboard</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
</head>
<body class="bg-gray-900 text-white font-sans">

  <!-- Sidebar -->
  <aside class="fixed top-0 left-0 w-64 h-screen bg-teal-900 shadow-lg p-6">
    <h1 class="text-2xl font-bold mb-8">QuickSales</h1>
    <nav class="space-y-4">
      <a href="menu.php" class="block hover:underline">📋 Menu</a>
      <a href="salesreport.php" class="block hover:underline">📊 Sales Report</a>
      <a href="dashboard.php" class="block font-semibold underline text-yellow-300">📈 Dashboard</a>
      <a href="profile.php" class="block hover:underline">👤 Profile</a>
    </nav>
  </aside>

  <!-- Main Content -->
  <main class="ml-64 p-6">
    
    <!-- Topbar -->
    <header class="bg-teal-800 p-4 rounded-lg mb-6 flex justify-between items-center">
      <h2 class="text-xl font-bold">Dashboard</h2>
    </header>

    <!-- Cards -->
    <section class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
      <div class="bg-gray-800 p-6 rounded-lg shadow text-center">
        <h3 class="text-lg font-semibold mb-2">Total Sales</h3>
        <p class="text-3xl font-bold text-yellow-400">₱<?= number_format($totalSales, 2) ?></p>
      </div>
      <div class="bg-gray-800 p-6 rounded-lg shadow text-center">
        <h3 class="text-lg font-semibold mb-2">Total Orders</h3>
        <p class="text-3xl font-bold text-yellow-400"><?= $totalOrders ?></p>
      </div>
      <div class="bg-gray-800 p-6 rounded-lg shadow text-center">
        <h3 class="text-lg font-semibold mb-2">Items in Stock</h3>
        <p class="text-3xl font-bold text-yellow-400"><?= $totalStock ?></p>
      </div>
    </section>

    <!-- Chart Section -->
    <section class="bg-gray-800 p-6 rounded-lg shadow">
      <h3 class="text-lg font-semibold mb-4">Weekly Sales Overview</h3>
      <canvas id="salesChart" height="100"></canvas>
    </section>

  </main>

  <!-- Chart Script -->
  <script>
    const ctx = document.getElementById('salesChart').getContext('2d');
    const salesChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: <?= json_encode($days) ?>,
        datasets: [{
          label: '₱ Sales',
          data: <?= json_encode($totals) ?>,
          borderColor: '#ecc94b',
          backgroundColor: 'rgba(236, 201, 75, 0.2)',
          borderWidth: 2,
          fill: true,
          tension: 0.4
        }]
      },
      options: {
        responsive: true,
        scales: {
          y: {
            ticks: { color: '#ffffff' },
            grid: { color: '#4a5568' }
          },
          x: {
            ticks: { color: '#ffffff' },
            grid: { color: '#4a5568' }
          }
        },
        plugins: {
          legend: {
            labels: { color: '#ffffff' }
          }
        }
      }
    });
  </script>

</body>
</html>
