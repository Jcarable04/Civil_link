<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

// Ensure session is started for flash messages
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <style>
        /* === 1. Global Reset and Typography === */
        :root {
            --sidebar-width: 260px;
            --primary-dark: #1f2937; /* Dark Slate */
            --primary-accent: #3b82f6; /* Vibrant Blue */
            --bg-light: #f9fafb;
            --card-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            --success-color: #10b981;
            --danger-color: #ef4444;
            --info-color: #38bdf8;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-light);
            margin: 0;
            padding: 0;
            display: flex; /* Helps manage sidebar and content layout */
        }
        
        a {
            text-decoration: none;
        }

        /* === 2. Sidebar Layout and Style (Fixed) === */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            background-color: var(--primary-dark);
            padding: 20px 0;
            position: fixed;
            top: 0;
            left: 0;
            color: #fff;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }
        
        .sidebar .logo {
            text-align: center;
            margin-bottom: 40px;
            padding: 0 20px;
        }

        .sidebar .logo h4 {
            font-weight: 700;
            margin-top: 10px;
            letter-spacing: 0.5px;
        }
        
        .sidebar nav {
            padding: 0 15px;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            color: #d1d5db;
            padding: 12px 15px;
            margin-bottom: 8px;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-weight: 400;
        }

        .sidebar a i {
            margin-right: 12px;
            font-size: 18px;
            width: 25px;
            text-align: center;
        }
        
        .sidebar a:hover, 
        .sidebar a.active {
            background-color: var(--primary-accent);
            color: #fff;
            box-shadow: 0 2px 5px rgba(59, 130, 246, 0.4);
        }

        .sidebar a.logout {
            position: absolute;
            bottom: 30px;
            width: calc(100% - 30px);
            background-color: var(--danger-color);
            color: #fff;
            box-shadow: 0 2px 5px rgba(239, 68, 68, 0.4);
        }

        /* === 3. Main Content Area === */
        .content {
            flex-grow: 1;
            margin-left: var(--sidebar-width);
            padding: 30px 40px;
        }
        
        .content h2 {
            font-size: 28px;
            font-weight: 600;
            color: #333;
            margin-bottom: 30px;
            border-bottom: 2px solid #e5e7eb;
            padding-bottom: 10px;
        }

        /* === 4. Flash Messages (Alerts) === */
        .alert {
            padding: 15px;
            margin-bottom: 25px;
            border-radius: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: 600;
            position: relative;
        }
        
        .alert-success {
            background-color: #d1fae5;
            color: var(--success-color);
            border: 1px solid #a7f3d0;
        }

        .alert-danger {
            background-color: #fee2e2;
            color: var(--danger-color);
            border: 1px solid #fecaca;
        }

        .alert-dismissible .btn-close {
            background: none;
            border: none;
            font-size: 20px;
            cursor: pointer;
            color: inherit;
            padding: 0 10px;
        }

        /* === 5. Dashboard Stats (Cards) === */
        .row {
            display: flex;
            flex-wrap: wrap;
            margin-left: -15px;
            margin-right: -15px;
        }

        .col {
            padding: 0 15px;
            flex-basis: 0;
            flex-grow: 1;
            max-width: 100%;
        }
        
        /* Specific column sizes for the stats */
        .col-xl-3 { flex: 0 0 25%; max-width: 25%; }
        .col-md-4 { flex: 0 0 33.3333%; max-width: 33.3333%; }
        
        .card {
            background: #fff;
            border-radius: 12px;
            box-shadow: var(--card-shadow);
            padding: 25px;
            transition: all 0.3s ease;
            margin-bottom: 20px;
            height: 100%;
            border: none;
            position: relative;
            overflow: hidden; /* Hide the background shape overflow */
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .card-body h5 {
            font-weight: 600;
            font-size: 16px;
            opacity: 0.9;
        }
        
        .card-body p {
            font-size: 36px;
            font-weight: 700;
            margin-top: 5px;
            line-height: 1;
        }

        /* Card Colors */
        .bg-primary { background-color: var(--primary-accent); color: #fff; }
        .bg-info { background-color: var(--info-color); color: #fff; }

        /* Realistic background shape effect */
        .card::before {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 120px;
            height: 120px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            z-index: 0;
        }


        /* === 6. Table Styling === */
        .table-responsive {
            overflow-x: auto;
        }

        .table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 10px; /* Space between rows */
        }
        
        .table thead th {
            text-align: left;
            padding: 15px 20px;
            background-color: #e5e7eb;
            color: #4b5563;
            font-weight: 600;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: none;
        }
        
        .table thead tr {
            border-radius: 10px;
            overflow: hidden;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .table tbody tr {
            background-color: #fff;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .table tbody tr:hover {
            background-color: #eff6ff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
        }

        .table td {
            padding: 15px 20px;
            border: none;
            border-top: 1px solid #f3f4f6;
            vertical-align: middle;
            font-size: 14px;
            color: #4b5563;
        }
        
        .table-striped tbody tr:nth-child(even) {
             background-color: #fcfcfd;
        }


        /* === 7. Button Styling === */
        .btn {
            display: inline-block;
            padding: 8px 15px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            margin-right: 5px;
            transition: all 0.2s ease;
            text-align: center;
        }

        .btn-success {
            background-color: var(--success-color);
            color: #fff;
        }

        .btn-danger {
            background-color: var(--danger-color);
            color: #fff;
        }
        
        .btn-success:hover {
            background-color: #059669;
            transform: translateY(-1px);
        }
        
        .btn-danger:hover {
            background-color: #dc2626;
            transform: translateY(-1px);
        }
        
        .text-center { text-align: center; }
        .text-white { color: #fff !important; }
        .text-danger { color: var(--danger-color) !important; }
        .mt-2 { margin-top: 0.5rem !important; }
        .mt-4 { margin-top: 1.5rem !important; }
        .mb-3 { margin-bottom: 1rem !important; }
        .mb-4 { margin-bottom: 1.5rem !important; }
        .fs-3 { font-size: 1.75rem !important; }
        
    </style>
    </head>
<body>

<div class="sidebar">
    <div class="logo">
        <h4 class="text-white mt-2">ADMIN PANEL</h4>
    </div>
    <nav>
        <a href="/admin/dashboard" class="active">
            <i class="fas fa-chart-line"></i> Dashboard
        </a>
        <a href="/admin/pendingAppointments">
            <i class="fas fa-hourglass-start"></i> Pending Appointments
        </a>
        <a href="/admin/processingAppointments">
            <i class="fas fa-sync-alt"></i> Processing Appointments
        </a>
        <a href="/admin/recentRecords">
            <i class="fas fa-book"></i> Recent Records
        </a>
        <a href="/admin/logout" class="logout mt-4">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </nav>
</div>

<div class="content">

    <?php if (!empty($_SESSION['success_message']) || !empty($_SESSION['success'])): 
        $message = $_SESSION['success_message'] ?? $_SESSION['success'];
        unset($_SESSION['success_message'], $_SESSION['success']); ?>
        <div class="alert alert-success alert-dismissible" role="alert">
            <span><?= $message; ?></span>
            <button type="button" class="btn-close" onclick="this.parentElement.style.display='none';" aria-label="Close">&times;</button>
        </div>
    <?php elseif (!empty($_SESSION['error'])): 
        $message = $_SESSION['error'];
        unset($_SESSION['error']); ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
            <span><?= $message; ?></span>
            <button type="button" class="btn-close" onclick="this.parentElement.style.display='none';" aria-label="Close">&times;</button>
        </div>
    <?php endif; ?>

    <?php if (basename($_SERVER['PHP_SELF'], '.php') === 'dashboard'): ?>
    <h2 class="mb-4">Dashboard Overview</h2>
    <div class="row mb-4">
        <div class="col col-xl-3 mb-3">
            <div class="card bg-primary h-100">
                <div class="card-body">
                    <h5>Total Appointments</h5>
                    <p class="fs-3"><?= $totalAppointments ?? 0 ?></p>
                </div>
            </div>
        </div>
        <div class="col col-xl-3 mb-3">
            <div class="card bg-info h-100">
                <div class="card-body">
                    <h5>Total Records</h5>
                    <p class="fs-3"><?= $totalRecords ?? 0 ?></p>
                </div>
            </div>
        </div>
        
    </div>
    <?php endif; ?>

    <?php if (!empty($pageSection) && $pageSection === 'pending'): ?>
        <h2 class="mb-4">Pending Appointments</h2>
        <div class="card">
            <div class="card-body table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Contact Number</th>
                            <th>Type</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($pendingAppointments)): ?>
                            <?php foreach ($pendingAppointments as $idx => $appt): ?>
                                <tr>
                                    <td><?= $idx + 1 ?></td>
                                    <td><?= htmlspecialchars($appt['citizen_name']) ?></td>
                                    <td><?= htmlspecialchars($appt['email']) ?></td>
                                    <td><?= htmlspecialchars($appt['contact_number']) ?></td>
                                    <td><?= htmlspecialchars($appt['appointment_type']) ?></td>
                                    <td><?= htmlspecialchars($appt['appointment_date']) ?></td>
                                    <td><?= htmlspecialchars($appt['status']) ?></td>
                                    <td>
                                        <a href="/admin/approve/<?= $appt['id'] ?>" class="btn btn-success">Approve</a>
                                        <a href="/admin/reject/<?= $appt['id'] ?>" class="btn btn-danger">Reject</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center">No pending appointments found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    <?php elseif (!empty($pageSection) && $pageSection === 'processing'): ?>
        <h2 class="mb-4">Processing Appointments</h2>
        <div class="card">
            <div class="card-body table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Contact Number</th>
                            <th>Type</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($processingAppointments)): ?>
                            <?php foreach ($processingAppointments as $idx => $appt): ?>
                                <tr>
                                    <td><?= $idx + 1 ?></td>
                                    <td><?= htmlspecialchars($appt['citizen_name']) ?></td>
                                    <td><?= htmlspecialchars($appt['email']) ?></td>
                                    <td><?= htmlspecialchars($appt['contact_number']) ?></td>
                                    <td><?= htmlspecialchars($appt['appointment_type']) ?></td>
                                    <td><?= htmlspecialchars($appt['appointment_date']) ?></td>
                                    <td><?= htmlspecialchars($appt['status']) ?></td>
                                    <td>
                                        <a href="/admin/complete/<?= $appt['id'] ?>" class="btn btn-success">Complete</a>
                                        <a href="/admin/reject/<?= $appt['id'] ?>" class="btn btn-danger">Reject</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center">No processing appointments found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    <?php elseif (!empty($pageSection) && $pageSection === 'records'): ?>
        <h2 class="mb-4">Recent Records</h2>
        <div class="card">
            <div class="card-body table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Citizen Name</th>
                            <th>Record Type</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($recentRecords)): ?>
                            <?php foreach ($recentRecords as $idx => $rec): ?>
                                <tr>
                                    <td><?= $idx + 1 ?></td>
                                    <td><?= htmlspecialchars($rec['citizen_name'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($rec['record_type'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($rec['date_of_record'] ?? '') ?></td>
                                    <td>
                                        <form method="POST" action="/records/delete/<?= $rec['id'] ?>" 
                                              onsubmit="return confirm('Are you sure you want to delete this record?');">
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">No recent records found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>

</div>

<script>
    // Simple JS to remove the alert on close button click
    document.querySelectorAll('.alert-dismissible .btn-close').forEach(button => {
        button.addEventListener('click', function() {
            this.closest('.alert').style.display = 'none';
        });
    });
</script>
</body>
</html>