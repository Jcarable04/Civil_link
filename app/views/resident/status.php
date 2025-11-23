<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Appointment Status</title>
    <style>
        /* Reset & font */
        * { margin:0; padding:0; box-sizing:border-box; }
        body {
            font-family: 'Poppins', sans-serif;
            background: #0f0c29;
            background: linear-gradient(135deg, #0f0c29 0%, #302b63 50%, #24243e 100%);
            min-height: 100vh;
            padding: 2rem;
            position: relative;
            color: #e2e8f0;
        }

        /* Background glowing orbs */
        body::before, body::after {
            content:'';
            position: fixed;
            border-radius: 50%;
            filter: blur(120px);
            opacity: 0.3;
            animation: floatOrb 20s infinite alternate ease-in-out;
        }
        body::before {
            width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(99,102,241,0.4) 0%, transparent 70%);
            top: 10%; left: 5%;
        }
        body::after {
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(168,85,247,0.35) 0%, transparent 70%);
            bottom: 10%; right: 10%;
            animation-delay: 5s;
        }
        @keyframes floatOrb {
            0% { transform: translate(0,0) scale(1); }
            50% { transform: translate(50px,-30px) scale(1.1); }
            100% { transform: translate(-30px,40px) scale(0.9); }
        }

        .container {
            position: relative;
            z-index: 1;
            max-width: 1000px;
            margin: auto;
        }

        /* Header */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 1rem;
            animation: fadeInDown 0.8s ease;
        }
        .header h2 {
            color: #fff;
            font-size: 2rem;
            text-shadow: 0 0 20px rgba(99,102,241,0.4);
        }
        .return-btn {
            background: rgba(255,255,255,0.05);
            color: #fff;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            border: 1px solid rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }
        .return-btn::before {
            content: '';
            position: absolute;
            top:0; left:-100%;
            width:100%; height:100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
            transition: left 0.5s;
        }
        .return-btn:hover::before { left:100%; }
        .return-btn:hover {
            background: rgba(99,102,241,0.2);
            border-color: rgba(99,102,241,0.5);
            box-shadow: 0 0 30px rgba(99,102,241,0.3);
            transform: translateY(-2px);
        }

        @keyframes fadeInDown {
            from { opacity:0; transform: translateY(-20px);}
            to { opacity:1; transform: translateY(0);}
        }

        /* Card style */
        .card {
            background: rgba(255,255,255,0.03);
            border-radius: 24px;
            border: 1px solid rgba(255,255,255,0.08);
            backdrop-filter: blur(20px);
            overflow: hidden;
            box-shadow: 0 8px 30px rgba(0,0,0,0.2);
            transition: all 0.4s ease;
            animation: slideUpFade 0.8s ease;
        }
        .card:hover {
            box-shadow: 0 0 60px rgba(99,102,241,0.5), 0 0 100px rgba(168,85,247,0.3);
            transform: translateY(-5px);
        }
        @keyframes slideUpFade {
            from { opacity:0; transform: translateY(40px);}
            to { opacity:1; transform: translateY(0);}
        }
        .card-body { padding:2rem; }

        /* Table */
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing:0;
        }
        thead th {
            color: #a5b4fc;
            font-weight:600;
            font-size:0.875rem;
            text-transform: uppercase;
            letter-spacing:1px;
            padding:1rem;
        }
        tbody td {
            padding: 1rem;
            color: #e2e8f0;
        }
        tbody tr {
            background: rgba(255,255,255,0.02);
            transition: all 0.4s ease;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            position: relative;
        }
        tbody tr:hover {
            background: rgba(99,102,241,0.05);
            box-shadow: 0 0 40px rgba(99,102,241,0.1), inset 0 0 60px rgba(99,102,241,0.03);
            transform: translateX(4px);
        }

        /* Badge effects */
        .badge {
            position: relative;
            overflow: hidden;
            transition: all 0.4s ease;
            padding: 0.5rem 1rem;
            border-radius: 12px;
            font-weight: 600;
            text-transform: capitalize;
        }
        .badge:hover { transform: scale(1.05); }

        .bg-warning { background: linear-gradient(135deg, #f59e0b, #d97706); color:#fff; }
        .bg-info { background: linear-gradient(135deg, #3b82f6, #2563eb); color:#fff; }
        .bg-success { background: linear-gradient(135deg, #10b981, #059669); color:#fff; }
        .bg-danger { background: linear-gradient(135deg, #ef4444, #dc2626); color:#fff; }
        .bg-secondary { background: linear-gradient(135deg, #6b7280, #4b5563); color:#fff; }

        /* Responsive */
        @media (max-width:768px){
            .header { flex-direction: column; align-items:flex-start; }
            .header h2 { font-size:1.5rem; margin-bottom:0.5rem; }
        }

    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>📅 My Appointment Status</h2>
            <a href="<?= site_url('resident/dashboard') ?>" class="return-btn">Return to Request_Form</a>
        </div>

        <div class="card">
            <div class="card-body">
                <?php if (!empty($appointments)): ?>
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Type</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Payment_Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($appointments as $index => $appt): ?>
                                    <tr>
                                        <td><?= $index + 1 ?></td>
                                        <td><?= htmlspecialchars($appt['appointment_type']) ?></td>
                                        <td><?= htmlspecialchars($appt['appointment_date']) ?></td>
                                        <td>
                                            <?php
                                                $badgeClass = match($appt['status']) {
                                                    'Pending' => 'bg-warning',
                                                    'Processing' => 'bg-info',
                                                    'Completed' => 'bg-success',
                                                    'Rejected' => 'bg-danger',
                                                    default => 'bg-secondary'
                                                };
                                            ?>
                                            <span class="badge <?= $badgeClass ?>">
                                                <?= htmlspecialchars($appt['status']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php
                                                $paymentBadge = match($appt['payment_status']) {
                                                    'unpaid' => 'bg-danger',
                                                    'paid_online' => 'bg-success',
                                                    'paid_on_site' => 'bg-info',
                                                    default => 'bg-secondary'
                                                };
                                            ?>
                                            <span class="badge <?= $paymentBadge ?>">
                                                <?= htmlspecialchars($appt['payment_status'] ?: 'unpaid') ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-center text-muted">No appointments found for your account.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>