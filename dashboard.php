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
      <a href="#" class="block font-semibold underline">📈 Dashboard</a>
      <a href="#" class="block hover:underline">⚙️ Settings</a>
    </nav>
  </aside>

  <!-- Main Content -->
  <main class="ml-64 p-6">
    
    <!-- Topbar -->
    <header class="bg-teal-800 p-4 rounded-lg mb-6 flex justify-between items-center">
      <h2 class="text-xl font-bold">Dashboard</h2>
      <nav class="space-x-4 text-sm">
        <a href="#" class="hover:underline">Home</a>
        <a href="#" class="hover:underline">About</a>
      </nav>
    </header>

    <!-- Cards -->
    <section class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
      <div class="bg-gray-800 p-6 rounded-lg shadow text-center">
        <h3 class="text-lg font-semibold mb-2">Total Sales</h3>
        <p class="text-3xl font-bold text-yellow-400">₱15,250</p>
      </div>
      <div class="bg-gray-800 p-6 rounded-lg shadow text-center">
        <h3 class="text-lg font-semibold mb-2">Total Orders</h3>
        <p class="text-3xl font-bold text-yellow-400">87</p>
      </div>
      <div class="bg-gray-800 p-6 rounded-lg shadow text-center">
        <h3 class="text-lg font-semibold mb-2">Items in Stock</h3>
        <p class="text-3xl font-bold text-yellow-400">320</p>
      </div>
    </section>

    <!-- Chart Section -->
    <section class="bg-gray-800 p-6 rounded-lg shadow">
      <h3 class="text-lg font-semibold mb-4">Weekly Sales Overview</h3>
      <canvas id="salesChart" height="100"></canvas>
    </section>

  </main>

  <!-- Chart.js Script -->
  <script>
    const ctx = document.getElementById('salesChart').getContext('2d');
    const salesChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        datasets: [{
          label: '₱ Sales',
          data: [2000, 2500, 1800, 2200, 3000, 2800, 2900],
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
            ticks: {
              color: '#ffffff'
            },
            grid: {
              color: '#4a5568'
            }
          },
          x: {
            ticks: {
              color: '#ffffff'
            },
            grid: {
              color: '#4a5568'
            }
          }
        },
        plugins: {
          legend: {
            labels: {
              color: '#ffffff'
            }
          }
        }
      }
    });
  </script>
</body>
</html>
