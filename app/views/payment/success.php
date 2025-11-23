<?php defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful</title>
    <!-- Load Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
            /* Using a light green background to emphasize success */
            background-color: #f0fdf4; /* Tailwind green-50 */
        }
    </style>
</head>
<body class="flex justify-center items-center min-h-screen p-4">

    <div class="max-w-md w-full bg-white p-8 sm:p-10 rounded-xl shadow-2xl ring-4 ring-green-400/50 text-center transition-all duration-300 transform hover:scale-[1.01]">
        
        <!-- Success Icon -->
        <div class="mb-6">
            <svg class="mx-auto h-20 w-20 text-green-500 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>

        <!-- Title -->
        <h2 class="text-3xl font-extrabold text-green-700 mb-2">Payment Successful!</h2>
        
        <!-- Message -->
        <p class="text-gray-600 mb-8 text-lg">
            Your appointment has been successfully paid for. A confirmation receipt has been sent to your registered email.
        </p>

        <!-- Action Button -->
        <a class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-full shadow-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-500 focus:ring-opacity-50 transition duration-300 ease-in-out transform hover:translate-y-0.5" 
           href="<?= site_url('resident/dashboard'); ?>">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Back to Dashboard
        </a>
    </div>

</body>
</html>