<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Forgot Password | QuickSales</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
      background-color: #111827; /* dark slate */
      color: #ffffff;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
    }

    .container {
      background-color: #1f2937; /* dark gray */
      padding: 40px 30px;
      border-radius: 16px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
      max-width: 400px;
      width: 100%;
      text-align: center;
    }

    .logo {
      font-size: 28px;
      font-weight: bold;
      margin-bottom: 20px;
    }

    .logo span {
      color: #facc15; /* yellow-300 */
    }

    h2 {
      font-size: 20px;
      margin-bottom: 8px;
      font-weight: 600;
    }

    p {
      font-size: 14px;
      color: #d1d5db; /* light gray */
      margin-bottom: 25px;
    }

    .form-group {
      text-align: left;
      margin-bottom: 20px;
    }

    .form-group label {
      font-size: 14px;
      margin-bottom: 6px;
      display: block;
    }

    .form-group input {
      width: 100%;
      padding: 12px;
      border: none;
      border-radius: 8px;
      background-color: #374151; /* dark input */
      color: white;
    }

    .form-group input::placeholder {
      color: #9ca3af;
    }

    .submit-btn {
      width: 100%;
      padding: 12px;
      background-color: #facc15; /* yellow-300 */
      border: none;
      border-radius: 8px;
      color: #1f2937; /* dark gray text */
      font-weight: bold;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    .submit-btn:hover {
      background-color: #fbbf24; /* yellow-400 */
    }

    .back-link {
      display: block;
      margin-top: 25px;
      font-size: 14px;
      color: #facc15;
      text-decoration: underline;
      cursor: pointer;
    }
  </style>
</head>
<body>

  <div class="container">
    <div class="logo">QUICK<span>SALES</span></div>
    <h2>Forgot your password?</h2>
    <p>Please enter your username or email to recover your password</p>

    <form action="#" method="POST">
      <div class="form-group">
        <label for="username">Username / Email</label>
        <input type="text" id="username" name="username" placeholder="Enter your username or email" required>
      </div>

      <button type="submit" class="submit-btn">Submit Now</button>
    </form>

    <a href="loginform.php" class="back-link">← Back to login</a>
  </div>

</body>
</html>
