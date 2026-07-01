<?php
header('Content-Type: application/json');
require_once '../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $conn->real_escape_string($_POST['id'] ?? '');
    $type = $conn->real_escape_string($_POST['type'] ?? ''); // 'queue' or 'payment'
    $status = $conn->real_escape_string($_POST['status'] ?? '');
    
    if (empty($id) || empty($type) || empty($status)) {
        echo json_encode(['success' => false, 'message' => 'Missing parameters.']);
        exit;
    }

    $date = date('Y-m-d H:i:s');
    
    if ($type === 'queue') {
        if ($status === 'processing') {
            $sql = "UPDATE orders SET queue_status = '$status', updated_at = '$date', processing_start_time = '$date' WHERE id = '$id' OR queue_number = '$id'";
        } else {
            $sql = "UPDATE orders SET queue_status = '$status', updated_at = '$date' WHERE id = '$id' OR queue_number = '$id'";
        }
    } else if ($type === 'payment') {
        $sql = "UPDATE orders SET payment_status = '$status', updated_at = '$date' WHERE id = '$id' OR queue_number = '$id'";
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid type.']);
        exit;
    }

    if ($conn->query($sql)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => $conn->error]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
