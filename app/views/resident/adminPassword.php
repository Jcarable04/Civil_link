<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Access</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #4f46e5, #3b82f6);
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        /* Floating circles */
        .circle {
            position: absolute;
            border-radius: 50%;
            background: rgba(255,255,255,0.15);
            animation: float 6s infinite ease-in-out;
        }
        .circle-1 { width: 180px; height: 180px; top: 10%; left: 10%; animation-delay: 0s; }
        .circle-2 { width: 300px; height: 300px; bottom: 5%; right: 15%; animation-delay: 2s; }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-25px); }
        }

        /* Card */
        .card {
            width: 380px;
            padding: 35px;
            background: rgba(255,255,255,0.15);
            border-radius: 18px;
            backdrop-filter: blur(12px);
            box-shadow: 0 8px 30px rgba(0,0,0,0.2);
            color: white;
            animation: fadeSlide 0.9s ease;
        }

        @keyframes fadeSlide {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0px); }
        }

        h2 {
            text-align: center;
            margin-bottom: 15px;
            font-size: 26px;
            font-weight: 600;
        }

        p {
            text-align: center;
            margin-bottom: 25px;
            opacity: 0.9;
        }

        .input-group {
            margin-bottom: 18px;
        }

        input {
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            border: none;
            outline: none;
            background: rgba(255,255,255,0.25);
            color: white;
            font-size: 15px;
            transition: 0.3s;
        }

        input:focus {
            background: rgba(255,255,255,0.35);
            box-shadow: 0 0 8px rgba(255,255,255,0.7);
        }

        button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 10px;
            background: white;
            color: #3b82f6;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
            font-size: 16px;
        }

        button:hover {
            background: #e5e7eb;
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(0,0,0,0.2);
        }

        .error {
            text-align: center;
            margin-top: 10px;
            color: #ffb3b3;
            font-size: 14px;
        }

    </style>
</head>
<body>

    <!-- Floating shapes -->
    <div class="circle circle-1"></div>
    <div class="circle circle-2"></div>

    <div class="card">
        <h2>🔐 Admin Access</h2>
        <p>Please enter the admin password to continue.</p>

        <form action="/resident/adminAccess" method="POST">
            <div class="input-group">
                <input type="password" name="admin_password" placeholder="Enter Admin Password" required>
            </div>

            <button type="submit">Continue</button>

            <?php if(isset($error)): ?>
                <div class="error"><?= $error ?></div>
            <?php endif; ?>
        </form>
    </div>

</body>
</html>
