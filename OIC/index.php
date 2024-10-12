<!--    OIC username = 3333
        OIC password = 12345    -->

<?php 
session_start();
// Ensure the user is logged in and has the correct role
if (!isset($_SESSION['staffid']) || $_SESSION['role'] != 'OIC') {
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
    <nav class="bg-blue-600 p-4">
        <div class="container mx-auto flex justify-between items-center">
            <!-- Left side: Logo or Name -->
            <div class="text-white text-lg font-semibold">
                OIC Dashboard
            </div>

            <!-- Right side: User info and Logout -->
            <div class="flex items-center space-x-4">
                <span class="text-white">Welcome, <?php echo htmlspecialchars($username); ?>!</span>
                <a href="logout.php" class="bg-white text-blue-600 px-4 py-2 rounded-lg hover:bg-gray-100 transition duration-300">Logout</a>
            </div>
        </div>
    </nav>

    <div class="text-center">
        <h1 class="text-3xl font-bold">Welcome to the OIC Dashboard</h1>
        <p class="mt-4">You have OIC access.</p>
        <a href="logout.php" class="mt-4 text-blue-500 hover:underline">Logout</a>
    </div>
</body>
</html>
