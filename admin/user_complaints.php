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
</head>
<body class="bg-gray-100 min-h-screen">

<!-- Navigation Bar -->
<nav class="bg-green-600 p-4">
    <div class="container mx-auto flex justify-between items-center">
        <!-- Back to Dashboard Link on the left -->
        <a href="index.php" class="text-white hover:underline">Back to Dashboard</a>

        <!-- Middle Section: Title -->
        <div class="text-white text-lg font-semibold">
            Admin - User Complaints
        </div>

        <!-- Right Section: Logout Button -->
        <div class="flex space-x-4">
            <a href="logout.php" class="bg-white text-green-600 px-4 py-2 rounded-lg hover:bg-gray-100 transition duration-300">Logout</a>
        </div>
    </div>
</nav>

<table class="table-auto w-full bg-gray-800 text-white rounded-lg shadow-md">
    <thead>
        <tr class="bg-blue-900 text-white">
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
            <th class="px-4 py-2">Attachment</th> <!-- New column for attachments -->
            <th class="px-4 py-2">Assign to Officer</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr class="hover:bg-blue-700 hover:text-white text-center transition duration-300">
                    <td class="border px-4 py-2 border-gray-700"><?php echo $row['complaint_id']; ?></td>
                    <td class="border px-4 py-2 border-gray-700"><?php echo $row['user_id']; ?></td>
                    <td class="border px-4 py-2 border-gray-700"><?php echo $row['district']; ?></td>
                    <td class="border px-4 py-2 border-gray-700"><?php echo $row['nearest_police_station']; ?></td>
                    <td class="border px-4 py-2 border-gray-700"><?php echo $row['complaint_category']; ?></td>
                    <td class="border px-4 py-2 border-gray-700"><?php echo $row['name']; ?></td>
                    <td class="border px-4 py-2 border-gray-700"><?php echo $row['nic_number']; ?></td>
                    <td class="border px-4 py-2 border-gray-700"><?php echo $row['email_address']; ?></td>
                    <td class="border px-4 py-2 border-gray-700"><?php echo $row['complaint']; ?></td>
                    <td class="border px-4 py-2 border-gray-700"><?php echo $row['location']; ?></td>
                    <td class="border px-4 py-2 border-gray-700"><?php echo $row['date_added']; ?></td>
                    <!-- Display attachment download link if exists -->
                    <td class="border px-4 py-2 border-gray-700">
                        <?php if (!empty($row['attachment'])): ?>
                            <a href="../files/<?php echo $row['attachment']; ?>" class="text-blue-500 hover:underline" download>Download Attachment</a>
                        <?php else: ?>
                            No Attachment
                        <?php endif; ?>
                    </td>
                    <!-- <td class="border px-4 py-2 border-gray-700">
                        <a href="assign_officer.php?complaint_id=<?php echo $row['complaint_id']; ?>" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition duration-300">Assign</a>
                    </td> -->
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="13" class="text-center py-4">No complaints found</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>


<!-- Include jQuery and DataTables JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script>
    // Initialize DataTables without the search bar and with the rows dropdown box
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
