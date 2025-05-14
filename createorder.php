<?php
include 'db.php';

$orderData = json_decode(file_get_contents('php://input'), true);
$items = $orderData['items'];

try {
    // Start the transaction
    $pdo->beginTransaction();

    // Insert the order
    $stmt = $pdo->prepare('INSERT INTO orders (order_date) VALUES (NOW())');
    $stmt->execute();
    $orderId = $pdo->lastInsertId();

    // Prepare the insert statement for order_items
    $stmt = $pdo->prepare('INSERT INTO order_items (order_id, menu_item_id, quantity, price) VALUES (?, ?, ?, ?)');

    // Loop through each item and insert it into order_items
    foreach ($items as $item) {
        // Check if the menu item exists
        $stmtCheck = $pdo->prepare('SELECT id FROM menu_items WHERE id = ?');
        $stmtCheck->execute([$item['id']]);
        $menuItem = $stmtCheck->fetch();

        if (!$menuItem) {
            throw new Exception('Invalid menu item ID: ' . $item['id']);
        }

        // Insert the item into the order_items table
        $stmt->execute([$orderId, $item['id'], $item['quantity'], $item['price']]);
    }

    // Commit the transaction
    $pdo->commit();
    echo json_encode(['status' => 'success', 'order_id' => $orderId]);
} catch (Exception $e) {
    $pdo->rollBack();
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
