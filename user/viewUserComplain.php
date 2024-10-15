<?php
session_start();
// Ensure the user is logged in and has the correct role
if (!isset($_SESSION['staffid']) || $_SESSION['role'] != 'user') {
    header("Location: ../login.php"); // Redirect if not a regular user
    exit;
}

$user_id = $_SESSION['staffid']; // Assume 'staffid' is the logged-in user's ID
require_once '../dbconnect.php'; // Include your database connection

// Fetch the complaints, their investigation status, and assigned OIC/admin details for the logged-in user
$query = "
    SELECT c.complaint_id, c.complaint_subject, c.complaint, c.nearest_police_station, c.court, c.date_added, 
           i.status, u.username AS assigned_oic
    FROM complaint c 
    LEFT JOIN investigation i ON c.complaint_id = i.complaint_id 
    LEFT JOIN users u ON i.assigned_to = u.id
    WHERE c.user_id = ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id); // Bind the user_id parameter
$stmt->execute();
$result = $stmt->get_result();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Complaints</title>
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- DataTables CSS for table functionality -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <!-- Custom Styles -->
    <style>
        .navbar {
            background-color: #4CAF50; /* Green background */
        }
        .navbar .btn {
            background-color: #2196F3; /* Blue button */
            color: white;
        }
        table.dataTable thead th {
            background-color: #4CAF50; /* Green table header */
            color: white;
        }
        .action-btn {
            padding: 6px 12px;
            border-radius: 5px;
            color: white;
        }
    </style>
</head>
<body class="min-h-screen bg-gray-100">
    
<!-- Navigation Bar -->
<nav class="navbar p-4">
    <div class="container mx-auto flex justify-between items-center">
        <!-- Back to Home Link -->
        <a href="index.php" class="text-white hover:underline">Back to Home</a>
        
        <!-- Middle Section: Title -->
        <div class="text-white text-lg font-semibold">
            Crime Records Management System
        </div>

        <!-- Right Section: New Case and View Cases Buttons -->
        <div class="flex space-x-4">
            <a href="addComplain.php" class="btn px-4 py-2 rounded-lg hover:bg-blue-700">+ New Case</a>
            <a href="viewUserComplain.php" class="btn px-4 py-2 rounded-lg hover:bg-blue-700">View Cases</a>
        </div>
    </div>
</nav>


    <div class="container mx-auto mt-8">
        <h1 class="text-2xl font-semibold mb-6">Your Complaint History and Investigation Status</h1>

        <div class="overflow-x-auto bg-white shadow-md rounded-lg p-6">
            <table id="complaintTable" class="min-w-full display">
                <thead>
                    <tr>
                        <th class="py-2 px-4">Complaint ID</th>
                        <th class="py-2 px-4">Subject</th>
                        <th class="py-2 px-4">Complaint</th>
                        <th class="py-2 px-4">Police Station</th>
                        <th class="py-2 px-4">Court</th>
                        <th class="py-2 px-4">Date Added</th>
                        <th class="py-2 px-4">Investigation Status</th>
                        <th class="py-2 px-4">Assigned OIC/Admin</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td class="border px-4 py-2"><?php echo htmlspecialchars($row['complaint_id']); ?></td>
                            <td class="border px-4 py-2"><?php echo htmlspecialchars($row['complaint_subject']); ?></td>
                            <td class="border px-4 py-2"><?php echo htmlspecialchars($row['complaint']); ?></td>
                            <td class="border px-4 py-2"><?php echo htmlspecialchars($row['nearest_police_station']); ?></td>
                            <td class="border px-4 py-2"><?php echo htmlspecialchars($row['court']); ?></td>
                            <td class="border px-4 py-2"><?php echo htmlspecialchars($row['date_added']); ?></td>
                            <td class="border px-4 py-2"><?php echo htmlspecialchars($row['status'] ? $row['status'] : 'Not Investigated'); ?></td>
                            <td class="border px-4 py-2"><?php echo htmlspecialchars($row['assigned_oic'] ? $row['assigned_oic'] : 'Not Assigned'); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- jQuery and DataTables -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    
    <!-- Initialize DataTables -->
    <script>
        $(document).ready(function() {
            $('#complaintTable').DataTable({
                "paging": true,
                "searching": true,
                "ordering": true,
                "info": true
            });
        });
    </script>

</body>
</html>

<?php
// Close database connection
$stmt->close();
$conn->close();
?>
