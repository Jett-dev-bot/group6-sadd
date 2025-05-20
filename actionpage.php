<?php
// Start session & connect to DB
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "project pos";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get POST data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $raw_password = trim($_POST['password']);
    $hashed_password = password_hash($raw_password, PASSWORD_DEFAULT);

    // Check if username already exists
    $stmt = $conn->prepare("SELECT id FROM manager WHERE name = ?");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Redirect back to register page with error flag for modal
        header("Location: register.php?error=username");
        $stmt->close();
        $conn->close();
        exit;
    }

    $stmt->close();

    // Insert into DB
    $stmt = $conn->prepare("INSERT INTO manager (name, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $name, $hashed_password);

    if ($stmt->execute()) {
        header("Location: loginform.php");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
