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
        echo "<p class='text-green-500'>News alert added successfully!</p>";
    } else {
        echo "<p class='text-red-500'>Error: " . $conn->error . "</p>";
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
    <link href="https://cdn.tailwindcss.com" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="max-w-lg mx-auto mt-10 bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold text-gray-700 mb-6">Add News Alert</h2>
        <form method="POST" action="">
            <div>
                <label for="title" class="block text-gray-700 font-medium">Title:</label>
                <input type="text" name="title" required class="mt-1 block w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-md">
            </div>
            <div class="mt-4">
                <label for="message" class="block text-gray-700 font-medium">Message:</label>
                <textarea name="message" required class="mt-1 block w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-md"></textarea>
            </div>
            <div class="mt-6">
                <input type="submit" value="Add News" class="w-full px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600">
            </div>
        </form>
    </div>
</body>
</html>
