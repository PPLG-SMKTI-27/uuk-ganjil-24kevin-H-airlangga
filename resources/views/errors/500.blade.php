<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Server Error</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Nunito', sans-serif;
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

        .minimal {
            align-items: center;
            background-color: rgba(255, 255, 255, 0.95);
            display: flex;
            flex-direction: column;
            height: 100vh;
            justify-content: center;
            margin: 0;
            padding: 2rem;
            width: 100%;
        }

        .error-container {
            text-align: center;
            max-width: 600px;
            width: 100%;
        }

        .error-code {
            border-right: 2px solid #636b6f;
            color: #636b6f;
            font-size: 26px;
            padding: 0 15px 0 15px;
            text-align: center;
            display: inline-block;
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .error-title {
            color: #636b6f;
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .error-message {
            color: #636b6f;
            font-size: 18px;
            text-align: center;
            margin-bottom: 2rem;
        }

        .redirect-info {
            background-color: #edf2f7;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 2rem;
            font-size: 1rem;
            color: #4a5568;
        }

        .countdown {
            font-weight: bold;
            color: #e53e3e;
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
            font-size: 16px;
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

        .error-illustration {
            max-width: 200px;
            margin: 0 auto 2rem;
        }

        @media (max-width: 768px) {
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
            .minimal {
                padding: 1rem;
            }

            .error-code {
                font-size: 22px;
            }

            .error-title {
                font-size: 20px;
            }

            .error-message {
                font-size: 16px;
            }
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="minimal">
        <div class="error-container">
            <div class="error-illustration">
                <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                    <path fill="#E53E3E" d="M49.6,-85.1C64.3,-78.5,76.7,-64.9,85.3,-49.1C93.9,-33.3,98.7,-15.3,97.9,2.1C97.1,19.5,90.7,36.3,79.9,49.6C69.1,62.9,53.9,72.7,37.7,78.9C21.5,85.1,4.3,87.7,-11.8,85.1C-27.9,82.5,-42.8,74.7,-55.9,63.4C-69,52.1,-80.3,37.3,-85.2,20.4C-90.1,3.5,-88.6,-15.5,-81.9,-31.9C-75.2,-48.3,-63.3,-62.1,-48.7,-68.8C-34.1,-75.5,-16.9,-75.1,-0.3,-74.6C16.3,-74.1,32.6,-73.5,46.3,-67.7C60,-61.9,71.1,-50.9,79.2,-38.2C87.3,-25.5,92.5,-11.1,93.4,3.7C94.3,18.5,91,36.3,82.4,50.7C73.8,65.1,59.9,75.6,45.1,82.2C30.3,88.8,14.6,91.1,-0.7,92.3C-16.1,93.5,-31.5,93.1,-45.7,87.3C-59.9,81.5,-72.9,70.3,-81.9,56.3C-90.9,42.3,-95.9,25.5,-97.2,8.3C-98.5,-8.9,-96.1,-26.5,-89.1,-42.1C-82.1,-57.7,-70.5,-71.3,-56.2,-78.3C-41.9,-85.3,-24.9,-85.7,-7.2,-85.9C10.5,-86.1,34.9,-91.7,49.6,-85.1Z" transform="translate(100 100)" />
                </svg>
            </div>

            <div class="error-code">500</div>
            <h1 class="error-title">Server Error</h1>
            <p class="error-message">Something went wrong on our servers. We're working to fix the issue.</p>

            <div class="redirect-info">
                <p>You will be automatically redirected to the homepage in <span id="countdown" class="countdown">5</span> seconds.</p>
            </div>

            <div class="actions">
                <a href="/" class="btn">Go to Homepage</a>
                <button onclick="location.reload()" class="btn btn-secondary">Try Again</button>
            </div>
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
