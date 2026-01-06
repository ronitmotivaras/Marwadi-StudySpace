<?php 
session_start();

// Check if user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: user_login.php");
    exit;
}

include "config/_dbconnect.php";

$user_id = $_SESSION['user_id'];
$doubt_id = isset($_GET['id']) ? intval($_GET['id']) : 1;

// Handle answer submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
    if ($_POST['action'] == 'add_answer') {
        $answer = mysqli_real_escape_string($conn, $_POST['answer']);
        
        $sql = "INSERT INTO `answer` (doubt_id, user_id, answer) VALUES ('$doubt_id', '$user_id', '$answer')";
        
        if (mysqli_query($conn, $sql)) {
            $success = "Answer added successfully";
        } else {
            $error = "Failed to add answer: " . mysqli_error($conn);
        }
    }
    
    if ($_POST['action'] == 'add_comment') {
        $ans_id = intval($_POST['ans_id']);
        $comment = mysqli_real_escape_string($conn, $_POST['comment']);
        
        $sql = "INSERT INTO `comments` (ans_id, user_id, comment) VALUES ('$ans_id', '$user_id', '$comment')";
        
        if (mysqli_query($conn, $sql)) {
            $success = "Comment added successfully";
        } else {
            $error = "Failed to add comment: " . mysqli_error($conn);
        }
    }
    
    if ($_POST['action'] == 'toggle_bookmark') {
        // Check if already bookmarked
        $check_sql = "SELECT * FROM `bookmarks` WHERE user_id = '$user_id' AND doubt_id = '$doubt_id'";
        $check_result = mysqli_query($conn, $check_sql);
        
        if ($check_result && mysqli_num_rows($check_result) > 0) {
            // Remove bookmark
            $delete_sql = "DELETE FROM `bookmarks` WHERE user_id = '$user_id' AND doubt_id = '$doubt_id'";
            mysqli_query($conn, $delete_sql);
        } else {
            // Add bookmark
            $insert_sql = "INSERT INTO `bookmarks` (user_id, doubt_id) VALUES ('$user_id', '$doubt_id')";
            mysqli_query($conn, $insert_sql);
        }
    }
}

// Fetch question details
$doubt_sql = "SELECT * FROM `doubts` WHERE doubt_id = '$doubt_id'";
$doubt_result = mysqli_query($conn, $doubt_sql);

if (!$doubt_result || mysqli_num_rows($doubt_result) == 0) {
    echo "Question not found. Redirecting...";
    header("refresh:2;url=Dashboard.php");
    exit;
}

$doubt = mysqli_fetch_assoc($doubt_result);

// Check if question is bookmarked
$bookmark_check = "SELECT * FROM `bookmarks` WHERE user_id = '$user_id' AND doubt_id = '$doubt_id'";
$bookmark_result = mysqli_query($conn, $bookmark_check);
$is_bookmarked = ($bookmark_result && mysqli_num_rows($bookmark_result) > 0);

// Fetch all answers with user details
$answers_sql = "SELECT a.*, u.name as user_name FROM `answer` a 
                LEFT JOIN `user` u ON a.user_id = u.user_id 
                WHERE a.doubt_id = '$doubt_id' 
                ORDER BY a.ans_id ASC";
