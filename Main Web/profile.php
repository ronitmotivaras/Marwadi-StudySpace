<?php 
session_start();

// Check if user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: user_login.php");
    exit;
}

include "config/_dbconnect.php";

$user_id = $_SESSION['user_id'];

// Fetch user details from database
$sql = "SELECT user_id, en_num, name, email FROM `user` WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) == 0) {
    echo "User not found!";
    exit;
}

$user = mysqli_fetch_assoc($result);

// Get first letter of name for avatar
$first_letter = strtoupper(substr($user['name'], 0, 1));

include 'header.php'; 
?>

<style>
    .main-layout {
        display: flex;
    }

    .sidebar {
        width: 250px;
        background: #ffffff;
        min-height: calc(100vh - 77px);
        padding: 20px 0;
        box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
    }

    .sidebar-menu {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .sidebar-menu li {
        margin: 0;
    }

    .sidebar-menu a {
        display: block;
        padding: 15px 25px;
        color: #333;
        text-decoration: none;
        transition: all 0.3s ease;
        border-left: 3px solid transparent;
    }

    .sidebar-menu a:hover {
        background: #f8f9fa;
        border-left-color: #4a90e2;
        color: #4a90e2;
    }

    .sidebar-menu a.active {
        background: #f8f9fa;
        border-left-color: #4a90e2;
        color: #4a90e2;
        font-weight: 600;
    }

    .content-wrapper {
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .main-content {
        padding: 30px;
        max-width: 1200px;
        width: 100%;
        margin: 0 auto;
        min-height: calc(100vh - 80px);
    }

    .back-button {
        background: #6c757d;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        cursor: pointer;
        font-size: 15px;
        font-weight: 500;
        transition: all 0.3s ease;
        margin-bottom: 30px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }

    .back-button:hover {
        background: #5a6268;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(108, 117, 125, 0.3);
    }

    .profile-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: calc(100vh - 220px);
    }

    .profile-container {
        width: 100%;
        max-width: 650px;
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        padding: 45px 55px;
        text-align: center;
    }

    .profile-avatar {
        width: 110px;
        height: 110px;
        border-radius: 50%;
        background: linear-gradient(135deg, #4a90e2 0%, #357abd 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 48px;
        font-weight: 600;
        margin: 0 auto 20px;
        border: 4px solid #f0f0f0;
        box-shadow: 0 6px 25px rgba(74, 144, 226, 0.3);
    }

    .profile-name {
        color: #333;
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 30px;
        letter-spacing: 0.5px;
    }

    .profile-info {
        background: #f8f9fb;
        border-radius: 12px;
        padding: 25px 30px;
        margin-bottom: 25px;
    }

    .info-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 15px 0;
        border-bottom: 1px solid #e5e7eb;
    }

    .info-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .info-item:first-child {
        padding-top: 0;
    }

    .info-label {
        color: #6b7280;
        font-weight: 600;
        font-size: 14px;
        text-align: left;
    }

    .info-value {
        color: #1f2937;
        font-weight: 600;
        font-size: 15px;
        text-align: right;
        word-break: break-all;
    }

    .logout-button-container {
        text-align: left;
        margin-top: 25px;
    }

    .logout-button {
        display: inline-block;
        padding: 12px 32px;
        background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
        color: white;
        text-decoration: none;
        border-radius: 10px;
        font-weight: 600;
        font-size: 15px;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        box-shadow: 0 4px 15px rgba(231, 76, 60, 0.2);
    }

    .logout-button:hover {
        background: linear-gradient(135deg, #c0392b 0%, #a93226 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(231, 76, 60, 0.3);
    }

    @media (max-width: 768px) {
        .sidebar {
            width: 200px;
        }

        .main-content {
            padding: 20px;
        }

        .profile-container {
            padding: 35px 25px;
        }

        .profile-avatar {
            width: 90px;
            height: 90px;
            font-size: 40px;
        }

        .profile-name {
            font-size: 24px;
        }

        .profile-info {
            padding: 20px;
        }

        .info-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
            padding: 12px 0;
        }

        .info-value {
            text-align: left;
            font-size: 14px;
        }

        .info-label {
            font-size: 13px;
        }
    }
</style>

<div class="main-layout">
    <div class="sidebar">
        <ul class="sidebar-menu">
            <li><a href="Dashboard.php">Dashboard</a></li>
            <li><a href="bookmarks.php">Bookmarks</a></li>
        </ul>
    </div>

    <div class="content-wrapper">
        <div class="main-content">
            <a href="Dashboard.php" class="back-button">← Back</a>
            
            <div class="profile-wrapper">
                <div class="profile-container">
                    <div class="profile-avatar"><?php echo $first_letter; ?></div>
                    <h1 class="profile-name"><?php echo htmlspecialchars($user['name']); ?></h1>
                    
                    <div class="profile-info">
                        <div class="info-item">
                            <div class="info-label">Enrollment Number</div>
                            <div class="info-value"><?php echo htmlspecialchars($user['en_num']); ?></div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Email</div>
                            <div class="info-value"><?php echo htmlspecialchars($user['email']); ?></div>
                        </div>
                    </div>

                    <div class="logout-button-container">
                        <a href="logout.php" class="logout-button">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>