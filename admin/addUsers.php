<?php
// Include database configuration file
include '../dbconnect.php';

// Check if form is submitted to add a new user
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = sha1($_POST['password']); // Using SHA-1 encryption for password
    $user_type = $_POST['user_type'];

    // Prepare and execute SQL to insert user data
    $sql = "INSERT INTO users (username, password, user_type) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $username, $password, $user_type);

    if ($stmt->execute()) {
        echo "<p class='text-green-500'>User added successfully!</p>";
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
    <title>Add & View Users</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="max-w-2xl mx-auto mt-10 bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold text-gray-700 mb-6">Add New User</h2>
        <form method="POST" action="" class="space-y-4">
            <!-- Username Field -->
            <div>
                <label for="username" class="block text-gray-700 font-medium">Username:</label>
                <input type="text" name="username" required class="mt-1 block w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-md focus:ring focus:ring-blue-200" placeholder="Enter Username">
            </div>

            <!-- Password Field -->
            <div>
                <label for="password" class="block text-gray-700 font-medium">Password:</label>
                <input type="password" name="password" required class="mt-1 block w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-md focus:ring focus:ring-blue-200" placeholder="Enter Password">
            </div>

            <!-- User Type Field -->
            <div>
                <label for="user_type" class="block text-gray-700 font-medium">User Type:</label>
                <select name="user_type" required class="mt-1 block w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-md focus:ring focus:ring-blue-200">
                    <option value="">Select User Type</option>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                    <option value="CDO">CDO</option>
                    <option value="OIC">OIC</option>
                </select>
            </div>

            <!-- Submit Button -->
            <div>
                <input type="submit" value="Add User" class="w-full px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-200">
            </div>
        </form>
    </div>

    <!-- User Table -->
    <div class="max-w-4xl mx-auto mt-10 bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold text-gray-700 mb-6">View Existing Users</h2>
        <table class="min-w-full bg-white border border-gray-300">
            <thead>
                <tr>
                    <th class="border px-4 py-2 text-gray-700">ID</th>
                    <th class="border px-4 py-2 text-gray-700">Username</th>
                    <th class="border px-4 py-2 text-gray-700">User Type</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch users from the database
                $sql = "SELECT id, username, user_type FROM users";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td class='border px-4 py-2'>" . $row['id'] . "</td>
                                <td class='border px-4 py-2'>" . $row['username'] . "</td>
                                <td class='border px-4 py-2'>" . $row['user_type'] . "</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='3' class='border px-4 py-2 text-center'>No users found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
