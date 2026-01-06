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

    .sidebar-icon {
        font-size: 20px;
        width: 24px;
        text-align: center;
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

    .doubt-section {
        background: #f8f9fb;
        color: #333;
        padding: 25px;
        border-radius: 10px;
        margin-bottom: 25px;
        position: relative;
        border: 1px solid #e0e0e0;
    }

    .doubt-header {
        margin-bottom: 15px;
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

    .error-message {
        background: #fee;
        color: #c33;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
        border-left: 4px solid #c33;
        display: none;
    }

    .error-message.show {
        display: block;
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
    }

    .answer-actions {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-top: 15px;
        padding-top: 15px;
        border-top: 1px solid #e0e0e0;
    }

    .like-section {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .like-button {
        background: transparent;
        border: none;
        cursor: pointer;
        font-size: 28px;
        transition: all 0.3s ease;
        padding: 5px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .like-button:hover {
        transform: scale(1.1);
    }

    .like-button.liked {
        animation: heartBeat 0.6s ease;
    }

    @keyframes heartBeat {
        0% { transform: scale(1); }
        25% { transform: scale(1.3); }
        50% { transform: scale(1); }
        75% { transform: scale(1.2); }
        100% { transform: scale(1); }
    }

    .like-count {
        color: #666;
        font-size: 16px;
        font-weight: 500;
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

    .comment-actions {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .comment-like-btn {
        background: transparent;
        border: none;
        cursor: pointer;
        font-size: 20px;
        transition: all 0.3s ease;
        padding: 5px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .comment-like-btn:hover {
        transform: scale(1.1);
    }

    .comment-like-count {
        color: #666;
        font-size: 14px;
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

        .doubt-header {
            flex-direction: column;
            gap: 15px;
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
            <div class="error-message" id="errorMessage">
                Error: Could not navigate back to dashboard. Please try again.
            </div>
            <div class="doubt-section">
                <div class="doubt-header">
                    <div class="doubt-title" id="doubtTitle">What is the difference between SQL and NoSQL databases?</div>
                </div>
                <div class="doubt-description" id="doubtDescription">
                    I'm learning about databases and I'm confused about when to use SQL vs NoSQL. Can someone explain the key differences and use cases?
                </div>
                <div class="doubt-actions">
                    <button class="add-answer-btn" onclick="showAnswerForm()">
                        ➕ Add Answer
                    </button>
                    <button class="bookmark-btn" id="bookmarkBtn" onclick="toggleBookmark()">🔖 Bookmark</button>
                </div>
            </div>

            <div class="add-answer-form" id="addAnswerForm">
                <h3>Your Answer</h3>
                <textarea class="answer-textarea" id="newAnswerText" placeholder="Write your answer here..."></textarea>
                <div class="answer-form-actions">
                    <button class="submit-answer-btn" onclick="submitAnswer()">Submit Answer</button>
                    <button class="cancel-answer-btn" onclick="hideAnswerForm()">Cancel</button>
                </div>
            </div>

            <div class="answers-container" id="answersContainer">
                <!-- Answers will be dynamically generated here -->
            </div>
        </div>
    </div>
</div>

<script>
    // Static data for different doubts with multiple answers
    const doubtsData = {
        1: {
            title: "What is the difference between SQL and NoSQL databases?",
            description: "I'm learning about databases and I'm confused about when to use SQL vs NoSQL. Can someone explain the key differences and use cases?",
            answers: [
                {
                    user: "John Doe",
                    content: "SQL (Structured Query Language) databases are relational databases that use tables with predefined schemas. They are best for structured data and complex queries. Examples include MySQL, PostgreSQL, and SQL Server.\n\nNoSQL databases are non-relational and can handle unstructured data. They are more flexible and scalable for large amounts of data. Types include document databases (MongoDB), key-value stores (Redis), and graph databases (Neo4j).\n\nUse SQL when you need ACID compliance, complex queries, and structured data. Use NoSQL for scalability, flexibility, and when dealing with large volumes of unstructured data.",
                    likes: 5,
                    isLiked: false,
                    isWrong: false,
                    comments: []
                },
                {
                    user: "Sarah Smith",
                    content: "I'd like to add that SQL databases are better for transactional applications where data consistency is critical, while NoSQL is great for real-time analytics and big data applications.",
                    likes: 3,
                    isLiked: false,
                    isWrong: false,
                    comments: []
                },
                {
                    user: "Mike Johnson",
                    content: "Actually, I think NoSQL is always better. SQL is outdated.",
                    likes: 0,
                    isLiked: false,
                    isWrong: true,
                    comments: [
                        {
                            user: "Expert User",
                            content: "That's not accurate. Both have their use cases. SQL is still widely used and preferred for many applications.",
                            likes: 2,
                            isLiked: false
                        }
                    ]
                }
            ]
        },
        2: {
            title: "How does JavaScript closure work?",
            description: "I'm having trouble understanding closures in JavaScript. Can someone provide a simple example and explanation?",
            answers: [
                {
                    user: "Alex Chen",
                    content: "A closure is a function that has access to variables in its outer (enclosing) lexical scope, even after the outer function has returned. Closures are created every time a function is created.\n\nExample:\n\nfunction outerFunction(x) {\n  function innerFunction(y) {\n    return x + y;\n  }\n  return innerFunction;\n}\n\nconst addFive = outerFunction(5);\nconsole.log(addFive(3)); // Output: 8\n\nThe inner function 'remembers' the value of x even after outerFunction has finished executing. This is useful for data privacy, function factories, and event handlers.",
                    likes: 8,
                    isLiked: false,
                    isWrong: false,
                    comments: []
                },
                {
                    user: "Emily Davis",
                    content: "Great explanation! Closures are also essential for creating private variables in JavaScript since JavaScript doesn't have native private members.",
                    likes: 4,
                    isLiked: false,
                    isWrong: false,
                    comments: []
                }
            ]
        },
        3: {
            title: "What is the time complexity of quicksort algorithm?",
            description: "I need to understand the time complexity analysis of quicksort. What is the best case, average case, and worst case scenario?",
            answers: [
                {
                    user: "Dr. Robert Lee",
                    content: "QuickSort has the following time complexities:\n\nBest Case: O(n log n) - When the pivot divides the array into two equal halves\nAverage Case: O(n log n) - On average, the pivot divides the array reasonably well\nWorst Case: O(n²) - When the pivot is always the smallest or largest element\n\nThe space complexity is O(log n) for the recursive call stack in the average case, and O(n) in the worst case.\n\nQuickSort is generally faster in practice than other O(n log n) algorithms due to its efficient inner loop and good cache performance.",
                    likes: 12,
                    isLiked: false,
                    isWrong: false,
                    comments: []
                }
            ]
        },
        4: {
            title: "How to implement authentication in PHP?",
            description: "I'm building a web application and need to implement user authentication. What are the best practices for secure login in PHP?",
            answers: [
                {
                    user: "Security Expert",
                    content: "Here are best practices for PHP authentication:\n\n1. Use password_hash() and password_verify() for password hashing (never store plain text)\n2. Use prepared statements with PDO or MySQLi to prevent SQL injection\n3. Implement session management securely (use session_regenerate_id() after login)\n4. Use HTTPS to encrypt data transmission\n5. Implement CSRF protection tokens\n6. Set secure session cookie parameters\n7. Validate and sanitize all user inputs\n8. Implement rate limiting to prevent brute force attacks\n9. Use two-factor authentication (2FA) for sensitive applications\n10. Store sessions securely (consider using database storage for sessions)",
                    likes: 15,
                    isLiked: false,
                    isWrong: false,
                    comments: []
                }
            ]
        },
        5: {
            title: "What is REST API and how does it work?",
            description: "Can someone explain REST API concepts, HTTP methods, and how to design a RESTful API?",
            answers: [
                {
                    user: "API Developer",
                    content: "REST (Representational State Transfer) is an architectural style for designing web services.\n\nKey principles:\n1. Stateless - Each request contains all information needed\n2. Client-Server architecture\n3. Uniform interface using HTTP methods\n4. Resource-based URLs\n\nHTTP Methods:\n- GET: Retrieve data\n- POST: Create new resource\n- PUT: Update entire resource\n- PATCH: Partial update\n- DELETE: Remove resource\n\nRESTful API design:\n- Use nouns for resources: /users, /posts\n- Use HTTP methods for actions\n- Return appropriate status codes (200, 201, 404, 500)\n- Use JSON for data exchange\n- Version your API: /api/v1/users",
                    likes: 10,
                    isLiked: false,
                    isWrong: false,
                    comments: []
                }
            ]
        },
        6: {
            title: "Difference between let, const, and var in JavaScript?",
            description: "I'm confused about variable declarations in JavaScript. What are the differences between let, const, and var?",
            answers: [
                {
                    user: "JS Mentor",
                    content: "Key differences:\n\nVAR:\n- Function-scoped or globally-scoped\n- Can be redeclared and reassigned\n- Hoisted (initialized as undefined)\n- Can be used before declaration\n\nLET:\n- Block-scoped (enclosed in {})\n- Cannot be redeclared in same scope\n- Can be reassigned\n- Hoisted but not initialized (Temporal Dead Zone)\n- Must be declared before use\n\nCONST:\n- Block-scoped\n- Cannot be redeclared or reassigned\n- Must be initialized at declaration\n- Hoisted but not initialized (Temporal Dead Zone)\n- For objects/arrays, the reference is constant but properties can change\n\nBest practice: Use const by default, let when you need to reassign, avoid var.",
                    likes: 7,
                    isLiked: false,
                    isWrong: false,
                    comments: []
                }
            ]
        }
    };

    let isBookmarked = false;
    let currentAnswers = [];

    // Get doubt ID from URL
    const urlParams = new URLSearchParams(window.location.search);
    const doubtId = urlParams.get('id') || '1';
    
    // Load doubt data
    if (doubtsData[doubtId]) {
        document.getElementById('doubtTitle').textContent = doubtsData[doubtId].title;
        document.getElementById('doubtDescription').textContent = doubtsData[doubtId].description;
        currentAnswers = JSON.parse(JSON.stringify(doubtsData[doubtId].answers)); // Deep copy
        renderAnswers();
    }

    function renderAnswers() {
        const container = document.getElementById('answersContainer');
        container.innerHTML = '';
        
        currentAnswers.forEach((answer, answerIndex) => {
            const answerDiv = document.createElement('div');
            answerDiv.className = 'answer-section';
            
            answerDiv.innerHTML = `
                <div class="answer-header">
                    <h3>Answer ${answerIndex + 1}</h3>
                </div>
                <div class="answer-user">By: ${answer.user}</div>
                <div class="answer-content">${answer.content.replace(/\n/g, '<br>')}</div>
                <div class="answer-actions">
                    <div class="like-section">
                        <button class="like-button ${answer.isLiked ? 'liked' : ''}" onclick="toggleAnswerLike(${answerIndex})">
                            ${answer.isLiked ? '❤️' : '🤍'}
                        </button>
                        <span class="like-count">${answer.likes} ${answer.likes === 1 ? 'like' : 'likes'}</span>
                    </div>
                </div>
                <div class="comment-section">
                    <div class="comment-form">
                        <textarea class="comment-input" id="commentInput${answerIndex}" placeholder="Add a comment..."></textarea>
                        <button class="comment-submit-btn" onclick="addComment(${answerIndex})">Post Comment</button>
                    </div>
                    ${answer.comments && answer.comments.length > 0 ? `
                        <div class="comments-list" id="commentsList${answerIndex}">
                            ${renderComments(answer.comments, answerIndex)}
                        </div>
                    ` : ''}
                </div>
            `;
            
            container.appendChild(answerDiv);
        });
    }

    function renderComments(comments, answerIndex) {
        if (comments.length === 0) return '';
        return comments.map((comment, commentIndex) => `
            <div class="comment-item">
                <div class="comment-header">
                    <div class="comment-user">${comment.user}</div>
                </div>
                <div class="comment-content">${comment.content}</div>
                <div class="comment-actions">
                    <button class="comment-like-btn ${comment.isLiked ? 'liked' : ''}" onclick="toggleCommentLike(${answerIndex}, ${commentIndex})">
                        ${comment.isLiked ? '❤️' : '🤍'}
                    </button>
                    <span class="comment-like-count">${comment.likes}</span>
                </div>
            </div>
        `).join('');
    }

    function toggleAnswerLike(answerIndex) {
        const answer = currentAnswers[answerIndex];
        if (answer.isLiked) {
            answer.isLiked = false;
            answer.likes--;
        } else {
            answer.isLiked = true;
            answer.likes++;
        }
        renderAnswers();
    }

    function showAnswerForm() {
        document.getElementById('addAnswerForm').classList.add('show');
        document.getElementById('newAnswerText').focus();
    }

    function hideAnswerForm() {
        document.getElementById('addAnswerForm').classList.remove('show');
        document.getElementById('newAnswerText').value = '';
    }

    function submitAnswer() {
        const answerText = document.getElementById('newAnswerText').value.trim();
        
        if (answerText) {
            currentAnswers.push({
                user: 'Current User',
                content: answerText,
                likes: 0,
                isLiked: false,
                isWrong: false,
                comments: []
            });
            hideAnswerForm();
            renderAnswers();
        } else {
            alert('Please enter an answer before submitting.');
        }
    }

    function addComment(answerIndex) {
        const input = document.getElementById(`commentInput${answerIndex}`);
        const commentText = input.value.trim();
        
        if (commentText) {
            const answer = currentAnswers[answerIndex];
            if (!answer.comments) {
                answer.comments = [];
            }
            answer.comments.push({
                user: 'Current User',
                content: commentText,
                likes: 0,
                isLiked: false
            });
            input.value = '';
            renderAnswers();
        }
    }

    function toggleCommentLike(answerIndex, commentIndex) {
        const comment = currentAnswers[answerIndex].comments[commentIndex];
        if (comment.isLiked) {
            comment.isLiked = false;
            comment.likes--;
        } else {
            comment.isLiked = true;
            comment.likes++;
        }
        renderAnswers();
    }

    function toggleBookmark() {
        const bookmarkBtn = document.getElementById('bookmarkBtn');
        
        if (isBookmarked) {
            isBookmarked = false;
            bookmarkBtn.textContent = '🔖 Bookmark';
            bookmarkBtn.classList.remove('bookmarked');
        } else {
            isBookmarked = true;
            bookmarkBtn.textContent = '✓ Bookmarked';
            bookmarkBtn.classList.add('bookmarked');
        }
    }
</script>

</body>
</html>