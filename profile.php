<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>My Profile</title>
  <style>
    body {
      margin: 0;
      font-family: "Segoe UI", sans-serif;
      background-color: #005c66;
      color: white;
    }

    .container {
      display: flex;
      height: 100vh;
    }

    .sidebar {
      width: 250px;
      background-color: #2e6972;
      padding: 20px;
    }

    .sidebar button {
      width: 100%;
      padding: 15px;
      margin-bottom: 10px;
      border: none;
      border-radius: 10px;
      font-size: 16px;
      cursor: pointer;
      background-color: #447c86;
      color: white;
    }

    .sidebar button.active {
      background-color: #d3f4ea;
      color: black;
      font-weight: bold;
    }

    .main {
      flex: 1;
      padding: 40px;
    }

    .profile-box {
      background-color: #3b7e8b;
      padding: 30px;
      border-radius: 10px;
      max-width: 700px;
      margin: auto;
    }

    .profile-header {
      text-align: center;
      margin-bottom: 30px;
    }

    .profile-header img {
      width: 100px;
      height: 100px;
      border-radius: 50%;
    }

    .profile-header h2 {
      margin: 10px 0 5px;
    }

    .profile-header p {
      font-size: 14px;
      color: #ddd;
    }
  
    label {
  display: block;
  margin-top: 15px;
  margin-bottom: 5px;
  font-weight: bold;
  }

  input {
  width: 100%;
  padding: 10px 12px;
  border-radius: 8px;
  border: none;
  background-color: #2c2c2c;
  color: white;
  font-size: 15px;
  box-sizing: border-box;
  }


  .password-row {
  display: flex;
  gap: 10px; 
  margin-top: 15px;
}

.password-row > div {
  flex: 1;
}
    .buttons {
      display: flex;
      justify-content: space-between;
      margin-top: 30px;
    }

    .buttons a, .buttons button {
      text-decoration: none;
      padding: 10px 20px;
      border-radius: 10px;
      font-size: 16px;
      border: none;
      cursor: pointer;
    }

    .discard-btn {
      background: none;
      color: #d3f4ea;
    }

    .save-btn {
      background-color: #d3f4ea;
      color: #003c3c;
    }
    .sidebar-button {
        display: block;
        padding: 15px;
        margin-bottom: 10px;
        border-radius: 10px;
        font-size: 16px;
        text-align: center;
        background-color: #447c86;
        color: white;
        text-decoration: none;
    }
        .sidebar-button:hover {
        background-color: #d3f4ea;
        color: black;
    }

  </style>
</head>
<body>
  <div class="container">
    <div class="sidebar">
      <button class="active">👤 My Profile</button>
      <a href="salesreport.php" class="sidebar-button">⚙️ Manage POS</a>
      <a href="loginform.php" class="sidebar-button">🔓 Logout</a>
    </div>
    <div class="main">
      <div class="profile-box">
        <div class="profile-header">
          <img src="unnamed.jpg" alt="Profile Picture">
          <h2>Sumatra, Justin</h2>
          <p>Manager</p>
        </div>
        <form>
          <label for="first-name">First Name</label>
          <input type="text" id="first-name" value="Justin">

          <label for="email">Email</label>
          <input type="email" id="email" value="gyatt1234@gmail.com">

          <label for="address">Address</label>
          <input type="text" id="address" value="Barangay Amsic">

          <div class="password-row">
            <div>
              <label for="new-password">New Password</label>
              <input type="password" id="new-password">
            </div>
            <div>
              <label for="confirm-password">Confirm Password</label>
              <input type="password" id="confirm-password">
            </div>
          </div>

          <div class="buttons">
            <a href="#" class="discard-btn">Discard Changes</a>
            <button type="submit" class="save-btn">Save Changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
