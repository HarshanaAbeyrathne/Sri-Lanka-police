<?php 
session_start();
// Ensure the user is logged in and has the correct role
if (!isset($_SESSION['id']) || $_SESSION['role'] != 'CDO') {
    header("Location: ../login.php"); // Redirect if not a regular user
    exit;
}

include '../dbconnect.php';

// Fetch the latest news alert
$news_query = "SELECT * FROM news_alerts ORDER BY date_added DESC LIMIT 1";
$news_result = $conn->query($news_query);
$latest_news = $news_result->fetch_assoc();

$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Unknown User';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .modal {
            display: none;
        }
    </style>
    <script>
        function toggleModal() {
            document.getElementById('news-modal').classList.toggle('hidden');
        }
    </script>
</head>
<body class="bg-gray-100 min-h-screen">
    
<!-- Navigation Bar -->
    <nav class="bg-blue-600 p-4">
        <div class="container mx-auto flex justify-between items-center">
            <!-- Left side: Logo or Name -->
            <div class="text-white text-lg font-semibold">
                CDO Dashboard
            </div>

            <!-- Right side: User info and Logout -->
            <div class="flex items-center space-x-4">
                <span class="text-white">Welcome, <?php echo htmlspecialchars($username); ?>!</span>
                <a href="logout.php" class="bg-white text-blue-600 px-4 py-2 rounded-lg hover:bg-gray-100 transition duration-300">Logout</a>
            </div>
        </div>
    </nav>

    <div class="text-center mt-8">
        <h1 class="text-3xl font-bold">Welcome to the CDO Dashboard</h1>
        <p class="mt-4">You have User access.</p>
        <a href="ViewAssCompl.php" class="mt-4 inline-block bg-blue-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-600 transition duration-300">
                View Assinged Complain
        </a>
        <a href="AddEvidence.php" class="mt-4 inline-block bg-blue-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-600 transition duration-300">
                Add Evidence Complain
        </a>
        <a href="ViewEvidence.php" class="mt-4 inline-block bg-blue-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-600 transition duration-300">
                View Evidence Complain
        </a>
        <a href="UpdateInvestigation.php" class="mt-4 inline-block bg-blue-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-600 transition duration-300">
            Update Investigation
        </a>
        <a href="addComplain.php" class="mt-4 inline-block bg-blue-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-600 transition duration-300">
            Add Complaint
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
