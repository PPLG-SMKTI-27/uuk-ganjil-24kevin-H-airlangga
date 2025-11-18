<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Not Found</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #333;
            line-height: 1.6;
        }

        .container {
            max-width: 800px;
            width: 90%;
            text-align: center;
            padding: 2rem;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .error-code {
            font-size: 8rem;
            font-weight: 700;
            color: #4a6ee0;
            line-height: 1;
            margin-bottom: 1rem;
            text-shadow: 3px 3px 0 rgba(0, 0, 0, 0.1);
        }

        .error-title {
            font-size: 2.5rem;
            margin-bottom: 1.5rem;
            color: #2d3748;
        }

        .error-message {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            color: #4a5568;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .redirect-info {
            background-color: #edf2f7;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 2rem;
            font-size: 1rem;
        }

        .countdown {
            font-weight: bold;
            color: #4a6ee0;
        }

        .actions {
            display: flex;
            justify-content: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-block;
            padding: 0.8rem 1.5rem;
            background-color: #4a6ee0;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #3a5bc7;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .btn-secondary {
            background-color: #e2e8f0;
            color: #4a5568;
        }

        .btn-secondary:hover {
            background-color: #cbd5e0;
        }

        .illustration {
            max-width: 300px;
            margin: 0 auto 2rem;
        }

        @media (max-width: 768px) {
            .error-code {
                font-size: 6rem;
            }

            .error-title {
                font-size: 2rem;
            }

            .actions {
                flex-direction: column;
                align-items: center;
            }

            .btn {
                width: 100%;
                max-width: 250px;
            }
        }

        @media (max-width: 480px) {
            .error-code {
                font-size: 4rem;
            }

            .error-title {
                font-size: 1.5rem;
            }

            .container {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="illustration">
            <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                <path fill="#4A6EE0" d="M44.7,-76.4C57.8,-69.2,68.8,-57.5,75.8,-43.8C82.7,-30.1,85.5,-14.5,86.5,1.2C87.5,16.9,86.6,33.8,79.8,48.1C73,62.4,60.2,74.2,45.2,80.8C30.2,87.4,13.6,88.8,-2.5,92.5C-18.6,96.2,-37.2,102.2,-52.7,97.1C-68.2,91.9,-80.5,75.6,-88.5,57.3C-96.5,38.9,-100.1,18.5,-100.8,-2.2C-101.5,-22.9,-99.2,-45.7,-88.5,-63.1C-77.8,-80.4,-58.7,-92.2,-40.4,-97.1C-22.2,-102,-11.1,-100,-2.7,-94.6C5.7,-89.2,11.4,-80.4,19.1,-72.9C26.8,-65.4,36.5,-59.2,44.7,-51.8Z" transform="translate(100 100)" />
            </svg>
        </div>

        <div class="error-code">404</div>
        <h1 class="error-title">Oops! Page Not Found</h1>
        <p class="error-message">The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.</p>

        <div class="redirect-info">
            <p>You will be automatically redirected to the homepage in <span id="countdown" class="countdown">5</span> seconds.</p>
        </div>

        <div class="actions">
            <a href="/" class="btn">Go to Homepage</a>
            <a href="javascript:history.back()" class="btn btn-secondary">Go Back</a>
        </div>
    </div>

    <script>
        // Countdown timer for redirect
        let countdown = 5;
        const countdownElement = document.getElementById('countdown');

        const timer = setInterval(function() {
            countdown--;
            countdownElement.textContent = countdown;

            if (countdown <= 0) {
                clearInterval(timer);
                window.location.href = "/";
            }
        }, 1000);

        // Optional: Allow user to cancel redirect
        document.addEventListener('click', function() {
            clearInterval(timer);
            document.querySelector('.redirect-info').innerHTML = '<p>Redirect cancelled. You can navigate manually using the buttons above.</p>';
        });
    </script>
</body>
</html>
