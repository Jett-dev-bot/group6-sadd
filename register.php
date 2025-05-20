<?php
$error = $_GET['error'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Register - QuickSales POS</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
</head>
<body class="bg-gray-900 text-white font-sans flex items-center justify-center min-h-screen">

  <!-- Register Card -->
  <div class="bg-gray-800 p-8 rounded-2xl shadow-lg w-full max-w-md">
    <h2 class="text-2xl font-bold text-center mb-2">QuickSales</h2>
    <div class="text-4xl text-center mb-6">🛒</div>
    
    <form action="actionpage.php" method="POST" class="space-y-4">
      <div>
        <input type="text" name="name" placeholder="Name" required
          class="w-full p-3 rounded-lg bg-gray-700 text-white focus:outline-none placeholder-gray-400" />
      </div>
      <div>
        <input type="password" name="password" placeholder="Password" required
          class="w-full p-3 rounded-lg bg-gray-700 text-white focus:outline-none placeholder-gray-400" />
      </div>
      <div>
        <input type="submit" value="Register"
          class="w-full bg-yellow-300 text-gray-900 font-bold py-3 rounded-lg hover:bg-yellow-400 transition" />
      </div>
    </form>

    <p class="text-center text-sm text-gray-300 mt-4">
      Already have an account?
      <a href="loginform.php" class="text-yellow-300 font-semibold hover:underline ml-1">Login →</a>
    </p>
  </div>

  <!-- Error Modal -->
  <?php if ($error === 'username'): ?>
  <div id="errorModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-60 z-50">
    <div class="bg-gray-800 text-white p-6 rounded-xl shadow-lg text-center max-w-sm w-full">
      <h3 class="text-lg font-bold mb-2">⚠️ Username Already Exists</h3>
      <p class="text-sm text-gray-300">Please choose a different username.</p>
      <button onclick="document.getElementById('errorModal').style.display='none';"
        class="mt-4 px-4 py-2 bg-yellow-300 text-gray-900 font-semibold rounded hover:bg-yellow-400 transition">
        Close
      </button>
    </div>
  </div>
  <?php endif; ?>

</body>
</html>
