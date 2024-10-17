<?php 
session_start();
// Ensure the user is logged in and has the correct role
if (!isset($_SESSION['id']) || $_SESSION['role'] != 'user') {
    header("Location: ../login.php"); // Redirect if not a regular user
    exit;
}

include '../dbconnect.php';

// Fetch the latest news alert
$news_query = "SELECT * FROM news_alerts ORDER BY date_added DESC LIMIT 1";
$news_result = $conn->query($news_query);
$latest_news = $news_result->fetch_assoc();

$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Unknown User';
$user_id = $_SESSION['id'];  // Assuming user's id is stored in the session

// Fetch all investigations related to the logged-in user's complaints
$investigation_query = "
    SELECT i.investigation_id, i.status, c.complaint_subject 
    FROM investigation i 
    JOIN complaint c ON i.complaint_id = c.complaint_id 
    WHERE c.user_id = ?
";
$stmt = $conn->prepare($investigation_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$investigation_result = $stmt->get_result();

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

    <!-- Display the latest news alert directly on the page -->
    <div class="max-w-md mx-auto mt-8 bg-white p-6 rounded-lg shadow-md">
        <?php if (isset($latest_news['title']) && isset($latest_news['message'])): ?>
            <div class="bg-red-600 text-white w-full p-6 rounded-lg shadow-lg">
                <h2 class="text-xl font-bold mb-2">News Alert</h2>
                <p class="text-md font-semibold mb-2"><?php echo htmlspecialchars($latest_news['title']); ?> <span> </span><?php echo nl2br(htmlspecialchars($latest_news['message'])); ?></p>
       
            </div>
        <?php else: ?>
            <p class="text-gray-700">No latest news available.</p>
        <?php endif; ?>
    </div>

    <div class="text-center mt-8">
        <h1 class="text-3xl font-bold">Welcome to the User Dashboard</h1>
        <p class="mt-4">You have User access.</p>
        <a href="logout.php" class="mt-4 text-blue-500 hover:underline">Logout</a>
    </div>

    <!-- Section to View Investigation Status -->
    <div class="max-w-4xl mx-auto mt-10 bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold text-gray-700 mb-6">Your Investigations</h2>
        <table class="table-auto w-full bg-gray-800 text-white rounded-lg shadow-md">
            <thead>
                <tr class="bg-blue-900 text-white">
                    <th class="px-4 py-2">Investigation ID</th>
                    <th class="px-4 py-2">Complaint Subject</th>
                    <th class="px-4 py-2">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($investigation_result->num_rows > 0): ?>
                    <?php while($row = $investigation_result->fetch_assoc()): ?>
                        <tr class="hover:bg-blue-700 hover:text-white text-center transition duration-300">
                            <td class="border px-4 py-2 border-gray-700"><?php echo $row['investigation_id']; ?></td>
                            <td class="border px-4 py-2 border-gray-700"><?php echo htmlspecialchars($row['complaint_subject']); ?></td>
                            <td class="border px-4 py-2 border-gray-700"><?php echo htmlspecialchars($row['status']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" class="text-center py-4">No investigations found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <!-- Reset Password Button -->
    <div class="flex justify-center mt-10">
        <a href="reset_password.php" class="bg-white text-red-600 font-bold py-3 px-6 rounded-lg hover:bg-gray-100 transition duration-300 shadow-md">
            Reset Password
        </a>
    </div>                    
</body>
</html>
