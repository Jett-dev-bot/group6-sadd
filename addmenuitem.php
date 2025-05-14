<?php
include 'db.php';

$data = json_decode(file_get_contents('php://input'), true);

$name = $data['name'];
$price = $data['price'];
$description = $data['description'];
$image = $data['image']; // Assuming this is the base64 image data

try {
    // Insert the new menu item into the menu_items table
    $stmt = $pdo->prepare('INSERT INTO menu_items (name, price, description, image_path) VALUES (?, ?, ?, ?)');
    $stmt->execute([$name, $price, $description, $image]);

    // Return success message with the inserted item id
    echo json_encode(['status' => 'success']);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
