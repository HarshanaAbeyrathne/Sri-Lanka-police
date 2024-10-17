<?php
session_start();
// Ensure the user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: ../login.php"); // Redirect if not logged in
    exit;
}

include '../dbconnect.php'; // Assuming dbconnect.php connects to your database

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    
    $user_id = $_SESSION['id'];
    
    // Fetch the user's current password
    $sql = "SELECT password FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    
    // Verify current password
    if (sha1($current_password) === $user['password']) {
        if ($new_password === $confirm_password) {
            // Update the password
            $new_password_hashed = sha1($new_password);
            $update_sql = "UPDATE users SET password = ? WHERE id = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param('si', $new_password_hashed, $user_id);
            
            if ($update_stmt->execute()) {
                echo "Password updated successfully!";
            } else {
                echo "Error updating password.";
            }
        } else {
            echo "New password and confirmation do not match.";
        }
    } else {
        echo "Current password is incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen">

<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-4">Reset Password</h1>

    <form action="reset_password.php" method="post" class="bg-white p-6 rounded-lg shadow-md">
        <div class="mb-4">
            <label for="current_password" class="block text-gray-700 font-bold mb-2">Current Password:</label>
            <input type="password" id="current_password" name="current_password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500" required>
        </div>
        <div class="mb-4">
            <label for="new_password" class="block text-gray-700 font-bold mb-2">New Password:</label>
            <input type="password" id="new_password" name="new_password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500" required>
        </div>
        <div class="mb-4">
            <label for="confirm_password" class="block text-gray-700 font-bold mb-2">Confirm New Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500" required>
        </div>
        <div class="flex justify-between">
            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg transition duration-300">Reset Password</button>
        </div>
    </form>

    <!-- Button to go back to the dashboard -->
    <div class="flex justify-center mt-10">
        <a href="index.php" class="bg-white text-green-600 font-bold py-3 px-6 rounded-lg hover:bg-gray-100 transition duration-300 shadow-md">
            Back to Dashboard
        </a>
    </div>
</div>

</body>
</html>
