<?php
header('Content-Type: application/json');
require_once '../config/koneksi.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo json_encode(['error' => 'Missing order ID']);
    exit;
}

$id = $conn->real_escape_string($_GET['id']);
$sql = "SELECT queue_number, user_name, phone, payment_method, total_price, queue_status, payment_status, estimated_minutes, processing_start_time, created_at, updated_at FROM orders WHERE queue_number = '$id' OR id = '$id' LIMIT 1";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    echo json_encode($result->fetch_assoc());
} else {
    echo json_encode(['error' => 'Order not found']);
}
?>
