<?php
// Include database configuration file
include '../dbconnect.php';

// Check if form is submitted to add a new user
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $surname = $_POST['surname'];
    $username = $_POST['username'];
    $password = sha1($_POST['password']); // Using SHA-1 encryption for password
    $user_type = $_POST['user_type'];

    // Prepare and execute SQL to insert user data
    $sql = "INSERT INTO users (first_name, surname, username, password, user_type) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $first_name, $surname, $username, $password, $user_type);

    if ($stmt->execute()) {
        echo "<script> alert('User added successfully!')</script>";
    } else {
        echo "<p class='text-red-500 text-center mt-4'>Error: " . $conn->error . "</p>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add & View Users</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

<!-- Navigation Bar -->
<nav class="bg-green-600 p-4">
    <div class="container mx-auto flex justify-between items-center">
        <!-- Back to Dashboard Link on the left -->
        <a href="index.php" class="text-white hover:underline">Back to Dashboard</a>

        <!-- Middle Section: Title -->
        <div class="text-white text-lg font-semibold">
            Admin - Add New Users
        </div>

        <!-- Right Section: Logout Button -->
        <div class="flex space-x-4">
            <a href="logout.php" class="bg-white text-green-600 px-4 py-2 rounded-lg hover:bg-gray-100 transition duration-300">Logout</a>
        </div>
    </div>
</nav>

<!-- Form Container -->
<div class="max-w-2xl mx-auto mt-10 bg-white p-8 rounded-lg shadow-md">
    <h2 class="text-2xl font-semibold text-gray-700 mb-6 text-center">Add New User</h2>
    <form method="POST" action="" class="space-y-4">
        <!-- First Name Field -->
        <div>
            <label for="first_name" class="block text-gray-700 font-medium">First Name:</label>
            <input type="text" name="first_name" required class="mt-1 block w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-md focus:ring focus:ring-green-200" placeholder="Enter First Name">
        </div>

        <!-- Surname Field -->
        <div>
            <label for="surname" class="block text-gray-700 font-medium">Surname:</label>
            <input type="text" name="surname" required class="mt-1 block w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-md focus:ring focus:ring-green-200" placeholder="Enter Surname">
        </div>

        <!-- Username Field -->
        <div>
            <label for="username" class="block text-gray-700 font-medium">Username:</label>
            <input type="text" name="username" required class="mt-1 block w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-md focus:ring focus:ring-green-200" placeholder="Enter Username">
        </div>

        <!-- Password Field -->
        <div>
            <label for="password" class="block text-gray-700 font-medium">Password:</label>
            <input type="password" name="password" required class="mt-1 block w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-md focus:ring focus:ring-green-200" placeholder="Enter Password">
        </div>

        <!-- User Type Field -->
        <div>
            <label for="user_type" class="block text-gray-700 font-medium">User Type:</label>
            <select name="user_type" required class="mt-1 block w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-md focus:ring focus:ring-green-200">
                <option value="">Select User Type</option>
                <option value="admin">Admin</option>
                <option value="user">User</option>
                <option value="CDO">CDO</option>
                <option value="OIC">OIC</option>
            </select>
        </div>

        <!-- Submit Button -->
        <div>
            <input type="submit" value="Add User" class="w-full px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-green-200">
        </div>
    </form>
</div>

<!-- User Table -->
<div class="max-w-4xl mx-auto mt-10 bg-white p-8 rounded-lg shadow-md">
    <h2 class="text-2xl font-semibold text-gray-700 mb-6 text-center">View Existing Users</h2>
    <table class="min-w-full bg-white border border-gray-300 rounded-lg">
        <thead>
            <tr class="bg-green-600 text-white">
                <th class="border px-4 py-2">ID</th>
                <th class="border px-4 py-2">First Name</th>
                <th class="border px-4 py-2">Surname</th>
                <th class="border px-4 py-2">Username</th>
                <th class="border px-4 py-2">User Type</th>
            </tr>
        </thead>
        <tbody class="text-gray-700">
            <?php
            // Fetch users from the database
            $sql = "SELECT id, first_name, surname, username, user_type FROM users";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr class='hover:bg-green-100 transition duration-200'>
                            <td class='border px-4 py-2'>" . $row['id'] . "</td>
                            <td class='border px-4 py-2'>" . $row['first_name'] . "</td>
                            <td class='border px-4 py-2'>" . $row['surname'] . "</td>
                            <td class='border px-4 py-2'>" . $row['username'] . "</td>
                            <td class='border px-4 py-2'>" . $row['user_type'] . "</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='5' class='border px-4 py-2 text-center'>No users found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>
