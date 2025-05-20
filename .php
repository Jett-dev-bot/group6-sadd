<?php
include 'db.php';

$query = 'SELECT * FROM orders ORDER BY order_date DESC';
$stmt = $pdo->prepare($query);
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo '<h1>Order Records</h1>';
echo '<table>';
echo '<tr><th>Order ID</th><th>Date</th><th>Total</th></tr>';

foreach ($orders as $order) {
    $orderId = $order['id'];
    $stmt = $pdo->prepare('SELECT SUM(price * quantity) AS total FROM order_items WHERE order_id = ?');
    $stmt->execute([$orderId]);
    $total = $stmt->fetchColumn();

    echo "<tr><td>$orderId</td><td>{$order['order_date']}</td><td>₱$total</td></tr>";
}

echo '</table>';
?>
