<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Custom background image */
        .bg-hero {
            background-image: url('img/main.jpg'); /* Replace with your image URL */
            background-size: cover;
            background-position: center;
            position: relative;
        }

        /* Overlay to dim the background */
        .bg-overlay {
            background: rgba(0, 0, 0, 0.7); /* Increase opacity to 0.7 for more dim effect */
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
        }
    </style>
</head>

<body class="bg-hero min-h-screen flex items-center justify-center relative">

if (isset($_SESSION['id'])) {
    // Check the role and redirect accordingly
    if ($_SESSION['role'] == 'admin') {
        header("Location: admin/");
        exit;
    } elseif ($_SESSION['role'] == 'OIC') {
        header("Location: oic/"); // Redirect OIC role
        exit;
    } elseif ($_SESSION['role'] == 'user') {
        header("Location: user/"); // Redirect user role
        exit;
    }
}
?>


    <!-- Login form -->
    <div class="relative z-10 max-w-md w-full bg-white p-6 rounded-lg shadow-md bg-opacity-90">
        <h3 class="text-2xl font-semibold text-center mb-6">Please Login Here</h3>

        <form action="logincheck.php" method="post">
            <div class="mb-4">
                <label for="un" class="block text-gray-700 font-bold mb-2">Username:</label>
                <input type="text" id="un" name="username" placeholder="Enter Username" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" required>
            </div>
            <div class="mb-4">
                <label for="pwd" class="block text-gray-700 font-bold mb-2">Password:</label>
                <input type="password" id="pwd" name="pwd" placeholder="Enter Password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" required>
            </div>
            <div class="flex items-center justify-between">
                <button type="submit" name="login" class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                    Login
                </button>
            </div>
        </form>

        <!-- Display error message if there's an error -->
        <div class="mt-4">
            <?php
            if (isset($_SESSION['error'])) {
                echo "<span class='text-red-500 text-center block mt-2'>" . $_SESSION['error'] . "</span>";
                unset($_SESSION['error']);
            }
            ?>
        </div>
    </div>

</body>
</html>
