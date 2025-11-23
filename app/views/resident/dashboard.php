<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resident Dashboard</title>
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

        /* Styles for the progress step circle and line */
        .progress-step .step {
            flex: 1;
            text-align: center;
            position: relative;
        }
        
        .progress-step .step-circle {
            display: inline-flex;
            width: 30px;
            height: 30px;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.3s ease;
            z-index: 10; /* Ensure circle is above the line */
        }

        .progress-step .step-line {
            content: '';
            position: absolute;
            top: 15px;
            left: 50%;
            width: 100%;
            height: 4px;
            background-color: #e5e7eb; /* Gray 200 */
            z-index: 5;
            transform: translateY(-50%);
            transition: background-color 0.3s ease;
        }

        .progress-step .step:first-child .step-line {
            width: 50%;
            left: 50%;
        }

        .progress-step .step:last-child .step-line {
            width: 50%;
            left: 0;
        }
    </style>
</head>
<body class="flex min-h-screen">

<!-- Sidebar -->
<div class="w-64 bg-gray-800 text-white p-6 flex flex-col shadow-xl">
    <h3 class="text-2xl font-bold mb-6 border-b border-gray-700 pb-3">Resident Panel</h3>
    
    <nav class="space-y-2 flex-grow">
        <a href="<?= site_url('resident/dashboard') ?>" class="block px-4 py-2 rounded-lg transition duration-150 ease-in-out font-medium
            <?= ($active_tab === 'dashboard') ? 'bg-indigo-600 hover:bg-indigo-700 shadow-md' : 'hover:bg-gray-700' ?>">
            Request Form
        </a>
        <a href="<?= site_url('resident/status') ?>" class="block px-4 py-2 rounded-lg transition duration-150 ease-in-out font-medium
            <?= ($active_tab === 'status') ? 'bg-indigo-600 hover:bg-indigo-700 shadow-md' : 'hover:bg-gray-700' ?>">
            Status
        </a>
        <a href="<?= site_url('resident/payment') ?>" class="block px-4 py-2 rounded-lg transition duration-150 ease-in-out font-medium
            <?= ($active_tab === 'payment') ? 'bg-indigo-600 hover:bg-indigo-700 shadow-md' : 'hover:bg-gray-700' ?>">
            Payment
        </a>
    </nav>


    <div class="mt-auto pt-4 border-t border-gray-700 space-y-2">
    <a href="<?= site_url('gotoAdmin') ?>" 
       class="block px-4 py-2 rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 transition duration-150 ease-in-out text-center font-medium">
        Admin Dashboard
    </a>
    <a href="<?= site_url('resident/logout') ?>" 
       class="block px-4 py-2 rounded-lg text-red-400 hover:bg-gray-700 transition duration-150 ease-in-out text-center font-medium">
        Logout
    </a>
</div>
</div>

