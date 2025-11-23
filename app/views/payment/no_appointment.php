<?php defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>No Appointments Found</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; padding-top: 50px; }
        h2 { color: #333; }
        p { color: #555; }
    </style>
</head>
<body>
    <h2>No unpaid completed appointments found.</h2>
    <p>Please complete an appointment before proceeding to payment.</p>
    <a href="<?= site_url('resident/dashboard'); ?>">Go back to dashboard</a>
</body>
</html>