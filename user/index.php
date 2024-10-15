<?php 
session_start();
// Ensure the user is logged in and has the correct role
if (!isset($_SESSION['staffid']) || $_SESSION['role'] != 'user') {
    header("Location: ../login.php"); // Redirect if not a regular user
    exit;
}

$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Unknown User';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <!-- Include Tailwind CSS -->
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
            <!-- Left side: Dashboard title -->
            <div class="text-white text-lg font-semibold">
                User Dashboard
            </div>

            <!-- Right side: User info and Logout -->
            <div class="flex items-center space-x-4">
                <span class="text-white">Hello, <?php echo htmlspecialchars($username); ?>!</span>
                <a href="logout.php" class="btn-logout px-4 py-2 rounded-lg hover:bg-gray-100 transition duration-300">Logout</a>
            </div>
        </div>
    </nav>

<!-- Main Section -->
<div class="flex flex-col items-center mt-10 space-y-4">
    <a href="addComplain.php" class="action-btn mb-4 w-64 text-center py-4">Add Complaint</a>
    <a href="viewUserComplain.php" class="action-btn w-64 text-center py-4">View My Complaint</a>
</div>


</body>
</html>
