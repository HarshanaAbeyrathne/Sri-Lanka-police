<?php
// Include database configuration file
session_start();
include '../dbconnect.php'; 

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $investigation_id = $_POST['investigation_id'];
    $status = $_POST['status'];

    // Prepare and execute SQL to update investigation status
    $sql = "UPDATE investigation SET status = ? WHERE investigation_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $investigation_id);

    if ($stmt->execute()) {
        echo "<p class='text-green-500'>Investigation status updated successfully!</p>";
    } else {
        echo "<p class='text-red-500'>Error: " . $conn->error . "</p>";
    }
    $stmt->close();
}

// Fetch all investigations from the database for the dropdown
$sql = "SELECT investigation_id, status FROM investigation";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Investigation Status</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    
<!-- Navigation Bar -->
<nav class="bg-blue-600 p-4">
    <div class="container mx-auto flex justify-between items-center">
        <div class="text-white text-lg font-semibold">
            Update Investigation Status
        </div>

        <!-- Logout -->
        <div class="flex items-center space-x-4">
            <a href="logout.php" class="bg-white text-blue-600 px-4 py-2 rounded-lg hover:bg-gray-100 transition duration-300">Logout</a>
        </div>
    </div>
</nav>

<!-- Button to go back to the Admin Dashboard -->
<a href="index.php" class="mt-4 inline-block bg-green-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-green-700 transition duration-300 mb-4">
    Back to Dashboard
</a>

<!-- Form to Update Investigation Status -->
<div class="max-w-2xl mx-auto mt-10 bg-white p-8 rounded-lg shadow-md">
    <h2 class="text-2xl font-semibold text-gray-700 mb-6">Update Investigation Status</h2>
    <form method="POST" action="" class="space-y-4">
        <!-- Investigation Selection -->
        <div>
            <label for="investigation_id" class="block text-gray-700 font-medium">Select Investigation:</label>
            <select name="investigation_id" required class="mt-1 block w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-md">
                <option value="">Select Investigation</option>
                <?php
                // Loop through the fetched investigations and display them in the dropdown
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['investigation_id'] . "'>Investigation ID: " . $row['investigation_id'] . " (Current Status: " . $row['status'] . ")</option>";
                    }
                } else {
                    echo "<option value=''>No Investigations Available</option>";
                }
                ?>
            </select>
        </div>

        <!-- Status Update Field -->
        <div>
            <label for="status" class="block text-gray-700 font-medium">Update Status:</label>
            <select name="status" required class="mt-1 block w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-md">
                <option value="">Select New Status</option>
                <option value="Open">Open</option>
                <option value="In Progress">In Progress</option>
                <option value="Closed">Closed</option>
            </select>
        </div>

        <!-- Submit Button -->
        <div>
            <input type="submit" value="Update Status" class="w-full px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-200">
        </div>
    </form>
</div>

</body>
</html>
