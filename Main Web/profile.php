<?php include 'header.php'; ?>

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
        margin: 0 auto;
        min-height: calc(100vh - 80px);
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .profile-container {
        width: 100%;
        max-width: 900px;
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        padding: 50px 60px;
        text-align: center;
    }

    .profile-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: linear-gradient(135deg, #4a90e2 0%, #357abd 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 50px;
        font-weight: 600;
        margin: 0 auto 25px;
        border: 4px solid #f0f0f0;
        box-shadow: 0 4px 20px rgba(74, 144, 226, 0.3);
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
        padding: 25px;
        margin-bottom: 30px;
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
        font-weight: 500;
        font-size: 14px;
        text-align: left;
    }

    .info-value {
        color: #1f2937;
        font-weight: 600;
        font-size: 15px;
        text-align: right;
    }

    .logout-button-container {
        text-align: left;
        margin-top: 30px;
    }

    .logout-button {
        display: inline-block;
        padding: 14px 35px;
        background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
        color: white;
        text-decoration: none;
        border-radius: 10px;
        font-weight: 600;
        font-size: 16px;
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
            padding: 40px 25px;
        }

        .profile-avatar {
            width: 100px;
            height: 100px;
            font-size: 42px;
        }

        .profile-name {
            font-size: 24px;
        }

        .info-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 5px;
        }

        .info-value {
            text-align: left;
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
            <div class="profile-container">
                <div class="profile-avatar">U</div>
                <h1 class="profile-name">User Name</h1>
                
                <div class="profile-info">
                    <div class="info-item">
                        <div class="info-label">Email</div>
                        <div class="info-value">user@example.com</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">User ID</div>
                        <div class="info-value">MU12345678</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Department</div>
                        <div class="info-value">Computer Science</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Semester</div>
                        <div class="info-value">5th Semester</div>
                    </div>
                </div>

                <div class="logout-button-container">
                    <a href="index.php" class="logout-button">Logout</a>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>