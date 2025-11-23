<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

// Helper to get base URL dynamically
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'];
$script = dirname($_SERVER['SCRIPT_NAME']);
$baseUrl = rtrim($protocol . '://' . $host . $script, '/');
?>

<!doctype html>
<html lang="en">
 <head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Verify OTP - Resident Login</title>
  <script src="/_sdk/element_sdk.js"></script>
  <style>
        body {
            box-sizing: border-box;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            position: relative;
            overflow: hidden;
        }

        .background-decoration {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 0;
        }

        .circle-decoration {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            animation: float 20s infinite ease-in-out;
        }

        .circle-1 {
            width: 300px;
            height: 300px;
            top: -150px;
            left: -150px;
            animation-delay: 0s;
        }

        .circle-2 {
            width: 200px;
            height: 200px;
            bottom: -100px;
            right: -100px;
            animation-delay: 2s;
        }

        .circle-3 {
            width: 150px;
            height: 150px;
            top: 50%;
            left: -75px;
            animation-delay: 4s;
        }

        .circle-4 {
            width: 250px;
            height: 250px;
            top: 20%;
            right: -125px;
            animation-delay: 1s;
        }

        @keyframes float {
            0%, 100% {
                transform: translate(0, 0) scale(1);
            }
            25% {
                transform: translate(30px, -30px) scale(1.1);
            }
            50% {
                transform: translate(-20px, 20px) scale(0.9);
            }
            75% {
                transform: translate(20px, 30px) scale(1.05);
            }
        }

        .particles {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: rgba(255, 255, 255, 0.5);
            border-radius: 50%;
            animation: rise 15s infinite ease-in;
        }

        @keyframes rise {
            0% {
                transform: translateY(100%) translateX(0) scale(0);
                opacity: 0;
            }
            10% {
                opacity: 1;
            }
            90% {
                opacity: 1;
            }
            100% {
                transform: translateY(-100%) translateX(50px) scale(1);
                opacity: 0;
            }
        }

        html, body {
            height: 100%;
        }

        .verification-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2), 0 0 0 1px rgba(255, 255, 255, 0.3);
            max-width: 440px;
            width: 100%;
            padding: 48px 40px;
            animation: slideUp 0.4s ease-out;
            position: relative;
            z-index: 1;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .verification-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
            border-radius: 24px 24px 0 0;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .icon-container {
            width: 72px;
            height: 72px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
            position: relative;
            animation: pulse 3s ease-in-out infinite;
            box-shadow: 0 8px 24px rgba(102, 126, 234, 0.4);
        }

        .icon-container::before {
            content: '';
            position: absolute;
            top: -4px;
            left: -4px;
            right: -4px;
            bottom: -4px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 18px;
            opacity: 0.3;
            animation: glow 2s ease-in-out infinite;
            z-index: -1;
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }

        @keyframes glow {
            0%, 100% {
                opacity: 0.3;
                transform: scale(1);
            }
            50% {
                opacity: 0.6;
                transform: scale(1.1);
            }
        }

        .icon-container svg {
            width: 36px;
            height: 36px;
            stroke: #ffffff;
            stroke-width: 2;
            fill: none;
            animation: iconFloat 3s ease-in-out infinite;
        }

        @keyframes iconFloat {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-4px);
            }
        }

        h1 {
            font-size: 28px;
            font-weight: 700;
            color: #1a202c;
            text-align: center;
            margin-bottom: 12px;
        }

        .subtitle {
            font-size: 15px;
            color: #718096;
            text-align: center;
            margin-bottom: 32px;
            line-height: 1.5;
        }

        .alert {
            background: #fee;
            border: 1px solid #fcc;
            border-radius: 12px;
            padding: 14px 16px;
            margin-bottom: 24px;
            font-size: 14px;
            color: #c53030;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .alert svg {
            width: 20px;
            height: 20px;
            flex-shrink: 0;
        }

        .form-group {
            margin-bottom: 24px;
        }

        label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 8px;
        }

        .otp-input {
            width: 100%;
            padding: 14px 16px;
            font-size: 18px;
            font-weight: 500;
            letter-spacing: 8px;
            text-align: center;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            transition: all 0.3s ease;
            background: #f7fafc;
            position: relative;
        }

        .otp-input:focus {
            outline: none;
            border-color: #667eea;
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1), 0 8px 16px rgba(102, 126, 234, 0.15);
            transform: translateY(-2px);
        }

        .otp-input::placeholder {
            letter-spacing: normal;
            color: #a0aec0;
            font-weight: 400;
        }

        .submit-button {
            width: 100%;
            padding: 16px;
            font-size: 16px;
            font-weight: 600;
            color: #ffffff;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        .submit-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }

        .submit-button:active {
            transform: translateY(0);
        }

        .helper-text {
            text-align: center;
            margin-top: 24px;
            padding-top: 24px;
            border-top: 1px solid #e2e8f0;
        }

        .helper-text p {
            font-size: 14px;
            color: #718096;
            margin-bottom: 12px;
        }

        .resend-link {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: color 0.2s ease;
        }

        .resend-link:hover {
            color: #764ba2;
            text-decoration: underline;
        }

        @media (max-width: 480px) {
            .verification-container {
                padding: 36px 28px;
            }

            h1 {
                font-size: 24px;
            }

            .icon-container {
                width: 64px;
                height: 64px;
            }
        }
    </style>
  <style>@view-transition { navigation: auto; }</style>
  <script src="/_sdk/data_sdk.js" type="text/javascript"></script>
  <script src="https://cdn.tailwindcss.com" type="text/javascript"></script>
 </head>
 <body>
  <div class="background-decoration">
   <div class="circle-decoration circle-1"></div>
   <div class="circle-decoration circle-2"></div>
   <div class="circle-decoration circle-3"></div>
   <div class="circle-decoration circle-4"></div>
   <div class="particles" id="particles"></div>
  </div>
  <div class="verification-container">
   <div class="icon-container">
    <svg viewbox="0 0 24 24"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
    </svg>
   </div>
   <h1>Verify Your Login</h1>
   <p class="subtitle">We've sent a 6-digit verification code to your email address</p><!--?php if (isset($error)): ?-->
   <div class="alert">
    <svg viewbox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="10" /> <line x1="12" y1="8" x2="12" y2="12" /> <line x1="12" y1="16" x2="12.01" y2="16" />
    </svg><span><!--?= htmlspecialchars($error) ?--></span>
   </div><!--?php endif; ?-->
   <form method="POST" action="<?= $baseUrl ?>/index.php/resident/verifyOtp">
    <div class="form-group"><label for="otp">Verification Code</label> <input type="text" class="otp-input" id="otp" name="otp" placeholder="000000" maxlength="6" pattern="[0-9]{6}" required autocomplete="one-time-code">
    </div><button type="submit" class="submit-button">Verify Code</button>
   </form>
   <div class="helper-text">
    <p>Didn't receive the code?</p><a href="#" class="resend-link">Resend Code</a>
   </div>
  </div>
  <script>
        const defaultConfig = {
            gradient_start: "#667eea",
            gradient_end: "#764ba2",
            card_background: "#ffffff",
            text_primary: "#1a202c",
            text_secondary: "#718096",
            accent_color: "#667eea"
        };

        async function onConfigChange(config) {
            const gradientStart = config.gradient_start || defaultConfig.gradient_start;
            const gradientEnd = config.gradient_end || defaultConfig.gradient_end;
            const accentColor = config.accent_color || defaultConfig.accent_color;
            const cardBg = config.card_background || defaultConfig.card_background;
            const textPrimary = config.text_primary || defaultConfig.text_primary;
            const textSecondary = config.text_secondary || defaultConfig.text_secondary;

            document.body.style.background = linear-gradient(135deg, ${gradientStart} 0%, ${gradientEnd} 100%);
            document.querySelector('.verification-container').style.background = cardBg;
            document.querySelector('h1').style.color = textPrimary;
            document.querySelector('.subtitle').style.color = textSecondary;
            document.querySelector('.icon-container').style.background = linear-gradient(135deg, ${gradientStart} 0%, ${gradientEnd} 100%);
            document.querySelector('.submit-button').style.background = linear-gradient(135deg, ${gradientStart} 0%, ${gradientEnd} 100%);
            document.querySelector('.resend-link').style.color = accentColor;
            
            const helperPs = document.querySelectorAll('.helper-text p');
            helperPs.forEach(p => p.style.color = textSecondary);
            
            document.querySelectorAll('label').forEach(label => label.style.color = textPrimary);
        }

        if (window.elementSdk) {
            window.elementSdk.init({
                defaultConfig,
                onConfigChange,
                mapToCapabilities: (config) => ({
                    recolorables: [
                        {
                            get: () => config.gradient_start || defaultConfig.gradient_start,
                            set: (value) => {
                                config.gradient_start = value;
                                window.elementSdk.setConfig({ gradient_start: value });
                            }
                        },
                        {
                            get: () => config.card_background || defaultConfig.card_background,
                            set: (value) => {
                                config.card_background = value;
                                window.elementSdk.setConfig({ card_background: value });
                            }
                        },
                        {
                            get: () => config.text_primary || defaultConfig.text_primary,
                            set: (value) => {
                                config.text_primary = value;
                                window.elementSdk.setConfig({ text_primary: value });
                            }
                        },
                        {
                            get: () => config.accent_color || defaultConfig.accent_color,
                            set: (value) => {
                                config.accent_color = value;
                                window.elementSdk.setConfig({ accent_color: value });
                            }
                        }
                    ],
                    borderables: [],
                    fontEditable: undefined,
                    fontSizeable: undefined
                }),
                mapToEditPanelValues: (config) => new Map([])
            });
        }

        // Auto-focus OTP input
        document.getElementById('otp').focus();

        // Only allow numbers in OTP input
        document.getElementById('otp').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        // Create floating particles
        function createParticles() {
            const particlesContainer = document.getElementById('particles');
            const particleCount = 30;

            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.animationDelay = Math.random() * 15 + 's';
                particle.style.animationDuration = (15 + Math.random() * 10) + 's';
                particlesContainer.appendChild(particle);
            }
        }

        createParticles();
    </script>
 <script>(function(){function c(){var b=a.contentDocument||a.contentWindow.document;if(b){var d=b.createElement('script');d.innerHTML="window.__CF$cv$params={r:'9a274b0cb2089949',t:'MTc2MzgwMjYyMS4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);";b.getElementsByTagName('head')[0].appendChild(d)}}if(document.body){var a=document.createElement('iframe');a.height=1;a.width=1;a.style.position='absolute';a.style.top=0;a.style.left=0;a.style.border='none';a.style.visibility='hidden';document.body.appendChild(a);if('loading'!==document.readyState)c();else if(window.addEventListener)document.addEventListener('DOMContentLoaded',c);else{var e=document.onreadystatechange||function(){};document.onreadystatechange=function(b){e(b);'loading'!==document.readyState&&(document.onreadystatechange=e,c())}}}})();</script></body>
</html>