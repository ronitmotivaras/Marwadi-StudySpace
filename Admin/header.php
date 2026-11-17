<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marwadi StudySpace Admin</title>
    <link rel="icon" type="image/png" href="img/Marwadi_University_logo.png">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #ffffff;
            min-height: 100vh;
        }

        .top-header {
            background: #ffffff;
            padding: 15px 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .top-header-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .top-header-logo {
            height: 45px;
            width: auto;
        }

        .top-header-name {
            color: #000000;
            font-size: 22px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .logout-btn {
            padding: 10px 20px;
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .logout-btn:hover {
            background: linear-gradient(135deg, #c0392b 0%, #a93226 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(231, 76, 60, 0.3);
        }

        @media (max-width: 768px) {
            .top-header {
                padding: 12px 20px;
            }

            .top-header-logo {
                height: 35px;
            }

            .top-header-name {
                font-size: 18px;
            }

            .logout-btn {
                padding: 8px 15px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="top-header">
        <div class="top-header-left">
            <img src="img/Marwadi_University_logo.png" alt="Logo" class="top-header-logo">
            <div class="top-header-name">Marwadi StudySpace</div>
        </div>
        <a href="index.php" class="logout-btn">Logout</a>
    </div>