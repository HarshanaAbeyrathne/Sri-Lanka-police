<?php
session_start();
// Ensure the user is logged in and is an OIC
if (!isset($_SESSION['id']) || $_SESSION['role'] != 'OIC') {
    header("Location: ../login.php"); // Redirect if not an OIC
    exit;
}

include '../dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $message = $_POST['message'];
    $added_by = $_SESSION['username']; // OIC username

    // Insert the news alert into the database
    $sql = "INSERT INTO news_alerts (title, message, added_by) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $title, $message, $added_by);

    if ($stmt->execute()) {
        $success_message = "News alert added successfully!";
    } else {
        $error_message = "Error: " . $conn->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add News Alert</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col justify-center items-center">

    <div class="max-w-lg w-full bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold text-gray-700 mb-6 text-center">Add News Alert</h2>

        <!-- Success/Error message -->
        <?php if (isset($success_message)): ?>
            <p class="text-green-500 text-center mb-4"><?php echo "<script>alert('$success_message'); </script>"; ?></p>
        <?php elseif (isset($error_message)): ?>
            <p class="text-red-500 text-center mb-4"><?php echo $error_message; ?></p>
        <?php endif; ?>

        <form method="POST" action="">
            <div>
                <label for="title" class="block text-gray-700 font-medium mb-2">Title:</label>
                <input type="text" name="title" required class="mt-1 block w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="mt-4">
                <label for="message" class="block text-gray-700 font-medium mb-2">Message:</label>
                <textarea name="message" required class="mt-1 block w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
            </div>
            <div class="mt-6">
                <input type="submit" value="Add News" class="w-full px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </form>

        <!-- Back to Home (index.php) button -->
        <div class="mt-6">
            <a href="index.php" class="w-full block text-center px-4 py-2 text-blue-500 hover:underline">
                Back to Home
            </a>
        </div>
    </div>

</body>
</html>
