<?php
session_start();
// Ensure the user is logged in and has the correct role
if (!isset($_SESSION['id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php"); // Redirect if not an Admin
    exit;
}

include '../dbconnect.php'; // Ensure this path is correct

// Fetch all complaints from the database
$sql = "SELECT * FROM complaint";
$result = $conn->query($sql);

// Check if the form has been submitted to update the court value
if (isset($_POST['update_court'])) {
    $complaint_id = $_POST['complaint_id'];
    $court = $_POST['court'];

    // Update the court value in the database
    $update_sql = "UPDATE complaint SET court = ? WHERE complaint_id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param('si', $court, $complaint_id);

    if ($stmt->execute()) {
        echo "<p class='text-green-500'>Court details updated successfully!</p>";
    } else {
        echo "<p class='text-red-500'>Error updating court: " . $conn->error . "</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Complaints</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Include DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
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
<script>
        function printTable() {
            window.print();  // This will trigger the browser's print dialog
        }
    </script>
<body class="bg-gray-100 min-h-screen">

<!-- Navigation Bar -->
<nav class="navbar p-4 shadow-md">
    <div class="container mx-auto flex justify-between items-center">
        <!-- Back to Dashboard Link on the left -->
        <a href="index.php" class="text-white font-semibold hover:underline">Back to Dashboard</a>

        <!-- Middle Section: Title -->
        <div class="text-white text-lg font-semibold">
            Admin - User Complaints
        </div>

        
        <!-- Print Report Button -->
        <button onclick="printTable()" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-300 no-print">
            Print Report
        </button>

        <!-- Right Section: Logout Button -->
        <div class="flex space-x-4">
            <a href="logout.php" class="btn-logout px-4 py-2 rounded-lg transition duration-300 shadow-md">Logout</a>
        </div>
    </div>
</nav>

<!-- Complaints Table -->
<div class="container mx-auto mt-6 bg-white p-6 rounded-lg shadow-lg">
    <h2 class="text-2xl font-bold text-gray-700 mb-6">User Complaints</h2>
    <table id="complaintTable" class="min-w-full bg-gray-100 text-gray-700 rounded-lg shadow-md">
        <thead>
            <tr class="bg-green-600 text-white">
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
                <th class="px-4 py-2">Court</th>
                <th class="px-4 py-2">Date Added</th>
                <th class="px-4 py-2">Attachment</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr class="hover:bg-green-50 text-center transition duration-300">
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
                        <td class="border px-4 py-2">
                            <!-- Editable Court Field -->
                            <form method="POST" action="">
                                <input type="hidden" name="complaint_id" value="<?php echo $row['complaint_id']; ?>">
                                <input type="text" name="court" value="<?php echo $row['court']; ?>" class="border px-2 py-1 w-full">
                                <button type="submit" name="update_court" class="action-btn mt-2">Update Court details</button>
                            </form>
                        </td>
                        <td class="border px-4 py-2"><?php echo $row['date_added']; ?></td>
                        <td class="border px-4 py-2">
                            <?php if (!empty($row['attachment'])): ?>
                                <a href="../files/<?php echo $row['attachment']; ?>" class="text-blue-500 hover:underline" download>Download Attachment</a>
                            <?php else: ?>
                                No Attachment
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="13" class="text-center py-4">No complaints found</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Include jQuery and DataTables JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script>
    // Initialize DataTables with custom settings
    $(document).ready(function() {
        $('#complaintTable').DataTable({
            "paging": true,
            "ordering": true,
            "info": true,
            "searching": false, // Disable search bar
            "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ], // Show rows dropdown
        });
    });
</script>

</body>
</html>
