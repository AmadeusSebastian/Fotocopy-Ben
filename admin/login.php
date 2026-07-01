<?php
session_start();
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: dashboard.php");
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once '../config/koneksi.php';
    
    $email = $conn->real_escape_string($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $hashed_password = md5($password);
    
    $query = "SELECT id, name, email FROM users WHERE email = '$email' AND password = '$hashed_password'";
    $result = $conn->query($query);
    
    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_id'] = $user['id'];
        $_SESSION['admin_name'] = $user['name'];
        $_SESSION['admin_email'] = $user['email'];
        header("Location: dashboard.php");
        exit;
    } else {
        $error = 'Invalid credentials';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Fotocopy Ben</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #f9fafb; }
    </style>
</head>
<body class="font-sans antialiased text-gray-900 flex items-center justify-center min-h-screen">
    
    <div class="w-full sm:max-w-md px-6 py-8 bg-white shadow-xl border border-gray-100 sm:rounded-2xl">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-black tracking-tight text-gray-900">FOTOCOPY BEN</h1>
            <p class="text-sm text-gray-500 mt-2 font-medium uppercase tracking-widest">Admin Portal</p>
        </div>

        <?php if ($error): ?>
            <div class="mb-4 text-sm font-medium text-red-600 bg-red-50 border border-red-200 rounded-lg p-3 text-center">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="" class="space-y-6">
            <div>
                <label for="email" class="block font-medium text-sm text-gray-700">Email</label>
                <input id="email" class="block mt-1 w-full px-4 py-3 border border-gray-300 rounded-xl focus:border-gray-500 focus:ring-gray-500 shadow-sm" type="email" name="email" required autofocus autocomplete="email" />
            </div>

            <div>
                <label for="password" class="block font-medium text-sm text-gray-700">Password</label>
                <input id="password" class="block mt-1 w-full px-4 py-3 border border-gray-300 rounded-xl focus:border-gray-500 focus:ring-gray-500 shadow-sm" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-3 bg-gray-900 border border-transparent rounded-xl font-bold text-xs text-white uppercase tracking-widest hover:bg-gray-800 focus:bg-gray-800 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Log in
                </button>
            </div>
        </form>
    </div>

</body>
</html>
