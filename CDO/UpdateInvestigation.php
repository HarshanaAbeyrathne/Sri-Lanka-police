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
        echo "<script>alert('Investigation status updated successfully!'); </script>";
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
<nav class="navbar p-4 shadow-md">
    <div class="container mx-auto flex justify-between items-center">
        <!-- Back to Dashboard Link on the left -->
        <a href="index.php" class="text-white font-semibold hover:underline">Back to Dashboard</a>

        <!-- Middle Section: Title -->
        <div class="text-white text-lg font-semibold">
            CDO - Update Investigation Status
        </div>

        <!-- Right Section: Logout Button -->
        <div class="flex space-x-4">
            <a href="logout.php" class="btn-logout px-4 py-2 rounded-lg transition duration-300 shadow-md">Logout</a>
        </div>
    </div>
</nav>

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
