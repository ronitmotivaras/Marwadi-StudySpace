<?php 
session_start();

// Check if user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php");
    exit;
}

include "config/_dbconnect.php";

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];
    
    if ($action == 'add') {
        $name = $_POST['name'];
        $en_num = $_POST['en_num'];
        $email = $_POST['email'];
        $pass = $_POST['pass'];
        
        // Validate password length
        if (strlen($pass) < 6) {
            $error = "Password must be at least 6 characters long";
        } else {
            // Hash the password
            $hashed_password = password_hash($pass, PASSWORD_DEFAULT);
            
            $sql = "INSERT INTO `user` (name, en_num, email, pass) VALUES ('$name', '$en_num', '$email', '$hashed_password')";
            
            if (mysqli_query($conn, $sql)) {
                $success = "User added successfully";
            } else {
                $error = "Failed to add user";
            }
        }
    }
    
    if ($action == 'update') {
        $user_id = $_POST['user_id'];
        $name = $_POST['name'];
        $en_num = $_POST['en_num'];
        $email = $_POST['email'];
        $pass = $_POST['pass'];
        
        // Check if password is provided
        if (!empty($pass)) {
            // Validate password length
            if (strlen($pass) < 6) {
                $error = "Password must be at least 6 characters long";
            } else {
                // Hash the new password
                $hashed_password = password_hash($pass, PASSWORD_DEFAULT);
                
                $sql = "UPDATE `user` SET name='$name', en_num='$en_num', email='$email', pass='$hashed_password' WHERE user_id='$user_id'";
                
                if (mysqli_query($conn, $sql)) {
                    $success = "User updated successfully";
                } else {
                    $error = "Failed to update user";
                }
            }
        } else {
            // Update without changing password
            $sql = "UPDATE `user` SET name='$name', en_num='$en_num', email='$email' WHERE user_id='$user_id'";
            
            if (mysqli_query($conn, $sql)) {
                $success = "User updated successfully";
            } else {
                $error = "Failed to update user";
            }
        }
    }
    
    if ($action == 'delete') {
        $user_id = $_POST['user_id'];
        
        $sql = "DELETE FROM `user` WHERE user_id='$user_id'";
        
        if (mysqli_query($conn, $sql)) {
            $success = "User deleted successfully";
        } else {
            $error = "Failed to delete user";
        }
    }
}

