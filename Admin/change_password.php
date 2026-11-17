<?php 
session_start();

// Check if user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php");
    exit;
}

// Handle password change form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "config/_dbconnect.php";
    
    $currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];
    $admin_id = $_SESSION['admin_id'];
    
    $error = "";
    $success = false;
    
    // Validation
    if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
        $error = "All fields are required";
    } elseif (strlen($newPassword) < 6) {
        $error = "New password must be at least 6 characters long";
    } elseif ($newPassword !== $confirmPassword) {
        $error = "New passwords do not match";
    } else {
        // Get current password from database
        $sql = "SELECT password FROM `admin` WHERE admin_id = '$admin_id'";
        $result = mysqli_query($conn, $sql);
        
        if ($result && mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            
            // Check if current password matches
            if ($currentPassword == $row['password']) {
                // Update password
                $updateSql = "UPDATE `admin` SET password = '$newPassword' WHERE admin_id = '$admin_id'";
                
                if (mysqli_query($conn, $updateSql)) {
                    $success = true;
                } else {
                    $error = "Failed to update password";
                }
            } else {
                $error = "Current password is incorrect";
            }
        } else {
            $error = "Admin not found";
        }
        
        mysqli_close($conn);
    }
}

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
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .password-form-container {
        background: #ffffff;
        padding: 40px;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        max-width: 500px;
        width: 100%;
    }

    .form-header {
        margin-bottom: 30px;
        text-align: center;
    }

    .form-header h1 {
        color: #333;
        font-size: 28px;
        margin-bottom: 10px;
    }

    .form-header p {
        color: #666;
        font-size: 14px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        color: #333;
        font-weight: 500;
        font-size: 14px;
    }

    .form-group input {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #e0e0e0;
        border-radius: 6px;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .form-group input:focus {
        outline: none;
        border-color: #4a90e2;
        box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.2);
    }

    .error-message {
        color: #e74c3c;
        font-size: 12px;
        margin-top: 5px;
        display: none;
    }

    .error-message.show {
        display: block;
    }

    .submit-btn {
        width: 100%;
        padding: 12px;
        background: linear-gradient(135deg, #4a90e2 0%, #357abd 100%);
        color: white;
        border: none;
        border-radius: 6px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 10px;
    }

    .submit-btn:hover {
        background: linear-gradient(135deg, #357abd 0%, #2a5f8f 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(74, 144, 226, 0.3);
    }

    .submit-btn:active {
        transform: translateY(0);
    }

    .success-message {
        background: #d4edda;
        color: #155724;
        padding: 12px;
        border-radius: 6px;
        margin-bottom: 20px;
        text-align: center;
        font-size: 14px;
    }

    .error-alert {
        background: #f8d7da;
        color: #721c24;
        padding: 12px;
        border-radius: 6px;
        margin-bottom: 20px;
        text-align: center;
        font-size: 14px;
    }

    @media (max-width: 768px) {
        .sidebar {
            width: 200px;
        }

        .main-content {
            padding: 20px;
        }

        .password-form-container {
            padding: 30px 20px;
        }

        .form-header h1 {
            font-size: 24px;
        }
    }
</style>

<div class="main-layout">
    <div class="sidebar">
        <ul class="sidebar-menu">
            <li><a href="Dashboard.php">Dashboard</a></li>
            <li><a href="change_password.php" class="active">Change Admin Password</a></li>
        </ul>
    </div>

    <div class="content-wrapper">
        <div class="main-content">
            <div class="password-form-container">
                <div class="form-header">
                    <h1>Change Admin Password</h1>
                    <p>Update your admin password</p>
                </div>

                <?php if (isset($success) && $success): ?>
                    <div class="success-message">
                        Password changed successfully!
                    </div>
                <?php endif; ?>

                <?php if (isset($error) && !empty($error)): ?>
                    <div class="error-alert">
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="change_password.php" id="changePasswordForm">
                    <div class="form-group">
                        <label for="currentPassword">Current Password</label>
                        <input 
                            type="password" 
                            id="currentPassword" 
                            name="currentPassword" 
                            placeholder="Enter current password" 
                            required
                        >
                        <div class="error-message" id="currentPasswordError">
                            Current password is required
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="newPassword">New Password</label>
                        <input 
                            type="password" 
                            id="newPassword" 
                            name="newPassword" 
                            placeholder="Enter new password" 
                            required
                        >
                        <div class="error-message" id="newPasswordError">
                            Password must be at least 6 characters long
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="confirmPassword">Confirm Password</label>
                        <input 
                            type="password" 
                            id="confirmPassword" 
                            name="confirmPassword" 
                            placeholder="Confirm new password" 
                            required
                        >
                        <div class="error-message" id="confirmPasswordError">
                            Passwords do not match
                        </div>
                    </div>

                    <button type="submit" class="submit-btn">Change Password</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Real-time validation
    document.getElementById('newPassword').addEventListener('input', function() {
        const error = document.getElementById('newPasswordError');
        if (this.value.length > 0 && this.value.length < 6) {
            error.classList.add('show');
        } else {
            error.classList.remove('show');
        }
    });

    document.getElementById('confirmPassword').addEventListener('input', function() {
        const error = document.getElementById('confirmPasswordError');
        const newPassword = document.getElementById('newPassword').value;
        if (this.value !== newPassword && this.value.length > 0) {
            error.classList.add('show');
        } else {
            error.classList.remove('show');
        }
    });
</script>

</body>
</html>