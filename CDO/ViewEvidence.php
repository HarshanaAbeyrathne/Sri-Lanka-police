<?php
// Include database configuration file
session_start();
include '../dbconnect.php'; 

// Check if the delete request is sent
if (isset($_GET['delete_id'])) {
    $evidence_id = $_GET['delete_id'];

    // Prepare and execute SQL to delete the evidence
    $sql = "DELETE FROM evidence WHERE evidence_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $evidence_id);

    if ($stmt->execute()) {
        echo "<p class='text-green-500'>Evidence deleted successfully!</p>";
    } else {
        echo "<p class='text-red-500'>Error: " . $conn->error . "</p>";
    }
    $stmt->close();
}

// Fetch all evidence from the database
$sql = "SELECT * FROM evidence";
$result = $conn->query($sql);

// Check if query execution was successful
if (!$result) {
    echo "<p class='text-red-500'>Error: " . $conn->error . "</p>";
} 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Evidence</title>
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
        CDO - View Evidence
        </div>

        <!-- Right Section: Logout Button -->
        <div class="flex space-x-4">
            <a href="logout.php" class="btn-logout px-4 py-2 rounded-lg transition duration-300 shadow-md">Logout</a>
        </div>
    </div>
</nav>

<!-- Table to show evidence -->
<div class="container mx-auto mt-8">
    <table class="table-auto w-full bg-white text-gray-700 rounded-lg shadow-md">
        <thead>
            <tr class="bg-green-600 text-white">
                <th class="px-4 py-2">Evidence ID</th>
                <th class="px-4 py-2">Investigation ID</th>
                <th class="px-4 py-2">Evidence Description</th>
                <th class="px-4 py-2">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr class="hover:bg-green-100 hover:text-gray-900 text-center transition duration-300">
                        <td class="border px-4 py-2 border-gray-300"><?php echo $row['evidence_id']; ?></td>
                        <td class="border px-4 py-2 border-gray-300"><?php echo $row['investigation_id']; ?></td>
                        <td class="border px-4 py-2 border-gray-300"><?php echo $row['evidence_description']; ?></td>
                        <td class="border px-4 py-2 border-gray-300">
                            <a href="?delete_id=<?php echo $row['evidence_id']; ?>" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition duration-300">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center py-4">No evidence found</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>
