<?php
header('Content-Type: application/json');
require_once '../config/koneksi.php';

// Auto-cleanup: Delete completed/done orders older than 2 days
$conn->query("DELETE FROM orders WHERE queue_status IN ('completed', 'done') AND created_at < NOW() - INTERVAL 2 DAY");

$sql = "SELECT * FROM orders ORDER BY created_at ASC";
$result = $conn->query($sql);

$orders = [];
if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }
}
echo json_encode($orders);
?>
