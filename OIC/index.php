<?php 
session_start();
// Ensure the user is logged in and has the correct role
if (!isset($_SESSION['id']) || $_SESSION['role'] != 'OIC') {
    header("Location: ../login.php"); // Redirect if not OIC
    exit;
}

$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Unknown User';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OIC Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen">
    
<!-- Navigation Bar -->
<nav class="bg-green-600 p-4">
    <div class="container mx-auto flex justify-between items-center">
        <!-- Left side: Dashboard Title -->
        <div class="text-white text-lg font-semibold">
            OIC Dashboard
        </div>

        <!-- Right side: User info and Logout -->
        <div class="flex items-center space-x-4">
            <span class="text-white">Welcome, <?php echo htmlspecialchars($username); ?>!</span>
            <a href="logout.php" class="bg-white text-green-600 px-4 py-2 rounded-lg hover:bg-gray-100 transition duration-300">Logout</a>
        </div>
    </div>
</nav>

<!-- Center: Add Investigation Button -->
<div class="flex justify-center mt-10">
    <a href="addInvestigation.php" class="bg-white text-green-600 font-bold py-3 px-6 rounded-lg hover:bg-gray-100 transition duration-300 shadow-md">
        Add Investigation
    </a>
</div>

<!-- View Complaint Button -->
<div class="flex justify-center mt-10">
    <a href="user_complaints.php" class="bg-white text-green-600 font-bold py-3 px-6 rounded-lg hover:bg-gray-100 transition duration-300 shadow-md">
        View Complaint
    </a>
</div>

<div class="flex justify-center mt-10">
    <a href="addnews.php" class="bg-white text-green-600 font-bold py-3 px-6 rounded-lg hover:bg-gray-100 transition duration-300 shadow-md">
        Add Newa Alert
    </a>
</div>

<!-- Reset Password Button -->
<div class="flex justify-center mt-10">
    <a href="reset_password.php" class="bg-white text-red-600 font-bold py-3 px-6 rounded-lg hover:bg-gray-100 transition duration-300 shadow-md">
        Reset Password
    </a>
</div>

</body>
</html>
