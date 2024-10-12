<?php 
session_start();
// Ensure the user is logged in and has the correct role
if (!isset($_SESSION['staffid']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php"); // Redirect if not an Admin
    exit;
}

include '../dbconnect.php'; // Ensure this path is correct

// Fetch all complaints from the database
$sql = "SELECT * FROM complaint";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Complaints</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen">

<!-- Navigation Bar -->
    <nav class="bg-blue-600 p-4">
        <div class="container mx-auto flex justify-between items-center">
            <!-- Left side: Logo or Name -->
            <div class="text-white text-lg font-semibold">
                Admin - User Complaints
            </div>

            <!-- Right side: Logout -->
            <div class="flex items-center space-x-4">
                <a href="logout.php" class="bg-white text-blue-600 px-4 py-2 rounded-lg hover:bg-gray-100 transition duration-300">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold mb-4">All User Complaints</h1>

        <!-- Button to go back to the Admin Dashboard -->
        <a href="index.php" class="mt-4 inline-block bg-green-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-green-600 transition duration-300 mb-4">
            Back to Dashboard
        </a>

        <!-- Table to show complaints -->
        <table class="table-auto w-full bg-white rounded-lg shadow-md">
            <thead>
                <tr class="bg-blue-500 text-white">
                    <th class="px-4 py-2">Complaint ID</th>
                    <th class="px-4 py-2">User ID</th>
                    <th class="px-4 py-2">District</th>
                    <th class="px-4 py-2">Police Station</th>
                    <th class="px-4 py-2">Category</th>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">NIC</th>
                    <th class="px-4 py-2">Email</th>
                    <th class="px-4 py-2">Complaint</th>
                    <th class="px-4 py-2">Location</th>
                    <th class="px-4 py-2">Date Added</th>
                    <th class="px-4 py-2">Assign to Officer</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr class="bg-gray-100 text-center">
                            <td class="border px-4 py-2"><?php echo $row['complaint_id']; ?></td>
                            <td class="border px-4 py-2"><?php echo $row['user_id']; ?></td>
                            <td class="border px-4 py-2"><?php echo $row['district']; ?></td>
                            <td class="border px-4 py-2"><?php echo $row['nearest_police_station']; ?></td>
                            <td class="border px-4 py-2"><?php echo $row['complaint_category']; ?></td>
                            <td class="border px-4 py-2"><?php echo $row['name']; ?></td>
                            <td class="border px-4 py-2"><?php echo $row['nic_number']; ?></td>
                            <td class="border px-4 py-2"><?php echo $row['email_address']; ?></td>
                            <td class="border px-4 py-2"><?php echo $row['complaint']; ?></td>
                            <td class="border px-4 py-2"><?php echo $row['location']; ?></td>
                            <td class="border px-4 py-2"><?php echo $row['date_added']; ?></td>
                            <td class="border px-4 py-2">
                                <a href="assign_officer.php?complaint_id=<?php echo $row['complaint_id']; ?>" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition duration-300">Assign</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="12" class="text-center py-4">No complaints found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Another button at the bottom to go back to the Admin Dashboard -->
        <a href="index.php" class="mt-4 inline-block bg-green-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-green-600 transition duration-300">
            Back to Dashboard
        </a>

    </div>

</body>
</html>
