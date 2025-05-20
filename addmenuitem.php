<?php
include 'db.php';

$data = json_decode(file_get_contents("php://input"), true);

$name = $data['name'];
$price = $data['price'];
$description = $data['description'];
$imageData = $data['image']; // base64 image

// Extract image type
if (preg_match('/^data:image\/(\w+);base64,/', $imageData, $type)) {
    $imageData = substr($imageData, strpos($imageData, ',') + 1);
    $type = strtolower($type[1]); // jpg, png, gif

    if (!in_array($type, ['jpg', 'jpeg', 'png', 'gif'])) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid image type']);
        exit;
    }

    $imageData = base64_decode($imageData);
    if ($imageData === false) {
        echo json_encode(['status' => 'error', 'message' => 'Base64 decode failed']);
        exit;
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid image format']);
    exit;
}

// Save image to 'uploads/' folder
$filename = 'uploads/' . uniqid() . '.' . $type;
file_put_contents($filename, $imageData);

// Save item to database
$stmt = $pdo->prepare("INSERT INTO menu_items (name, price, description, image_path) VALUES (?, ?, ?, ?)");
$stmt->execute([$name, $price, $description, $filename]);

echo json_encode(['status' => 'success']);
