<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Processing Appointments</title>
    <!-- Load Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Custom Styles for a clean, modern look */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f7f9fc; /* Very light blue-grey background */
        }
        
        /* Custom scrollbar for better table experience on large data sets */
        .table-responsive::-webkit-scrollbar {
            height: 8px;
        }
        .table-responsive::-webkit-scrollbar-thumb {
            background: #d1d5db; /* light gray */
            border-radius: 10px;
        }
        .table-responsive::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        /* Focus state for actions */
        .btn:focus {
            outline: 2px solid #3b82f6; /* Blue ring focus */
            outline-offset: 2px;
        }

        /* Subtle stripe effect for table rows */
        .striped-row:nth-child(even) {
            background-color: #f9fafb; /* Lighter stripe */
        }
    </style>
</head>
<body>
<div class="min-h-screen p-4 md:p-8 lg:p-12">
    <div class="max-w-7xl mx-auto">
        
        <!-- Header -->
        <header class="mb-8">
            <h1 class="text-4xl font-extrabold text-gray-800 tracking-tight border-b-4 border-teal-500 pb-2 inline-block">
                Processing Appointments
            </h1>
            <p class="text-gray-500 mt-2">View appointments that are currently being processed.</p>
        </header>

        <!-- Main Card Container -->
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden ring-1 ring-gray-200">
            <div class="p-4 sm:p-6 lg:p-8">
                
                <!-- Table Responsive Wrapper -->
                <div class="table-responsive overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        
                        <!-- Table Header: Using Teal for a slight visual difference from 'Pending' -->
                        <thead class="bg-teal-600">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white rounded-tl-xl">#</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white">Full Name</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white">Contact Number</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white">Type</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white">Status</th>
                                <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider text-white rounded-tr-xl">Actions</th>
                            </tr>
                        </thead>
                        
                        <!-- Table Body -->
                        <tbody class="bg-white divide-y divide-gray-100">
                        <?php if (!empty($processingAppointments)): ?>
                            <?php foreach ($processingAppointments as $idx => $appt): ?>
                                <tr class="striped-row hover:bg-teal-50 transition duration-150 ease-in-out">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?= $idx + 1 ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600"><?= htmlspecialchars($appt['citizen_name']) ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-teal-600 truncate max-w-[150px] md:max-w-none" title="<?= htmlspecialchars($appt['email']) ?>"><?= htmlspecialchars($appt['email']) ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600"><?= htmlspecialchars($appt['contact_number']) ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            <?= htmlspecialchars($appt['appointment_type']) ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600"><?= htmlspecialchars($appt['appointment_date']) ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <!-- Status Badge for Processing -->
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-teal-100 text-teal-800">
                                            <?= htmlspecialchars($appt['status']) ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium space-x-2">
                                        <!-- Complete Button -->
                                        <a href="/admin/complete/<?= $appt['id'] ?>" class="btn inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150 ease-in-out">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            Complete
                                        </a>
                                        <!-- Reject Button -->
                                        <a href="/admin/reject/<?= $appt['id'] ?>" class="btn inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150 ease-in-out">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            Reject
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="px-6 py-12 whitespace-nowrap text-center text-lg text-gray-400">
                                    <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <p class="mt-4">No processing appointments found.</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                
            </div>
        </div>

        <!-- Back Button -->
        <a href="/admin/dashboard" class="mt-8 inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-md text-white bg-gray-500 hover:bg-gray-600 transition duration-150 ease-in-out">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Back to Dashboard
        </a>
    </div>
</div>
</body>
</html>