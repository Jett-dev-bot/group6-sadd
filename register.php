<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - Point of Sale</title>
    <style>
        body {
            background-color: #062e33;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .register-container {
            background-color: #0b4f56;
            width: 400px;
            margin: 200px auto;
            padding: 40px 30px;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0,0,0,0.3);
            color: #ffffff;
            text-align: center;
        }

        .register-container h2 {
            font-family: 'Courier New', Courier, monospace;
            font-size: 20px;
            margin-bottom: 10px;
        }

        .register-container .cart-icon {
            font-size: 32px;
            margin-bottom: 20px;
        }

        .register-container input[type="text"],
        .register-container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0 20px;
            background-color: transparent;
            border: 1px solid #fff;
            border-radius: 5px;
            color: #ffffff;
        }

        .register-container input::placeholder {
            color: #ccc;
        }

        .register-container input[type="submit"] {
            background-color: #dcdcdc;
            color: #000;
            padding: 15px 40px;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            font-weight: bold;
        }

        .register-container input[type="submit"]:hover {
            background-color: rgb(98, 97, 108);
        }
    </style>
</head>
<body>

<div class="register-container">
    <h2>POINT OF SALE</h2>
    <div class="cart-icon">🛒</div>
    <form action="actionpage.php" method="POST">
        <input type="text" name="name" placeholder="Name" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" value="Register">
    </form>
</div>

</body>
</html>
