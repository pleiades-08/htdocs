<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts - Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #1a202c; /* Dark background */
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-4">
    <div class="bg-gray-800 p-8 md:p-12 rounded-xl shadow-lg text-center max-w-md w-full">
        <!-- 404 Illustration/Icon -->
        <div class="mb-6">
            <!-- Using an SVG for a simple, scalable icon related to "not found" -->
            <svg class="mx-auto w-24 h-24 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>

        <!-- Main Heading -->
        <h1 class="text-6xl md:text-7xl font-extrabold text-gray-100 mb-4">404</h1>

        <!-- Sub-heading -->
        <h2 class="text-2xl md:text-3xl font-semibold text-gray-200 mb-4">Page Not Found</h2>

        <!-- Friendly Message -->
        <p class="text-gray-300 mb-8 leading-relaxed">
            Oops! It looks like the page you're trying to reach doesn't exist or has been moved.
            Don't worry, it happens to the best of us.
        </p>

        <!-- Call to Action Button -->
        <a href="/" class="inline-block bg-blue-600 text-white font-bold py-3 px-6 rounded-lg shadow-md hover:bg-blue-700 transition duration-300 ease-in-out transform hover:scale-105">
            Go to Homepage
        </a>
    </div>
</body>
</html>
