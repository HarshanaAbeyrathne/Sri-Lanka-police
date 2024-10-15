<?php
// Include database configuration file
session_start(); 
include '../dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Fetch the user ID from session
    $user_id = $_SESSION['id'];  // Assuming user ID is stored in session
    $district = $_POST['district'];
    $nearest_police_station = $_POST['nearest_police_station'];
    $complaint_category = $_POST['complaint_category'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $nic_number = $_POST['nic_number'];
    $email_address = $_POST['email_address'];
    $complaint = $_POST['complaint'];
    $complaint_subject = $_POST['complaint_subject'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $location = $latitude . ', ' . $longitude;  // Concatenate latitude and longitude into a string
    $attachment = NULL;  // Default value for attachment

    // Handle file upload (for attachments like videos or documents)
    if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] == 0) {
        // Set the target directory for saving the file
        $target_dir = "../files/";
        $attachment = basename($_FILES['attachment']['name']);
        $target_file = $target_dir . $attachment;

        // Move the uploaded file to the server directory
        if (move_uploaded_file($_FILES['attachment']['tmp_name'], $target_file)) {
            echo "File uploaded successfully.";
        } else {
            echo "Error uploading file.";
            $attachment = NULL;  // Reset if upload fails
        }
    }

    // Prepare and execute SQL to insert complaint data
    $sql = "INSERT INTO complaint (user_id, district, nearest_police_station, complaint_category, name, address, nic_number, email_address, complaint, complaint_subject, attachment, date_added, location) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?)";
    $stmt = $conn->prepare($sql);

    // Bind parameters according to the table structure
    $stmt->bind_param("isssssssssss", $user_id, $district, $nearest_police_station, $complaint_category, $name, $address, $nic_number, $email_address, $complaint, $complaint_subject, $attachment, $location);

    if ($stmt->execute()) {
        echo "<p class='text-green-500'>Complaint added successfully!</p>";
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
    <title>Add Complaint</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC-6LadFJTsgUs2ur7F4OAEhw9XHSXp_OM&callback=initMap" async defer></script>
    <script>
    function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: 7.8731, lng: 80.7718}, // Set to the center of Sri Lanka
            zoom: 8
        });

        var marker = new google.maps.Marker({
            position: {lat: 7.8731, lng: 80.7718},
            map: map,
            draggable: true
        });

        // Update the lat/long values when the marker is dragged
        google.maps.event.addListener(marker, 'dragend', function(evt) {
            document.getElementById('latitude').value = evt.latLng.lat().toFixed(6);
            document.getElementById('longitude').value = evt.latLng.lng().toFixed(6);
        });
    }
    </script>
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
<body class="bg-gray-100">

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


    <div class="max-w-2xl mx-auto mt-10 bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold text-gray-700 mb-6">Add New Complaint</h2>
        <form method="POST" action="" enctype="multipart/form-data" class="space-y-4">
            <!-- Complaint Form Fields -->
            <div>
                <label for="district" class="block text-gray-700 font-medium">District:</label>
                <input type="text" name="district" required class="mt-1 block w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-md">
            </div>
            <div>
                <label for="nearest_police_station" class="block text-gray-700 font-medium">Nearest Police Station:</label>
                <input type="text" name="nearest_police_station" required class="mt-1 block w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-md">
            </div>
            <div>
                <label for="complaint_category" class="block text-gray-700 font-medium">Complaint Category:</label>
                <input type="text" name="complaint_category" required class="mt-1 block w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-md">
            </div>
            <div>
                <label for="name" class="block text-gray-700 font-medium">Name:</label>
                <input type="text" name="name" required class="mt-1 block w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-md">
            </div>
            <div>
                <label for="address" class="block text-gray-700 font-medium">Address:</label>
                <textarea name="address" required class="mt-1 block w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-md"></textarea>
            </div>
            <div>
                <label for="nic_number" class="block text-gray-700 font-medium">NIC Number:</label>
                <input type="text" name="nic_number" required class="mt-1 block w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-md">
            </div>
            <div>
                <label for="email_address" class="block text-gray-700 font-medium">Email Address:</label>
                <input type="email" name="email_address" class="mt-1 block w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-md">
            </div>
            <div>
                <label for="complaint" class="block text-gray-700 font-medium">Complaint Details:</label>
                <textarea name="complaint" required class="mt-1 block w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-md"></textarea>
            </div>
            <div>
                <label for="complaint_subject" class="block text-gray-700 font-medium">Complaint Subject:</label>
                <input type="text" name="complaint_subject" required class="mt-1 block w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-md">
            </div>
            <div>
                <label for="attachment" class="block text-gray-700 font-medium">Attachment:</label>
                <input type="file" name="attachment" class="mt-1 block w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-md">
            </div>

            <!-- Google Maps for Location Selection -->
            <div>
                <label for="location" class="block text-gray-700 font-medium">Select Location on Map:</label>
                <div id="map" class="w-full h-64 mt-4 mb-4 border border-gray-300"></div>
                <input type="hidden" id="latitude" name="latitude">
                <input type="hidden" id="longitude" name="longitude">
            </div>

            <!-- Submit Button -->
            <div>
                <input type="submit" value="Submit Complaint" class="w-full px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-200">
            </div>
        </form>
    </div>
</body>
</html>
