<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Resident Login</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    font-family: 'Poppins', sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    background: linear-gradient(135deg, #0f0c29, #302b63, #24243e);
    overflow: hidden;
}

/* Floating circular shape behind the card */
.card::before {
    content: '';
    position: absolute;
    width: 300px;
    height: 300px;
    background: radial-gradient(circle, rgba(139,92,246,0.2) 0%, transparent 70%);
    border-radius: 50%;
    top: -100px;
    left: -100px;
    z-index: -1;
    animation: floatCircle 8s infinite ease-in-out;
}

@keyframes floatCircle {
    0%, 100% { transform: translateY(0) translateX(0) scale(1); opacity: 0.7; }
    50% { transform: translateY(20px) translateX(20px) scale(1.1); opacity: 0.9; }
}

/* Card container */
.card {
    position: relative;
    background: rgba(255, 255, 255, 0.95);
    border-radius: 25px;
    padding: 40px 30px;
    width: 400px;
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
    text-align: center;
    transition: all 0.4s ease;
    overflow: hidden;
}

.card:hover {
    box-shadow: 0 25px 60px rgba(139,92,246,0.6), 0 0 40px rgba(99,102,241,0.5);
    transform: translateY(-5px) scale(1.02);
}

/* Header */
h4 {
    font-size: 28px;
    font-weight: 700;
    margin-bottom: 10px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

/* Welcome message */
.welcome-message {
    font-size: 14px;
    color: #718096;
    margin-bottom: 25px;
}

/* Input fields */
input {
    width: 100%;
    padding: 15px 20px;
    margin-bottom: 15px;
    border-radius: 12px;
    border: 2px solid #e2e8f0;
    font-size: 15px;
    transition: all 0.3s ease;
}

input:focus {
    outline: none;
    border-color: #8b5cf6;
    box-shadow: 0 0 0 5px rgba(139,92,246,0.15);
}

/* Buttons */
.btn-primary {
    background: linear-gradient(135deg, #8b5cf6, #6366f1);
    color: #fff;
    border: none;
    padding: 12px 20px;
    border-radius: 15px;
    font-size: 16px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s ease;
    width: 100%;
    position: relative;
    overflow: hidden;
}

.btn-primary::before {
    content: '';
    position: absolute;
    width: 0;
    height: 100%;
    top: 0;
    left: 0;
    background: rgba(255,255,255,0.2);
    transition: all 0.4s ease;
}

.btn-primary:hover::before {
    width: 100%;
}

.btn-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(139,92,246,0.4);
    background: linear-gradient(135deg, #9d6fff, #7c3aed);
}

/* Alert */
.alert {
    border-radius: 12px;
}

/* Footer link */
p.text-center {
    margin-top: 20px;
    font-size: 14px;
    color: #718096;
}

p.text-center a {
    text-decoration: none;
    color: #8b5cf6;
    font-weight: 600;
}

p.text-center a:hover {
    text-decoration: underline;
}

/* Responsive */
@media (max-width: 480px) {
    .card {
        width: 90%;
        padding: 30px 20px;
    }
}
</style>
</head>
<body>

<div class="card">
    <h4>Resident Login</h4>
    <div class="welcome-message">Welcome back to <strong>Civil_Link</strong>. Enter your details to continue.</div>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger text-center">
            <?= $error ?>
        </div>
    <?php endif; ?>

    <form method="post" action="<?= site_url('resident/login') ?>">
        <input type="email" class="form-control" name="email" required placeholder="Email Address">
        <input type="password" class="form-control" name="password" required placeholder="Password">
        <button type="submit" class="btn-primary">Login</button>
    </form>

    <p class="text-center mt-3">
        Don’t have an account? <a href="<?= site_url('resident/register') ?>">Register here</a>
    </p>
</div>

</body>
</html>