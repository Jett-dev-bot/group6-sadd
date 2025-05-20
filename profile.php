<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>My Profile</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
</head>
<body class="bg-gray-900 text-white font-sans">

  <!-- Sidebar -->
  <aside class="fixed top-0 left-0 w-64 h-screen bg-teal-900 shadow-lg p-6">
    <h1 class="text-2xl font-bold mb-8">QuickSales</h1>
    <nav class="space-y-4 text-base font-medium">
      <a href="menu.php" class="block hover:underline">📋 Menu</a>
      <a href="salesreport.php" class="block hover:underline">📊 Sales Report</a>
      <a href="dashboard.php" class="block hover:underline">📈 Dashboard</a>
      <a href="profile.php" class="block font-semibold underline text-yellow-300">👤 Profile</a>
      <form action="logout.php" method="post">
        <button type="submit" class="block hover:underline text-red-400">🚪 Logout</button>
      </form>
    </nav>
  </aside>

  <!-- Main Content -->
  <main class="ml-64 p-6">
    <!-- Header -->
    <header class="bg-teal-800 p-4 rounded-lg mb-6 flex justify-between items-center">
      <h2 class="text-xl font-bold">My Profile</h2>
    </header>

    <!-- Profile Form Box -->
    <section class="bg-gray-800 p-6 rounded-lg shadow max-w-3xl mx-auto">
      <div class="text-center mb-6">
        <img src="unnamed.jpg" alt="Profile Picture" class="w-24 h-24 mx-auto rounded-full object-cover mb-2">
        <h2 class="text-2xl font-bold">Sumatra, Justin</h2>
        <p class="text-sm text-gray-300">Manager</p>
      </div>

      <form>
        <div class="mb-4">
          <label for="first-name" class="block font-semibold mb-1">First Name</label>
          <input type="text" id="first-name" value="Justin" class="w-full bg-gray-700 text-white p-3 rounded-lg focus:outline-none">
        </div>

        <div class="mb-4">
          <label for="email" class="block font-semibold mb-1">Email</label>
          <input type="email" id="email" value="gyatt1234@gmail.com" class="w-full bg-gray-700 text-white p-3 rounded-lg focus:outline-none">
        </div>

        <div class="mb-4">
          <label for="address" class="block font-semibold mb-1">Address</label>
          <input type="text" id="address" value="Barangay Amsic" class="w-full bg-gray-700 text-white p-3 rounded-lg focus:outline-none">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
          <div>
            <label for="new-password" class="block font-semibold mb-1">New Password</label>
            <input type="password" id="new-password" class="w-full bg-gray-700 text-white p-3 rounded-lg focus:outline-none">
          </div>
          <div>
            <label for="confirm-password" class="block font-semibold mb-1">Confirm Password</label>
            <input type="password" id="confirm-password" class="w-full bg-gray-700 text-white p-3 rounded-lg focus:outline-none">
          </div>
        </div>

        <div class="flex justify-between mt-6">
          <a href="#" class="text-yellow-300 hover:underline">Discard Changes</a>
          <button type="submit" class="bg-yellow-300 text-gray-900 font-bold px-6 py-2 rounded-lg hover:bg-yellow-400 transition">Save Changes</button>
        </div>
      </form>
    </section>
  </main>
</body>
</html>
