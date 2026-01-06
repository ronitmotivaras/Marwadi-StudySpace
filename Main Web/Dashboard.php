<?php 
session_start();

// Check if user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: user_login.php");
    exit;
}

include "config/_dbconnect.php";

$user_id = $_SESSION['user_id'];

// Handle add question submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
    if ($_POST['action'] == 'add_question') {
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $description = mysqli_real_escape_string($conn, $_POST['description']);
        
        $sql = "INSERT INTO `doubts` (user_id, title, description) VALUES ('$user_id', '$title', '$description')";
        
        if (mysqli_query($conn, $sql)) {
            $success = "Question added successfully";
        } else {
            $error = "Failed to add question: " . mysqli_error($conn);
        }
    }
}

// Fetch all questions from database
$sql = "SELECT * FROM `doubts` ORDER BY doubt_id DESC";
$doubts_result = mysqli_query($conn, $sql);

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
        margin: 0 auto;
        min-height: calc(100vh - 80px);
        flex: 1;
        width: 100%;
    }

    .page-header {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        margin-bottom: 30px;
    }

    .add-question-btn {
        background: linear-gradient(135deg, #4a90e2 0%, #357abd 100%);
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 8px;
        cursor: pointer;
        font-size: 15px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .add-question-btn:hover {
        background: linear-gradient(135deg, #357abd 0%, #2a5f8f 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(74, 144, 226, 0.3);
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

    .doubts-grid {
        display: flex;
        flex-direction: column;
        gap: 20px;
        margin-top: 20px;
    }

    .doubt-box {
        background: #f8f9fb;
        padding: 20px;
        border-radius: 15px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        cursor: pointer;
        border-left: 4px solid #4a90e2;
    }

    .doubt-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
    }

    .doubt-box h3 {
        color: #333;
        font-size: 18px;
        margin-bottom: 10px;
        line-height: 1.4;
    }

    .doubt-box p {
        color: #666;
        font-size: 14px;
        line-height: 1.6;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
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
        max-width: 600px;
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

    .form-group input,
    .form-group textarea {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #e0e0e0;
        border-radius: 6px;
        font-size: 14px;
        transition: all 0.3s ease;
        font-family: inherit;
    }

    .form-group textarea {
        resize: vertical;
        min-height: 120px;
    }

    .form-group input:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #4a90e2;
        box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.2);
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
    }
</style>

<div class="main-layout">
    <div class="sidebar">
        <ul class="sidebar-menu">
            <li><a href="Dashboard.php" class="active">Dashboard</a></li>
            <li><a href="bookmarks.php">Bookmarks</a></li>
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
                <button class="add-question-btn" onclick="openAddQuestionModal()">➕ Add Question</button>
            </div>

            <div class="doubts-grid">
                <?php while ($doubt = mysqli_fetch_assoc($doubts_result)): ?>
                <div class="doubt-box" onclick="window.location.href='chats.php?id=<?php echo $doubt['doubt_id']; ?>'">
                    <h3><?php echo htmlspecialchars($doubt['title']); ?></h3>
                    <p><?php echo htmlspecialchars($doubt['description']); ?></p>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</div>

<!-- Add Question Modal -->
<div class="modal" id="questionModal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Add New Question</h2>
        </div>
        <form method="POST" action="Dashboard.php">
            <input type="hidden" name="action" value="add_question">
            
            <div class="form-group">
                <label for="questionTitle">Title</label>
                <input type="text" id="questionTitle" name="title" placeholder="Enter your question title" required>
            </div>
            
            <div class="form-group">
                <label for="questionDescription">Description</label>
                <textarea id="questionDescription" name="description" placeholder="Describe your question in detail..." required></textarea>
            </div>
            
            <div class="modal-buttons">
                <button type="button" class="btn btn-secondary" onclick="closeQuestionModal()">Cancel</button>
                <button type="submit" class="btn btn-primary">Submit Question</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openAddQuestionModal() {
        document.getElementById('questionModal').classList.add('show');
        document.getElementById('questionTitle').focus();
    }

    function closeQuestionModal() {
        document.getElementById('questionModal').classList.remove('show');
        document.getElementById('questionTitle').value = '';
        document.getElementById('questionDescription').value = '';
    }

    // Close modal when clicking outside
    window.addEventListener('click', function(event) {
        const modal = document.getElementById('questionModal');
        if (event.target === modal) {
            closeQuestionModal();
        }
    });
</script>

</body>
</html>