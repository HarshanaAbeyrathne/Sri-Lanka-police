
<?php
session_start();

// Ensure the user is logged in and has the correct role
if (!isset($_SESSION['id']) ) {
    header("Location: ../login.php");
    exit;
}

include '../dbconnect.php'; // Ensure this path is correct

// Get the complaint ID from the URL
if (isset($_GET['id'])) {
    $complaint_id = $_GET['id'];

    // Handle court update form submission
    if (isset($_POST['update_court'])) {
        $court = $_POST['court'];
        $update_sql = "UPDATE complaint SET court = ? WHERE complaint_id = ?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param('si', $court, $complaint_id);

        if ($stmt->execute()) {
            echo "<p class='text-green-500'>Court details updated successfully!</p>";
        } else {
            echo "<p class='text-red-500'>Error updating court: " . $conn->error . "</p>";
        }
    }

    // Handle complaint deletion
    if (isset($_POST['delete_complaint'])) {
        $delete_sql = "DELETE FROM complaint WHERE complaint_id = ?";
        $stmt = $conn->prepare($delete_sql);
        $stmt->bind_param('i', $complaint_id);

        if ($stmt->execute()) {
            echo "<p class='text-green-500'>Complaint deleted successfully!</p>";
            // Redirect after deletion
            header("Location: user_complaints.php");
            exit;
        } else {
            echo "<p class='text-red-500'>Error deleting complaint: " . $conn->error . "</p>";
        }
    }

    // Fetch the complaint details from the database
    $sql = "SELECT * FROM complaint WHERE complaint_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $complaint_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $complaint = $result->fetch_assoc();
} else {
    // If no complaint_id is provided, redirect back to the complaints page
    header("Location: user_complaints.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaint Details</title>
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
        /* Custom card for complaint details */
        .complaint-card {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        .complaint-card h2 {
            font-size: 1.75rem;
            font-weight: 700;
            color: #333;
        }
        .complaint-card p {
            font-size: 1rem;
            color: #555;
            margin-bottom: 12px;
        }
        /* Improved form input and button styles */
        .form-input {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #ddd;
            margin-bottom: 20px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }
        .form-input:focus {
            border-color: #4CAF50;
            outline: none;
        }
        .form-button {
            background-color: #4CAF50;
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 1rem;
            transition: background-color 0.3s;
            cursor: pointer;
        }
        .form-button:hover {
            background-color: #388E3C;
        }
        .delete-button {
            background-color: #e74c3c;
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 1rem;
            transition: background-color 0.3s;
            cursor: pointer;
        }
        .delete-button:hover {
            background-color: #c0392b;
        }
        /* Print button */
        .print-button {
            background-color: #ff9800;
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 1rem;
            transition: background-color 0.3s;
            cursor: pointer;
        }
        .print-button:hover {
            background-color: #f57c00;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">

<!-- Navigation Bar -->
<nav class="navbar p-4 shadow-md">
    <div class="container mx-auto flex justify-between items-center">
        <!-- Back to Dashboard Link on the left -->
        <a href="user_complaints.php" class="text-white font-semibold hover:underline">Back to User Complaints</a>

        <!-- Middle Section: Title -->
        <div class="text-white text-lg font-semibold">
            Admin - Complaint
        </div>

        <!-- Right Section: Logout Button -->
        <div class="flex space-x-4">
            <a href="logout.php" class="btn-logout px-4 py-2 rounded-lg transition duration-300 shadow-md">Logout</a>
        </div>
    </div>
</nav>

<!-- Complaint Details Section -->
<div class="container mx-auto mt-6 p-6">
    <div class="complaint-card">
        <h2 class="text-2xl font-bold mb-4">Complaint ID: <?php echo $complaint['complaint_id']; ?></h2>

        <!-- Display Complaint Details -->
        <p><strong>User ID:</strong> <?php echo $complaint['user_id']; ?></p>
        <p><strong>District:</strong> <?php echo $complaint['district']; ?></p>
        <p><strong>Police Station:</strong> <?php echo $complaint['nearest_police_station']; ?></p>
        <p><strong>Category:</strong> <?php echo $complaint['complaint_category']; ?></p>
        <p><strong>Name:</strong> <?php echo $complaint['name']; ?></p>
        <p><strong>Address:</strong> <?php echo $complaint['address']; ?></p>
        <p><strong>NIC:</strong> <?php echo $complaint['nic_number']; ?></p>
        <p><strong>Email:</strong> <?php echo $complaint['email_address']; ?></p>
        <p><strong>Complaint Subject:</strong> <?php echo $complaint['complaint_subject']; ?></p>
        <p><strong>Complaint:</strong> <?php echo $complaint['complaint']; ?></p>
        <p><strong>Location:</strong> <?php echo $complaint['location']; ?></p>
        <p><strong>Date Added:</strong> <?php echo $complaint['date_added']; ?></p>

        <!-- Display and Edit Court Details -->
        <form method="POST" action="">
            <div class="mb-4">
                <label for="court" class="block text-gray-700 font-bold mb-2">Court Details:</label>
                <input type="text" id="court" name="court" value="<?php echo $complaint['court']; ?>" class="form-input">
            </div>
            <button type="submit" name="update_court" class="form-button">Update Court Details</button>
        </form>

        <!-- Delete Complaint -->
        <form method="POST" action="" class="mt-6">
            <button type="submit" name="delete_complaint" class="delete-button" onclick="return confirm('Are you sure you want to delete this complaint?');">Delete Complaint</button>
        </form>

        <!-- Print Button -->
        <div class="mt-6">
            <button onclick="window.print()" class="print-button">Print Complaint</button>
        </div>
    </div>
</div>

</body>
</html>
