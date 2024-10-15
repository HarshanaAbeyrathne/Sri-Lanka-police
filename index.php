<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Police of Sri Lanka - Home</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Custom background image */
        .bg-hero {
            background-image: url('img/main.jpg'); /* Replace with your image URL */
            background-size: cover;
            background-position: center;
        }

        .bg-overlay {
            background: rgba(0, 0, 0, 0.6);
        }
    </style>
</head>
<body class="bg-hero min-h-screen flex items-center justify-center">

    <!-- Overlay for background dim effect -->
    <div class="bg-overlay w-full h-full absolute top-0 left-0"></div>

    <!-- Content Section -->
    <div class="relative z-10 text-center text-white p-8">
        <h1 class="text-5xl font-bold mb-6">Welcome to the Police of Sri Lanka</h1>
        <p class="text-lg mb-8 max-w-2xl mx-auto">
            Upholding justice, ensuring safety, and serving the nation with integrity.
        </p>

        <!-- User Login Button -->
        <a href="login.php" class="inline-block bg-green-600 text-white font-semibold px-6 py-3 rounded-lg hover:bg-green-700 transition duration-300">
            Login here
        </a>
    </div>

</body>
</html>
