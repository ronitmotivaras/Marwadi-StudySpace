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
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
    }

    .doubt-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
    }

    .doubt-content {
        flex: 1;
        min-width: 0;
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

    .doubt-stats {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 8px;
        min-width: 120px;
        padding-left: 20px;
        border-left: 1px solid #e0e0e0;
    }

    .stat-item {
        display: flex;
        align-items: center;
        gap: 6px;
        color: #666;
        font-size: 14px;
        font-weight: 500;
    }

    .stat-item span {
        color: #4a90e2;
        font-weight: 600;
    }

    .stat-icon {
        font-size: 16px;
    }

    @media (max-width: 768px) {
        .sidebar {
            width: 200px;
        }

        .main-content {
            padding: 20px;
        }

        .doubt-box {
            flex-direction: column;
            align-items: flex-start;
        }

        .doubt-stats {
            flex-direction: row;
            justify-content: space-around;
            width: 100%;
            padding-left: 0;
            padding-top: 15px;
            border-left: none;
            border-top: 1px solid #e0e0e0;
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
            <div class="doubts-grid">
                <div class="doubt-box" onclick="window.location.href='chats.php?id=1'">
                    <div class="doubt-content">
                        <h3>What is the difference between SQL and NoSQL databases?</h3>
                        <p>I'm learning about databases and I'm confused about when to use SQL vs NoSQL. Can someone explain the key differences and use cases?</p>
                    </div>
                    <div class="doubt-stats">
                        <div class="stat-item">
                            <span class="stat-icon">👁️</span>
                            <span>27</span>
                            <span>views</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-icon">💬</span>
                            <span>4</span>
                            <span>answers</span>
                        </div>
                    </div>
                </div>
                <div class="doubt-box" onclick="window.location.href='chats.php?id=2'">
                    <div class="doubt-content">
                        <h3>How does JavaScript closure work?</h3>
                        <p>I'm having trouble understanding closures in JavaScript. Can someone provide a simple example and explanation?</p>
                    </div>
                    <div class="doubt-stats">
                        <div class="stat-item">
                            <span class="stat-icon">👁️</span>
                            <span>16</span>
                            <span>views</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-icon">💬</span>
                            <span>2</span>
                            <span>answers</span>
                        </div>
                    </div>
                </div>
                <div class="doubt-box" onclick="window.location.href='chats.php?id=3'">
                    <div class="doubt-content">
                        <h3>What is the time complexity of quicksort algorithm?</h3>
                        <p>I need to understand the time complexity analysis of quicksort. What is the best case, average case, and worst case scenario?</p>
                    </div>
                    <div class="doubt-stats">
                        <div class="stat-item">
                            <span class="stat-icon">👁️</span>
                            <span>44</span>
                            <span>views</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-icon">💬</span>
                            <span>1</span>
                            <span>answers</span>
                        </div>
                    </div>
                </div>
                <div class="doubt-box" onclick="window.location.href='chats.php?id=4'">
                    <div class="doubt-content">
                        <h3>How to implement authentication in PHP?</h3>
                        <p>I'm building a web application and need to implement user authentication. What are the best practices for secure login in PHP?</p>
                    </div>
                    <div class="doubt-stats">
                        <div class="stat-item">
                            <span class="stat-icon">👁️</span>
                            <span>50k</span>
                            <span>views</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-icon">💬</span>
                            <span>5</span>
                            <span>answers</span>
                        </div>
                    </div>
                </div>
                <div class="doubt-box" onclick="window.location.href='chats.php?id=5'">
                    <div class="doubt-content">
                        <h3>What is REST API and how does it work?</h3>
                        <p>Can someone explain REST API concepts, HTTP methods, and how to design a RESTful API?</p>
                    </div>
                    <div class="doubt-stats">
                        <div class="stat-item">
                            <span class="stat-icon">👁️</span>
                            <span>32</span>
                            <span>views</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-icon">💬</span>
                            <span>3</span>
                            <span>answers</span>
                        </div>
                    </div>
                </div>
                <div class="doubt-box" onclick="window.location.href='chats.php?id=6'">
                    <div class="doubt-content">
                        <h3>Difference between let, const, and var in JavaScript?</h3>
                        <p>I'm confused about variable declarations in JavaScript. What are the differences between let, const, and var?</p>
                    </div>
                    <div class="doubt-stats">
                        <div class="stat-item">
                            <span class="stat-icon">👁️</span>
                            <span>28</span>
                            <span>views</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-icon">💬</span>
                            <span>2</span>
                            <span>answers</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>