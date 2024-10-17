<?php 
session_start();
// Ensure the user is logged in and has the correct role
if (!isset($_SESSION['id']) || $_SESSION['role'] != 'admin') {
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
    <!-- Custom Styling -->
    <style>
                .navbar {
            background-color: #4CAF50; /* Green background for the navbar */
        }
        .navbar .btn-logout {
            background-color: white;
            color: #4CAF50;
        }
        .navbar .btn-logout:hover {
            background-color: #f1f1f1;
        }
        .action-btn {
            background-color: #2196F3; /* Blue button color */
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .action-btn:hover {
            background-color: #1976D2; /* Darker blue on hover */
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
    
<!-- Navigation Bar -->
    <nav class="navbar p-4">
        <div class="container mx-auto flex justify-between items-center">
            <!-- Left side: Dashboard Title -->
            <div class="text-white text-lg font-semibold">
                Admin Dashboard
            </div>

            <!-- Right side: User info and Logout -->
            <div class="flex items-center space-x-4">
                <span class="text-white">Welcome, <?php echo htmlspecialchars($username); ?>!</span>
                <a href="logout.php" class="btn-logout px-4 py-2 rounded-lg hover:bg-gray-100 transition duration-300">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Main Content with Image Buttons -->
    <div class="container mx-auto text-center py-10">
        <div class="grid grid-cols-4 gap-6">
            
            <!-- Button to Add Users -->
            <a href="addUsers.php" class="block transform hover:scale-105 transition duration-300">
                <img src="../img/addUser.png" alt="Add Users" class="mx-auto w-64 h-64 object-cover rounded-lg shadow-lg">
                <p class="mt-4 text-xl font-bold">Add Users</p>
            </a>
            
            <!-- Button to Add Investigation -->
            <a href="addInvestigation.php" class="block transform hover:scale-105 transition duration-300">
                <img src="../img/invistigation.jpg" alt="Add Investigation" class="mx-auto w-64 h-64 object-cover rounded-lg shadow-lg">
                <p class="mt-4 text-xl font-bold">Add Investigation</p>
            </a>

            <!-- Button to View User Complaints -->
            <a href="user_complaints.php" class="block transform hover:scale-105 transition duration-300">
                <img src="../img/complaint.jpg" alt="View User Complaints" class="mx-auto w-64 h-64 object-cover rounded-lg shadow-lg">
                <p class="mt-4 text-xl font-bold">View User Complaints</p>
            </a>

            <!-- Button to View Assigned Complaints -->
            <a href="ViewAssCompl.php" class="block transform hover:scale-105 transition duration-300">
                <img src="../img/pin.png" alt="View Assigned Complaints" class="mx-auto w-64 h-64 object-cover rounded-lg shadow-lg">
                <p class="mt-4 text-xl font-bold">View Assigned Complaints</p>
            </a>
        </div>
    </div>
    <!-- Reset Password Button -->
    <div class="flex justify-center mt-10">
        <a href="reset_password.php" class="bg-white text-red-600 font-bold py-3 px-6 rounded-lg hover:bg-gray-100 transition duration-300 shadow-md">
            Reset Password
        </a>
    </div>
</body>
</html>
