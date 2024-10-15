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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Evidence</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    
<!-- Navigation Bar -->
<nav class="bg-blue-600 p-4">
    <div class="container mx-auto flex justify-between items-center">
        <!-- Left side: Logo or Name -->
        <div class="text-white text-lg font-semibold">
            Admin - View Evidence
        </div>

        <!-- Right side: Logout -->
        <div class="flex items-center space-x-4">
            <a href="logout.php" class="bg-white text-blue-600 px-4 py-2 rounded-lg hover:bg-gray-100 transition duration-300">Logout</a>
        </div>
    </div>
</nav>

<!-- Button to go back to the Admin Dashboard -->
<a href="index.php" class="mt-4 inline-block bg-green-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-green-700 transition duration-300 mb-4">
    Back to Dashboard
</a>

<!-- Table to show evidence -->
<table class="table-auto w-full bg-gray-800 text-white rounded-lg shadow-md">
    <thead>
        <tr class="bg-blue-900 text-white">
            <th class="px-4 py-2">Evidence ID</th>
            <th class="px-4 py-2">Investigation ID</th>
            <th class="px-4 py-2">Evidence Description</th>
            <th class="px-4 py-2">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr class="hover:bg-blue-700 hover:text-white text-center transition duration-300">
                    <td class="border px-4 py-2 border-gray-700"><?php echo $row['evidence_id']; ?></td>
                    <td class="border px-4 py-2 border-gray-700"><?php echo $row['investigation_id']; ?></td>
                    <td class="border px-4 py-2 border-gray-700"><?php echo $row['evidence_description']; ?></td>
                    <td class="border px-4 py-2 border-gray-700">
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

</body>
</html>