<!-- Content -->
<div class="flex-1 p-4 md:p-8 lg:p-12">
    <header class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Hello, <?= htmlspecialchars($name ?? 'Resident') ?>!</h1>
        <p class="text-gray-500 mt-1">Manage your appointment requests and view their status.</p>
    </header>

    <!-- Existing Appointments Table -->
    <div class="bg-white shadow-xl rounded-xl ring-1 ring-gray-200">
        <div class="p-6">
            
            
            <?php if (!empty($appointments) && is_array($appointments)): ?>
                <div class="table-responsive overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-indigo-600">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white rounded-tl-xl">#</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white">Type</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white rounded-tr-xl">Tracking</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            <?php 
                            $count = 1;
                            foreach ($appointments as $appt): 
                                $status = $appt['status'] ?? 'Pending';

                                // Determine badge styling based on status
                                $badge_class = match($status) {
                                    'Pending' => 'bg-yellow-100 text-yellow-800',
                                    'Approved' => 'bg-teal-100 text-teal-800', // Interpreted as processing/approved
                                    'Completed' => 'bg-green-100 text-green-800',
                                    'Rejected' => 'bg-red-100 text-red-800',
                                    default => 'bg-gray-100 text-gray-800',
                                };

                                // Determine progress step classes
                                $step1_active = $status === 'Pending' || $status === 'Rejected';
                                $step1_completed = $status !== 'Pending' && $status !== 'Rejected';
                                
                                $step2_active = $status === 'Approved';
                                $step2_completed = in_array($status, ['Completed']);

                                $step3_completed = $status === 'Completed';
                            ?>
                                <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?= $count++ ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600"><?= htmlspecialchars($appt['appointment_type'] ?? 'N/A') ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600"><?= htmlspecialchars($appt['appointment_date'] ?? 'N/A') ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full <?= $badge_class ?>">
                                            <?= $status ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <?php if ($status !== 'Rejected'): ?>
                                            <div class="progress-step flex items-center justify-between text-xs sm:text-sm max-w-xs mx-auto pt-2">
                                                
                                                <!-- Step 1: Pending -->
                                                <div class="step relative z-10">
                                                    <div class="step-line bg-indigo-600"></div>
                                                    <div class="step-circle inline-block text-white font-bold text-xs
                                                        <?= $step1_completed || $step2_completed || $step3_completed ? 'bg-green-500' : ($step1_active ? 'bg-indigo-600' : 'bg-gray-300 text-gray-500') ?>">
                                                        1
                                                    </div>
                                                    <small class="block mt-1 text-gray-600">Pending</small>
                                                </div>

                                                <!-- Step 2: Processing -->
                                                <div class="step relative z-10">
                                                    <div class="step-line bg-indigo-600"></div>
                                                    <div class="step-circle inline-block text-white font-bold text-xs
                                                        <?= $step2_completed || $step3_completed ? 'bg-green-500' : ($step2_active ? 'bg-indigo-600' : 'bg-gray-300 text-gray-500') ?>">
                                                        2
                                                    </div>
                                                    <small class="block mt-1 text-gray-600">Processing</small>
                                                </div>

                                                <!-- Step 3: Completed -->
                                                <div class="step relative z-10">
                                                    <div class="step-circle inline-block text-white font-bold text-xs
                                                        <?= $step3_completed ? 'bg-green-500' : 'bg-gray-300 text-gray-500' ?>">
                                                        3
                                                    </div>
                                                    <small class="block mt-1 text-gray-600">Completed</small>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <span class="text-sm text-red-500 font-medium">Request Rejected</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                
            <?php endif; ?>
        </div>
    </div>

    <!-- Request New Appointment Form -->
    <div class="mt-10 bg-white shadow-xl rounded-xl ring-1 ring-gray-200 p-6">
        <h3 class="text-xl font-semibold mb-5 text-gray-700 border-b pb-3">Request New Appointment</h3>
        <form method="POST" action="<?= site_url('resident/requestAppointment') ?>" class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Hidden Fields -->
            <input type="hidden" name="resident_id" value="<?= htmlspecialchars($residentId ?? '') ?>">
            <input type="hidden" name="citizen_name" value="<?= htmlspecialchars($name ?? '') ?>">
            <input type="hidden" name="email" value="<?= htmlspecialchars($email ?? '') ?>">
            <input type="hidden" name="contact_number" value="<?= htmlspecialchars($contact_number ?? '') ?>">

            <!-- Appointment Type Select -->
            <div>
    <label for="appointment_type" class="block text-sm font-medium text-gray-700 mb-1">Appointment Type</label>
    <select id="appointment_type" name="appointment_type"
        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-lg shadow-sm
               focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
        
        <option value="">Select Type</option>
        
        <!-- Civil Registry -->
        <option value="Birth Certificate">Birth Certificate</option>
        <option value="Marriage Contract">Marriage Contract</option>
        <option value="Death Certificate">Death Certificate</option>
        <option value="Late Registration of Birth">Late Registration of Birth</option>
        
        <!-- Barangay & Municipal Docs -->
        <option value="Barangay Clearance">Barangay Clearance</option>
        <option value="Certificate of Residency">Certificate of Residency</option>
        <option value="Certificate of Indigency">Certificate of Indigency</option>
        <option value="Certificate of Good Moral Character">Certificate of Good Moral Character</option>
        <option value="Certificate of Solo Parent">Certificate of Solo Parent</option>
        <option value="Community Tax Certificate (Cedula)">Community Tax Certificate (Cedula)</option>
        
        <!-- Other Legal Docs -->
        <option value="Affidavit of Loss">Affidavit of Loss</option>
        <option value="Affidavit of Undertaking">Affidavit of Undertaking</option>
        <option value="Affidavit of Guardianship">Affidavit of Guardianship</option>
        
        <!-- Business & Employment -->
        <option value="Business Permit">Business Permit</option>
        <option value="Certificate of Employment Verification">Certificate of Employment Verification</option>
        
    </select>
</div>

            <!-- Appointment Date Input -->
            <div>
                <label for="appointment_date" class="block text-sm font-medium text-gray-700 mb-1"> Date</label>
                <input type="date" id="appointment_date" name="appointment_date" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required
                    min="<?= date('Y-m-d') ?>">
            </div>

            <!-- Submit Button -->
            <div class="md:col-span-1 flex items-end">
                <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Request Appointment
                </button>
            </div>
        </form>
    </div>

</div>
</body>
</html>