<?php
header('Content-Type: application/json');
require_once '../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Escape and sanitize all inputs
    $user_name = mysqli_real_escape_string($conn, $_POST['user_name'] ?? '');
    $phone = mysqli_real_escape_string($conn, $_POST['phone'] ?? '');
    $payment_method = mysqli_real_escape_string($conn, $_POST['payment_method'] ?? 'cash');
    $service_type = mysqli_real_escape_string($conn, $_POST['service_type'] ?? 'document');
    $paper_option = mysqli_real_escape_string($conn, $_POST['paper_option'] ?? '');
    
    // Map UI names to standard DB columns
    $print_type = ($service_type === 'photo') ? 'Photo Print' : 'Document Print';
    if (!empty($paper_option)) {
        $print_type .= " [$paper_option]";
    }
    
    $pages = 1; // Default or extractable from file info
    $copies = (int)($_POST['quantity'] ?? 1);
    $addons = $_POST['addons'] ?? [];

    if (empty($user_name) || empty($phone)) {
        echo json_encode(['success' => false, 'message' => 'Name and phone are required.']);
        exit;
    }
    
    if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(['success' => false, 'message' => 'Valid file is required.']);
        exit;
    }

    // Calculate base price
    $base_price = ($service_type === 'photo') ? 2000 : 500;
    $total_price = $base_price * $copies;
    
    // Add-on definitions
    $addon_prices = ['pencil' => 2000, 'folder' => 3000];
    $addon_names = ['pencil' => 'Pencil', 'folder' => 'Plastic Folder'];
    
    $addons_cost = 0;
    $addons_summary_arr = [];
    foreach($addons as $key => $qty) {
        $q = (int)$qty;
        if($q > 0 && isset($addon_prices[$key])) {
            $addons_cost += ($q * $addon_prices[$key]);
            $addons_summary_arr[] = $addon_names[$key] . " x$q";
        }
    }
    $total_price += $addons_cost;
    $add_ons_summary = mysqli_real_escape_string($conn, !empty($addons_summary_arr) ? implode(', ', $addons_summary_arr) : '-');

    // Generate Automated Queue Number (Q-001, Q-002, etc.)
    $q_res = mysqli_query($conn, "SELECT queue_number FROM orders ORDER BY id DESC LIMIT 1");
    if ($q_res && mysqli_num_rows($q_res) > 0) {
        $last_q = mysqli_fetch_assoc($q_res)['queue_number'];
        $num = (int)str_replace('Q-', '', $last_q) + 1;
        $queue_number = 'Q-' . str_pad($num, 3, '0', STR_PAD_LEFT);
    } else {
        $queue_number = 'Q-001';
    }
    
    $estimated_minutes = $copies * 2;
    $payment_status = 'pending';
    $queue_status = ($payment_method === 'cash') ? 'processing' : 'waiting';
    $date = date('Y-m-d H:i:s');

    // Handle file upload
    $upload_dir = '../uploads/';
    if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
    $file_ext = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
    $file_name = uniqid() . '.' . $file_ext;
    $file_path = $upload_dir . $file_name;
    
    if (!move_uploaded_file($_FILES['file']['tmp_name'], $file_path)) {
        echo json_encode(['success' => false, 'message' => 'Failed to upload file.']);
        exit;
    }

    // Insert order using the strictly required standard columns
    $query = "INSERT INTO orders (queue_number, user_name, phone, print_type, pages, copies, total_price, payment_method, payment_status, queue_status, estimated_minutes, add_ons_summary, created_at, updated_at) 
                  VALUES ('$queue_number', '$user_name', '$phone', '$print_type', $pages, $copies, $total_price, '$payment_method', '$payment_status', '$queue_status', $estimated_minutes, '$add_ons_summary', '$date', '$date')";
    
    // Explicit Error Handling
    if (!mysqli_query($conn, $query)) {
        echo json_encode(['success' => false, 'message' => 'Database Error: ' . mysqli_error($conn)]);
        exit;
    }

    $order_id = mysqli_insert_id($conn);
    echo json_encode(['success' => true, 'queue_number' => $queue_number, 'order_id' => $order_id]);

} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
