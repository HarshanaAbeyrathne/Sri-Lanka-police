<?php
session_start();
include 'dbconnect.php'; // Ensure this connects via MySQLi

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['pwd'];

    // Query to check user credentials using the correct table name 'users'
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }
    
    // Bind parameters
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Encrypt the entered password using SHA-1 to compare with the stored password
        $hashed_password = sha1($password);

        // Verify password using SHA-1
        if ($hashed_password === $user['password']) {

            // Store user data in session
            $_SESSION['id'] = $user['id'];
            $_SESSION['role'] = $user['user_type'];  // Assuming user_type corresponds to role
            $_SESSION['username'] = $user['username'];  // Store the username

            // Redirect based on role
            if ($user['user_type'] == 'admin') {
                header("Location: admin/index.php");
            } elseif ($user['user_type'] == 'OIC') {
                header("Location: oic/index.php");
            } elseif ($user['user_type'] == 'user') {
                header("Location: user/index.php");
            }elseif ($user['user_type'] == 'CDO') {
                header("Location: CDO/index.php");
            }
            exit;
        } else {
            $_SESSION['error'] = "Invalid password!";
            header("Location: login.php");
            exit;
        }
    } else {
        $_SESSION['error'] = "User not found!";
        header("Location: login.php");
        exit;
    }
}
?>
