<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Oops! Something Went Wrong</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            background: #f8fafc;
            color: #22223b;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        .error-container {
            background: #fff;
            padding: 2.5rem 3rem;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(60, 60, 60, 0.08);
            text-align: center;
            max-width: 400px;
        }
        .error-code {
            font-size: 4rem;
            font-weight: bold;
            color: #e63946;
            margin-bottom: 0.5rem;
        }
        .error-message {
            font-size: 1.25rem;
            margin-bottom: 1.5rem;
        }
        .home-link {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            background: #457b9d;
            color: #fff;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            transition: background 0.2s;
        }
        .home-link:hover {
            background: #1d3557;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-code">404</div>
        <div class="error-message">
            Sorry, the page you are looking for doesn't exist or an error occurred.<br>
            Please try again later.
        </div>
        <a href="<?= AppUtil::url(['ctl' => 'home'])?>" class="home-link">Go to Homepage</a>
    </div>
</body>
</html>