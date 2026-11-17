<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marwadi StudySpace</title>
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

        .profile-icon {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: linear-gradient(135deg, #4a90e2 0%, #357abd 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            border: 2px solid #e0e0e0;
        }

        .profile-icon:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(74, 144, 226, 0.3);
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

            .profile-icon {
                width: 40px;
                height: 40px;
                font-size: 18px;
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
        <a href="profile.php" class="profile-icon" title="Profile">
            <span>U</span>
        </a>
    </div>