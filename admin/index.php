<?php 
session_start();
// Ensure the user is logged in and has the correct role
if (!isset($_SESSION['staffid']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php"); // Redirect if not an Admin
    exit;
}

$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Unknown User';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen">
    
<!-- Navigation Bar -->
    <nav class="bg-blue-600 p-4">
        <div class="container mx-auto flex justify-between items-center">
            <!-- Left side: Logo or Name -->
            <div class="text-white text-lg font-semibold">
                Admin Dashboard
            </div>

            <!-- Right side: User info and Logout -->
            <div class="flex items-center space-x-4">
                <span class="text-white">Welcome, <?php echo htmlspecialchars($username); ?>!</span>
                <a href="logout.php" class="bg-white text-blue-600 px-4 py-2 rounded-lg hover:bg-gray-100 transition duration-300">Logout</a>
            </div>
        </div>
    </nav>

    <div class="text-center">
        <h1 class="text-3xl font-bold">Welcome to the Admin Dashboard</h1>
        <p class="mt-4">You have Admin access.</p>
        
        <!-- Button to navigate to user complaints page -->
        <a href="user_complaints.php" class="mt-4 inline-block bg-blue-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-600 transition duration-300">
            View User Complaints
        </a>

        <a href="logout.php" class="mt-4 text-blue-500 hover:underline block">Logout</a>
    </div>
</body>
</html>
