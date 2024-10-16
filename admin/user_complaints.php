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
        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1rem;
        }

        table thead {
            background-color: #4CAF50; /* Match the navbar green */
        }

        table th, table td {
            padding: 4px 6px; /* Reduced padding */
            text-align: left;
            border-bottom: 1px solid #ddd;
            vertical-align: middle;
            font-size: 12px; /* Reduced font size */
            word-wrap: break-word; /* Allow text wrapping */
            white-space: normal; /* Allow text to wrap */
        }

        table th {
            font-weight: bold;
            color: white;
            text-transform: uppercase;
        }

        table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tbody tr:hover {
            background-color: #f1f1f1;
        }

        .action-btn {
            background-color: #4CAF50; /* Match the navbar green */
            color: white;
            padding: 4px 6px; /* Reduced padding */
            border-radius: 4px;
            transition: background-color 0.3s;
            text-decoration: none;
            font-size: 12px; /* Reduced font size */
        }

        .action-btn:hover {
            background-color: #45a049;
        }

        /* Set max-width for columns with long text */
        table td:nth-child(9), /* Complaint */
        table td:nth-child(10), /* Location */
        table td:nth-child(11) { /* Court Details */
            max-width: 150px; /* Adjust as needed */
        }

        /* Remove overflow to prevent horizontal scrolling */
        .table-container {
            overflow: hidden;
        }

        /* Media query for smaller screens */
        @media screen and (max-width: 1024px) {
            body {
                font-size: 12px;
            }
            table th, table td {
                font-size: 10px;
                padding: 2px 4px;
            }
            .action-btn {
                font-size: 10px;
                padding: 2px 4px;
            }
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
            Admin - User Complaints
        </div>

        <!-- Right Section: Logout Button -->
        <div class="flex space-x-4">
            <a href="logout.php" class="btn-logout px-4 py-2 rounded-lg transition duration-300 shadow-md">Logout</a>
        </div>
    </div>
</nav>

<!-- Complaints Table -->
<div class="container mx-auto mt-6 bg-white p-6 rounded-lg shadow-lg table-container">
    <h2 class="text-2xl font-bold text-gray-700 mb-6">User Complaints</h2>

    <!-- Table -->
    <table class="min-w-full text-gray-700 rounded-lg shadow-md">
        <thead>
            <tr>
                <th>Complaint ID</th>
                <th>User ID</th>
                <th>District</th>
                <th>Police Station</th>
                <th>Category</th>
                <th>Name</th>
                <th>NIC</th>
                <th>Email</th>
                <th>Complaint</th>
                <th>Location</th>
                <th>Court Details</th>
                <th>Date Added</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['complaint_id']; ?></td>
                        <td><?php echo $row['user_id']; ?></td>
                        <td><?php echo $row['district']; ?></td>
                        <td><?php echo $row['nearest_police_station']; ?></td>
                        <td><?php echo $row['complaint_category']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['nic_number']; ?></td>
                        <td><?php echo $row['email_address']; ?></td>
                        <td><?php echo $row['complaint']; ?></td>
                        <td><?php echo $row['location']; ?></td>
                        <td><?php echo $row['court']; ?></td>
                        <td><?php echo $row['date_added']; ?></td>
                        <td>
                            <!-- Add a View Button -->
                            <a href="singalComplDetail.php?id=<?php echo $row['complaint_id']; ?>" class="action-btn">View</a>
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

</body>
</html>
