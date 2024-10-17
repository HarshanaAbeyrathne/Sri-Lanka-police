<?php
// Include database configuration file
include '../dbconnect.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $complaint_id = $_POST['complaint_id'];
    $assigned_to = $_POST['assigned_to'];
    
    // Prepare and execute SQL to insert investigation data
    $sql = "INSERT INTO investigation (complaint_id, assigned_to, status) VALUES (?, ?, 'Open')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $complaint_id, $assigned_to);

    if ($stmt->execute()) {
        echo "<script>alert('Investigation assigned successfully!'); </script>";
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
    <title>Assign Investigation</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<!-- Navigation Bar -->
<nav class="bg-green-600 p-4">
    <div class="container mx-auto flex justify-between items-center">
        <!-- Back to Dashboard Link on the left -->
        <a href="index.php" class="text-white hover:underline">Back to Dashboard</a>

        <!-- Middle Section: Title -->
        <div class="text-white text-lg font-semibold">
            OIC - Assign Investigation
        </div>

        <!-- Right Section: Logout Button -->
        <div class="flex space-x-4">
            <a href="logout.php" class="bg-white text-green-600 px-4 py-2 rounded-lg hover:bg-gray-100 transition duration-300">Logout</a>
        </div>
    </div>
</nav>


    <div class="max-w-2xl mx-auto mt-10 bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold text-gray-700 mb-6">Assign Investigation to CDO</h2>
        <form method="POST" action="" class="space-y-4">
            <!-- Complaint Selection -->
            <div>
                <label for="complaint_id" class="block text-gray-700 font-medium">Select Complaint:</label>
                <select name="complaint_id" required class="mt-1 block w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-md focus:ring focus:ring-blue-200">
                    <option value="">Select Complaint</option>
                    <?php
                    // Fetch complaints from the database
                    $complaint_query = "SELECT complaint_id, complaint_subject FROM complaint";
                    $result = $conn->query($complaint_query);
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['complaint_id'] . "'>" . $row['complaint_subject'] . "</option>";
                    }
                    ?>
                </select>
            </div>

            <!-- CDO Selection -->
            <div>
                <label for="assigned_to" class="block text-gray-700 font-medium">Assign to CDO:</label>
                <select name="assigned_to" required class="mt-1 block w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-md focus:ring focus:ring-blue-200">
                    <option value="">Select CDO</option>
                    <?php
                    // Fetch CDO users from the database
                    $user_query = "SELECT id, username FROM users WHERE user_type = 'CDO'";
                    $result = $conn->query($user_query);
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['id'] . "'>" . $row['username'] . "</option>";
                    }
                    ?>
                </select>
            </div>

            <!-- Submit Button -->
            <div>
                <input type="submit" value="Assign Investigation" class="w-full px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-200">
            </div>
        </form>
    </div>
</body>
</html>
