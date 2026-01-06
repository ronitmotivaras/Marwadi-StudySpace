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
        padding: 40px 30px;
        max-width: 1200px;
        margin: 0 auto;
        min-height: calc(100vh - 80px);
        flex: 1;
    }

    .page-title {
        font-size: 32px;
        color: #333;
        margin-bottom: 30px;
    }

    .bookmarks-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 20px;
    }

    .bookmark-box {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        cursor: pointer;
        border-left: 4px solid #f39c12;
    }

    .bookmark-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
    }

    .bookmark-box h3 {
        color: #333;
        font-size: 18px;
        margin-bottom: 10px;
        line-height: 1.4;
    }

    .bookmark-box p {
        color: #666;
        font-size: 14px;
        line-height: 1.6;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #999;
        grid-column: 1 / -1;
    }

    .empty-state h2 {
        font-size: 24px;
        margin-bottom: 10px;
        color: #666;
    }

    .empty-state p {
        font-size: 16px;
    }

    @media (max-width: 768px) {
        .sidebar {
            width: 200px;
        }

        .main-content {
            padding: 20px;
        }

        .page-title {
            font-size: 24px;
        }

        .bookmarks-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="main-layout">
    <div class="sidebar">
        <ul class="sidebar-menu">
            <li><a href="Dashboard.php">Dashboard</a></li>
            <li><a href="bookmarks.php" class="active">Bookmarks</a></li>
        </ul>
    </div>

    <div class="content-wrapper">
        <div class="main-content">
            <h1 class="page-title">My Bookmarks</h1>
            <div class="bookmarks-grid" id="bookmarksGrid">
                <div class="empty-state">
                    <h2>No bookmarks yet</h2>
                    <p>Bookmark questions you find helpful to access them later</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // This will be populated dynamically from database
    // For now, showing empty state
    // You can add bookmarked items here when implementing backend
</script>

</body>
</html>