$answers_result = mysqli_query($conn, $answers_sql);

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
        display: flex;
        align-items: center;
        gap: 12px;
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
        padding: 40px 30px;
        max-width: 900px;
        margin: 0 auto;
        min-height: calc(100vh - 80px);
        flex: 1;
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
        margin-bottom: 20px;
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

    .doubt-section {
        background: #f8f9fb;
        color: #333;
        padding: 25px;
        border-radius: 10px;
        margin-bottom: 25px;
        position: relative;
        border: 1px solid #e0e0e0;
    }

    .doubt-title {
        font-size: 24px;
        font-weight: 600;
        line-height: 1.4;
        margin-bottom: 15px;
    }

    .doubt-description {
        font-size: 16px;
        line-height: 1.6;
        color: #666;
        margin-bottom: 20px;
    }

    .doubt-actions {
        display: flex;
        gap: 15px;
        align-items: center;
    }

    .bookmark-btn {
        background: #f39c12;
        border: none;
        color: #ffffff;
        padding: 10px 20px;
        border-radius: 8px;
        cursor: pointer;
        font-size: 16px;
        font-weight: 500;
        transition: all 0.3s ease;
        white-space: nowrap;
    }

    .bookmark-btn:hover {
        background: #e67e22;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(243, 156, 18, 0.3);
    }

    .bookmark-btn.bookmarked {
        background: #28a745;
    }

    .bookmark-btn.bookmarked:hover {
        background: #218838;
    }

    .add-answer-btn {
        background: #28a745;
        color: #ffffff;
        border: none;
        padding: 12px 24px;
        border-radius: 8px;
        cursor: pointer;
        font-size: 16px;
        font-weight: 500;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .add-answer-btn:hover {
        background: #218838;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(40, 167, 69, 0.3);
    }

    .add-answer-form {
        background: #f8f9fa;
        padding: 25px;
        border-radius: 10px;
        margin-bottom: 20px;
        display: none;
    }

    .add-answer-form.show {
        display: block;
    }

    .add-answer-form h3 {
        color: #333;
        font-size: 20px;
        margin-bottom: 15px;
    }

    .answer-textarea {
        width: 100%;
        padding: 15px;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        font-size: 14px;
        font-family: inherit;
        resize: vertical;
        min-height: 150px;
        margin-bottom: 15px;
    }

    .answer-textarea:focus {
        outline: none;
        border-color: #4a90e2;
    }

    .answer-form-actions {
        display: flex;
        gap: 10px;
    }

    .submit-answer-btn {
        background: #4a90e2;
        color: #ffffff;
        border: none;
        padding: 10px 20px;
        border-radius: 6px;
        cursor: pointer;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .submit-answer-btn:hover {
        background: #357abd;
    }

    .cancel-answer-btn {
        background: #6c757d;
        color: #ffffff;
        border: none;
        padding: 10px 20px;
        border-radius: 6px;
        cursor: pointer;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .cancel-answer-btn:hover {
        background: #5a6268;
    }

    .answers-container {
        display: flex;
        flex-direction: column;
        gap: 20px;
        margin-bottom: 20px;
    }

    .answer-section {
        background: #f8f9fa;
        padding: 25px;
        border-radius: 10px;
        margin-bottom: 20px;
    }

    .answer-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .answer-section h3 {
        color: #333;
        font-size: 20px;
        margin-bottom: 0;
    }

    .answer-user {
        color: #4a90e2;
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 10px;
    }

    .answer-content {
        color: #666;
        font-size: 16px;
        line-height: 1.8;
        margin-bottom: 15px;
        white-space: pre-wrap;
    }

    .comment-section {
        margin-top: 20px;
        padding-top: 20px;
        border-top: 2px solid #e0e0e0;
    }

    .comment-form {
        margin-bottom: 20px;
    }

    .comment-input {
        width: 100%;
        padding: 12px;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        font-size: 14px;
        font-family: inherit;
        resize: vertical;
        min-height: 80px;
        margin-bottom: 10px;
    }

    .comment-input:focus {
        outline: none;
        border-color: #4a90e2;
    }

    .comment-submit-btn {
        background: #4a90e2;
        color: #ffffff;
        border: none;
        padding: 10px 20px;
        border-radius: 6px;
        cursor: pointer;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .comment-submit-btn:hover {
        background: #357abd;
    }

    .comments-list {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .comment-item {
        background: #ffffff;
        padding: 15px 15px 15px 30px;
        border-radius: 8px;
        border-left: 3px solid #4a90e2;
        margin-left: 20px;
        margin-bottom: 10px;
    }

    .comment-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 8px;
    }

    .comment-user {
        color: #4a90e2;
        font-size: 14px;
        font-weight: 600;
    }

    .comment-content {
        color: #555;
        font-size: 14px;
        line-height: 1.6;
        margin-bottom: 10px;
    }

    @media (max-width: 768px) {
        .sidebar {
            width: 200px;
        }

        .main-content {
            padding: 20px;
        }

        .doubt-title {
            font-size: 20px;
        }

        .doubt-actions {
            flex-direction: column;
            width: 100%;
        }

        .add-answer-btn,
        .bookmark-btn {
            width: 100%;
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
            <a href="Dashboard.php" class="back-button">← Back</a>

            <?php if (isset($success)): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            
            <?php if (isset($error)): ?>
                <div class="alert alert-error"><?php echo $error; ?></div>
            <?php endif; ?>

            <div class="doubt-section">
                <div class="doubt-title"><?php echo htmlspecialchars($doubt['title']); ?></div>
                <div class="doubt-description"><?php echo htmlspecialchars($doubt['description']); ?></div>
                <div class="doubt-actions">
                    <button class="add-answer-btn" onclick="showAnswerForm()">
                        ➕ Add Answer
                    </button>
                    <form method="POST" action="" id="bookmarkForm" style="display: inline;">
                        <input type="hidden" name="action" value="toggle_bookmark">
                        <button type="submit" class="bookmark-btn <?php echo $is_bookmarked ? 'bookmarked' : ''; ?>" id="bookmarkBtn">
                            <?php echo $is_bookmarked ? '✓ Bookmarked' : '🔖 Bookmark'; ?>
                        </button>
                    </form>
                </div>
            </div>

            <form method="POST" action="" id="addAnswerForm" class="add-answer-form">
                <h3>Your Answer</h3>
                <input type="hidden" name="action" value="add_answer">
                <textarea class="answer-textarea" name="answer" id="newAnswerText" placeholder="Write your answer here..." required></textarea>
                <div class="answer-form-actions">
                    <button type="submit" class="submit-answer-btn">Submit Answer</button>
                    <button type="button" class="cancel-answer-btn" onclick="hideAnswerForm()">Cancel</button>
                </div>
            </form>

            <div class="answers-container">
                <?php 
                if ($answers_result && mysqli_num_rows($answers_result) > 0):
                    $answer_num = 1;
                    while ($answer = mysqli_fetch_assoc($answers_result)): 
                        // Fetch comments for this answer
                        $comments_sql = "SELECT c.*, u.name as user_name FROM `comments` c 
                                        LEFT JOIN `user` u ON c.user_id = u.user_id 
                                        WHERE c.ans_id = '".$answer['ans_id']."' 
                                        ORDER BY c.comment_id ASC";
                        $comments_result = mysqli_query($conn, $comments_sql);
                ?>
                <div class="answer-section">
                    <div class="answer-header">
                        <h3>Answer <?php echo $answer_num++; ?></h3>
                    </div>
                    <div class="answer-user">By: <?php echo htmlspecialchars($answer['user_name']); ?></div>
                    <div class="answer-content"><?php echo nl2br(htmlspecialchars($answer['answer'])); ?></div>
                    
                    <div class="comment-section">
                        <form method="POST" action="" class="comment-form">
                            <input type="hidden" name="action" value="add_comment">
                            <input type="hidden" name="ans_id" value="<?php echo $answer['ans_id']; ?>">
                            <textarea class="comment-input" name="comment" placeholder="Add a comment..." required></textarea>
                            <button type="submit" class="comment-submit-btn">Post Comment</button>
                        </form>
                        
                        <?php if ($comments_result && mysqli_num_rows($comments_result) > 0): ?>
                        <div class="comments-list">
                            <?php while ($comment = mysqli_fetch_assoc($comments_result)): ?>
                            <div class="comment-item">
                                <div class="comment-header">
                                    <div class="comment-user"><?php echo htmlspecialchars($comment['user_name']); ?></div>
                                </div>
                                <div class="comment-content"><?php echo htmlspecialchars($comment['comment']); ?></div>
                            </div>
                            <?php endwhile; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php 
                    endwhile;
                else:
                ?>
                <div class="answer-section">
                    <p style="text-align: center; color: #666;">No answers yet. Be the first to answer!</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
    function showAnswerForm() {
        document.getElementById('addAnswerForm').classList.add('show');
        document.getElementById('newAnswerText').focus();
    }

    function hideAnswerForm() {
        document.getElementById('addAnswerForm').classList.remove('show');
        document.getElementById('newAnswerText').value = '';
    }
</script>

</body>
</html>