// Fetch all users
$sql = "SELECT * FROM `user`";
$result = mysqli_query($conn, $sql);

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
        flex: 1;
    }

    .page-header {
        margin-bottom: 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .page-header-left h1 {
        color: #333;
        font-size: 32px;
        margin-bottom: 10px;
    }

    .page-header-left p {
        color: #666;
        font-size: 16px;
    }

    .add-user-btn {
        padding: 10px 20px;
        background: linear-gradient(135deg, #4a90e2 0%, #357abd 100%);
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

    .add-user-btn:hover {
        background: linear-gradient(135deg, #357abd 0%, #2a5f8f 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(74, 144, 226, 0.3);
    }

    .users-table-container {
        background: #ffffff;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .users-table {
        width: 100%;
        border-collapse: collapse;
    }

    .users-table thead {
        background: #2c3e50;
        color: #ffffff;
    }

    .users-table th {
        padding: 15px;
        text-align: left;
        font-weight: 600;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .users-table tbody tr {
        border-bottom: 1px solid #e0e0e0;
        transition: background 0.3s ease;
    }

    .users-table tbody tr:hover {
        background: #f8f9fa;
    }

    .users-table tbody tr:last-child {
        border-bottom: none;
    }

    .users-table td {
        padding: 15px;
        color: #333;
        font-size: 14px;
    }

    .edit-icon {
        cursor: pointer;
        color: #4a90e2;
        font-size: 18px;
        transition: color 0.3s ease;
    }

    .edit-icon:hover {
        color: #357abd;
    }

    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        justify-content: center;
        align-items: center;
    }

    .modal.show {
        display: flex;
    }

    .modal-content {
        background: #ffffff;
        padding: 30px;
        border-radius: 10px;
        max-width: 500px;
        width: 90%;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }

    .modal-header {
        margin-bottom: 20px;
    }

    .modal-header h2 {
        color: #333;
        font-size: 24px;
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
        padding: 10px 12px;
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

    .form-note {
        font-size: 12px;
        color: #666;
        margin-top: 5px;
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

    .modal-buttons {
        display: flex;
        gap: 10px;
        justify-content: flex-end;
        margin-top: 20px;
    }

    .btn {
        padding: 10px 20px;
        border: none;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-primary {
        background: linear-gradient(135deg, #4a90e2 0%, #357abd 100%);
        color: white;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #357abd 0%, #2a5f8f 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(74, 144, 226, 0.3);
    }

    .btn-secondary {
        background: #e0e0e0;
        color: #333;
    }

    .btn-secondary:hover {
        background: #d0d0d0;
    }

    .btn-danger {
        background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
        color: white;
    }

    .btn-danger:hover {
        background: linear-gradient(135deg, #c0392b 0%, #a93226 100%);
    }

    .alert {
        padding: 12px 20px;
        border-radius: 6px;
        margin-bottom: 20px;
        font-size: 14px;
    }

    .alert-success {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .alert-error {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    @media (max-width: 768px) {
        .sidebar {
            width: 200px;
        }

        .main-content {
            padding: 20px;
        }

        .page-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }

        .page-header-left h1 {
            font-size: 24px;
        }

        .add-user-btn {
            padding: 8px 15px;
            font-size: 14px;
        }

        .users-table {
            font-size: 12px;
        }

        .users-table th,
        .users-table td {
            padding: 10px;
        }
    }
</style>

<div class="main-layout">
    <div class="sidebar">
        <ul class="sidebar-menu">
            <li><a href="Dashboard.php" class="active">Dashboard</a></li>
            <li><a href="change_password.php">Change Admin Password</a></li>
        </ul>
    </div>

    <div class="content-wrapper">
        <div class="main-content">
            <?php if (isset($success)): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            
            <?php if (isset($error)): ?>
                <div class="alert alert-error"><?php echo $error; ?></div>
            <?php endif; ?>

            <div class="page-header">
                <div class="page-header-left">
                    <h1>Manage Users</h1>
                    <p>View and manage all users in the system</p>
                </div>
                <button class="add-user-btn" onclick="openAddUserModal()">Add User</button>
            </div>

            <div class="users-table-container">
                <table class="users-table">
                    <thead>
                        <tr>
                            <th>Sr. No</th>
                            <th>Name</th>
                            <th>En No</th>
                            <th>Email</th>
                            <th>Password</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="usersTableBody">
                        <?php 
                        $sr_no = 1;
                        while ($row = mysqli_fetch_assoc($result)): 
                        ?>
                        <tr>
                            <td><?php echo $sr_no++; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['en_num']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td>••••••••</td>
                            <td>
                                <span class="edit-icon" onclick='editUser(<?php echo json_encode($row); ?>)'>✏️</span>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Edit/Add User Modal -->
<div class="modal" id="userModal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 id="modalTitle">Edit User</h2>
        </div>
        <form method="POST" action="Dashboard.php" id="userForm">
            <input type="hidden" id="action" name="action" value="add">
            <input type="hidden" id="user_id" name="user_id">
            
            <div class="form-group">
                <label for="userName">Name</label>
                <input type="text" id="userName" name="name" required>
            </div>
            
            <div class="form-group">
                <label for="userEnNo">Enrollment Number</label>
                <input type="number" id="userEnNo" name="en_num" required>
            </div>
            
            <div class="form-group">
                <label for="userEmail">Email</label>
                <input type="email" id="userEmail" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="userPassword">Password</label>
                <input type="text" id="userPassword" name="pass">
                <div class="form-note" id="passwordNote">Minimum 6 characters required</div>
                <div class="error-message" id="passwordError">Password must be at least 6 characters long</div>
            </div>
            
            <div class="modal-buttons">
                <button type="button" class="btn btn-secondary" onclick="closeUserModal()">Cancel</button>
                <button type="button" class="btn btn-danger" id="deleteBtn" onclick="deleteUser()" style="display: none;">Delete</button>
                <button type="submit" class="btn btn-primary" id="submitBtn">Add</button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Form (hidden) -->
<form method="POST" action="Dashboard.php" id="deleteForm" style="display: none;">
    <input type="hidden" name="action" value="delete">
    <input type="hidden" name="user_id" id="delete_user_id">
</form>

<script>
    let currentUserId = null;
    let isEditMode = false;

    function editUser(userData) {
        isEditMode = true;
        currentUserId = userData.user_id;
        
        document.getElementById('action').value = 'update';
        document.getElementById('user_id').value = userData.user_id;
        document.getElementById('userName').value = userData.name;
        document.getElementById('userEnNo').value = userData.en_num;
        document.getElementById('userEmail').value = userData.email;
        document.getElementById('userPassword').value = '';
        
        // Change password field requirement for edit mode
        document.getElementById('userPassword').removeAttribute('required');
        document.getElementById('passwordNote').textContent = 'Leave blank to keep current password. Minimum 6 characters if changing.';
        
        document.getElementById('modalTitle').textContent = 'Edit User';
        document.getElementById('submitBtn').textContent = 'Update';
        document.getElementById('deleteBtn').style.display = 'inline-block';
        
        document.getElementById('userModal').classList.add('show');
    }

    function openAddUserModal() {
        isEditMode = false;
        currentUserId = null;
        
        document.getElementById('userForm').reset();
        document.getElementById('action').value = 'add';
        document.getElementById('user_id').value = '';
        
        // Make password required for add mode
        document.getElementById('userPassword').setAttribute('required', 'required');
        document.getElementById('passwordNote').textContent = 'Minimum 6 characters required';
        
        document.getElementById('modalTitle').textContent = 'Add User';
        document.getElementById('submitBtn').textContent = 'Add';
        document.getElementById('deleteBtn').style.display = 'none';
        
        document.getElementById('userModal').classList.add('show');
    }

    function closeUserModal() {
        document.getElementById('userModal').classList.remove('show');
        document.getElementById('userForm').reset();
        document.getElementById('passwordError').classList.remove('show');
        currentUserId = null;
        isEditMode = false;
    }

    function deleteUser() {
        if (confirm('Are you sure you want to delete this user? This action cannot be undone.')) {
            document.getElementById('delete_user_id').value = currentUserId;
            document.getElementById('deleteForm').submit();
        }
    }

    // Password validation
    document.getElementById('userPassword').addEventListener('input', function() {
        const password = this.value;
        const errorDiv = document.getElementById('passwordError');
        
        // Only validate if password is entered
        if (password.length > 0 && password.length < 6) {
            errorDiv.classList.add('show');
        } else {
            errorDiv.classList.remove('show');
        }
    });

    // Form validation before submit
    document.getElementById('userForm').addEventListener('submit', function(e) {
        const password = document.getElementById('userPassword').value;
        const errorDiv = document.getElementById('passwordError');
        
        // For add mode, password is required
        if (!isEditMode && password.length < 6) {
            e.preventDefault();
            errorDiv.classList.add('show');
            return false;
        }
        
        // For edit mode, only validate if password is provided
        if (isEditMode && password.length > 0 && password.length < 6) {
            e.preventDefault();
            errorDiv.classList.add('show');
            return false;
        }
        
        errorDiv.classList.remove('show');
    });

    // Close modal when clicking outside
    window.addEventListener('click', function(event) {
        const modal = document.getElementById('userModal');
        if (event.target === modal) {
            closeUserModal();
        }
    });
</script>

</body>
</html>