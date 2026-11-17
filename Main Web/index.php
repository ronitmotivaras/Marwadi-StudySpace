<?php
session_start();
$showerror = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "config/_dbconnect.php";
    
    $enrollment = $_POST['enrollment'];
    $password = $_POST['password'];
    
    // Query to get user by enrollment number
    $sql = "SELECT * FROM `user` WHERE en_num = '$enrollment'";
    $result = mysqli_query($conn, $sql);
    
    if ($result) {
        $num = mysqli_num_rows($result);
        
        if ($num == 1) {
            $row = mysqli_fetch_assoc($result);
            
            // Verify password using password_verify for hashed passwords
            if (password_verify($password, $row['pass'])) {
                // Login successful
                $_SESSION['loggedin'] = true;
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['en_num'] = $row['en_num'];
                $_SESSION['name'] = $row['name'];
                $_SESSION['email'] = $row['email'];
                
                header("Location: Dashboard.php");
                exit;
            } else {
                $showerror = "Wrong credentials";
            }
        } else {
            $showerror = "Wrong credentials";
        }
    } else {
        $showerror = "Database error";
    }
    
    mysqli_close($conn);
}
?>
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
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-image: url('img/background.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            position: relative;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1;
        }

        .login-container {
            position: relative;
            z-index: 2;
            background: rgba(255, 255, 255, 0.15);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 320px;
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .logo-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo-container img {
            max-width: 150px;
            height: auto;
            margin-bottom: 10px;
        }

        .project-name {
            color: #fff;
            font-size: 20px;
            font-weight: 600;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
            letter-spacing: 0.5px;
        }

        .error-alert {
            background: rgba(231, 76, 60, 0.9);
            color: #fff;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 15px;
            text-align: center;
            font-size: 14px;
            font-weight: 500;
            border: 1px solid rgba(255, 255, 255, 0.3);
            animation: shake 0.5s;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 6px;
            color: #fff;
            font-weight: 500;
            font-size: 13px;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
        }

        .form-group input {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 6px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.9);
            color: #333;
        }

        .form-group input:focus {
            outline: none;
            border-color: #4a90e2;
            box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.2);
            background: rgba(255, 255, 255, 1);
        }

        .form-group input::placeholder {
            color: #999;
        }

        .login-btn {
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
            margin-top: 5px;
        }

        .login-btn:hover {
            background: linear-gradient(135deg, #357abd 0%, #2a5f8f 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(74, 144, 226, 0.4);
        }

        .login-btn:active {
            transform: translateY(0);
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 25px 20px;
                margin: 20px;
                max-width: 280px;
            }

            .logo-container img {
                max-width: 120px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo-container">
            <img src="img/Marwadi_University_logo.png" alt="Marwadi University Logo">
            <div class="project-name">Marwadi StudySpace</div>
        </div>

        <?php if ($showerror): ?>
            <div class="error-alert">
                <?php echo $showerror; ?>
            </div>
        <?php endif; ?>
        
        <form action="" method="POST">
            <div class="form-group">
                <label for="enrollment">Enrollment no</label>
                <input 
                    type="text" 
                    id="enrollment" 
                    name="enrollment" 
                    placeholder="Enter your enrollment number" 
                    required
                >
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    placeholder="Enter your password" 
                    required
                >
            </div>
            
            <button type="submit" class="login-btn">Submit</button>
        </form>
    </div>
</body>
</html>