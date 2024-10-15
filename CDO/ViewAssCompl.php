<?php
// Include database configuration file
include '../dbconnect.php';

// Fetch assigned complaints with CDO details
$sql = "SELECT 
            c.complaint_subject, 
            c.name AS complainant_name, 
            c.district, 
            c.nearest_police_station, 
            c.complaint_category, 
            c.address, 
            c.nic_number, 
            u.username AS cdo_name, 
            i.status 
        FROM 
            complaint c
        JOIN 
            investigation i ON c.complaint_id = i.complaint_id
        JOIN 
            users u ON i.assigned_to = u.id
        WHERE 
            u.user_type = 'CDO'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assigned Complaints</title>
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
<body class="bg-gray-100">

<!-- Navigation Bar -->
<nav class="navbar p-4 shadow-md">
    <div class="container mx-auto flex justify-between items-center">
        <!-- Back to Dashboard Link on the left -->
        <a href="index.php" class="text-white font-semibold hover:underline">Back to Dashboard</a>

        <!-- Middle Section: Title -->
        <div class="text-white text-lg font-semibold">
            CDO - View Assigned Complaints
        </div>

        <!-- Right Section: Logout Button -->
        <div class="flex space-x-4">
            <a href="logout.php" class="btn-logout px-4 py-2 rounded-lg transition duration-300 shadow-md">Logout</a>
        </div>
    </div>
</nav>
    <div class="max-w-6xl mx-auto mt-10 bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold text-gray-700 mb-6">Assigned Complaints</h2>
        <table class="min-w-full bg-white border border-gray-300">
            <thead>
                <tr>
                    <th class="border px-4 py-2 text-gray-700">Complaint Subject</th>
                    <th class="border px-4 py-2 text-gray-700">Complainant Name</th>
                    <th class="border px-4 py-2 text-gray-700">District</th>
                    <th class="border px-4 py-2 text-gray-700">Nearest Police Station</th>
                    <th class="border px-4 py-2 text-gray-700">Category</th>
                    <th class="border px-4 py-2 text-gray-700">Address</th>
                    <th class="border px-4 py-2 text-gray-700">NIC Number</th>
                    <th class="border px-4 py-2 text-gray-700">Assigned CDO</th>
                    <th class="border px-4 py-2 text-gray-700">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td class='border px-4 py-2'>" . $row['complaint_subject'] . "</td>
                                <td class='border px-4 py-2'>" . $row['complainant_name'] . "</td>
                                <td class='border px-4 py-2'>" . $row['district'] . "</td>
                                <td class='border px-4 py-2'>" . $row['nearest_police_station'] . "</td>
                                <td class='border px-4 py-2'>" . $row['complaint_category'] . "</td>
                                <td class='border px-4 py-2'>" . $row['address'] . "</td>
                                <td class='border px-4 py-2'>" . $row['nic_number'] . "</td>
                                <td class='border px-4 py-2'>" . $row['cdo_name'] . "</td>
                                <td class='border px-4 py-2'>" . $row['status'] . "</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='9' class='border px-4 py-2 text-center'>No assigned complaints found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
