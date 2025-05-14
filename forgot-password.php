<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Forgot Password | QuickSales</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
      background-color: #065c64;
      color: #fff;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .container {
      width: 100%;
      max-width: 400px;
      background-color: #0e7b86;
      padding: 40px 30px;
      border-radius: 20px;
      text-align: center;
    }

    .logo {
      font-size: 28px;
      font-weight: bold;
      margin-bottom: 30px;
      letter-spacing: 1px;
    }

    .logo span {
      color: #ffffff;
    }

    h2 {
      font-size: 22px;
      margin-bottom: 10px;
    }

    p {
      font-size: 14px;
      color: #d1d1d1;
      margin-bottom: 25px;
    }

    .form-group {
      text-align: left;
      margin-bottom: 20px;
    }

    .form-group label {
      display: block;
      font-size: 14px;
      margin-bottom: 6px;
      color: #ffffff;
    }

    .form-group input {
      width: 100%;
      padding: 12px;
      border: none;
      border-radius: 8px;
      background-color: #2a2a2a;
      color: #fff;
    }

    .form-group input::placeholder {
      color: #bbbbbb;
    }

    .submit-btn {
      width: 100%;
      padding: 12px;
      background-color: #48b9d4;
      border: none;
      border-radius: 8px;
      color: #fff;
      font-weight: bold;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    .submit-btn:hover {
      background-color: #3aa2ba;
    }

    .back-link {
      display: block;
      margin-top: 25px;
      font-size: 14px;
      color: #ffffff;
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

    <div class="form-group">
      <label for="username">Username/Email</label>
      <input type="text" id="username" placeholder="Enter your username">
    </div>

    <button class="submit-btn">Submit Now</button>

    <a href="loginform.php" class="back-link">Back to login</a>
  </div>
</body>
</html>