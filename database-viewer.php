<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WordPress Database Viewer</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            margin: 0;
            padding: 20px;
            background: #f1f1f1;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .header {
            background: #0073aa;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .nav {
            background: #f8f9fa;
            padding: 10px 20px;
            border-bottom: 1px solid #dee2e6;
        }
        .nav button {
            background: #0073aa;
            color: white;
            border: none;
            padding: 8px 16px;
            margin: 0 5px;
            border-radius: 4px;
            cursor: pointer;
        }
        .nav button:hover {
            background: #005a87;
        }
        .nav button.active {
            background: #005a87;
        }
        .content {
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background: #f8f9fa;
            font-weight: 600;
        }
        tr:hover {
            background: #f5f5f5;
        }
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }
        .stat-card {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 6px;
            text-align: center;
        }
        .stat-number {
            font-size: 2em;
            font-weight: bold;
            color: #0073aa;
        }
        .stat-label {
            color: #666;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🗄️ WordPress Database Viewer</h1>
            <p>Database: wordpress_db | User: wp_user</p>
        </div>
        
        <div class="nav">
            <button onclick="showTable('overview')" class="active" id="btn-overview">📊 Overview</button>
            <button onclick="showTable('posts')" id="btn-posts">📝 Posts</button>
            <button onclick="showTable('categories')" id="btn-categories">🏷️ Categories</button>
            <button onclick="showTable('users')" id="btn-users">👤 Users</button>
            <button onclick="showTable('options')" id="btn-options">⚙️ Options</button>
        </div>
        
        <div class="content" id="content">
            <!-- Content will be loaded here -->
        </div>
    </div>

    <script>
        function showTable(table) {
            // Remove active class from all buttons
            document.querySelectorAll('.nav button').forEach(btn => btn.classList.remove('active'));
            // Add active class to clicked button
            document.getElementById('btn-' + table).classList.add('active');
            
            // Load content
            fetch('?table=' + table)
                .then(response => response.text())
                .then(html => {
                    document.getElementById('content').innerHTML = html;
                });
        }
        
        // Load overview by default
        if (!window.location.search) {
            showTable('overview');
        }
    </script>
</body>
</html>

<?php
if (isset($_GET['table'])) {
    $table = $_GET['table'];
    
    // Database connection
    $host = 'localhost';
    $dbname = 'wordpress_db';
    $username = 'wp_user';
    $password = 'wp_password123';
    
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        switch ($table) {
            case 'overview':
                echo "<div class='stats'>";
                
                // Posts count
                $stmt = $pdo->query("SELECT COUNT(*) FROM wp_posts WHERE post_status = 'publish' AND post_type = 'post'");
                $posts_count = $stmt->fetchColumn();
                echo "<div class='stat-card'><div class='stat-number'>$posts_count</div><div class='stat-label'>Published Posts</div></div>";
                
                // Pages count
                $stmt = $pdo->query("SELECT COUNT(*) FROM wp_posts WHERE post_status = 'publish' AND post_type = 'page'");
                $pages_count = $stmt->fetchColumn();
                echo "<div class='stat-card'><div class='stat-number'>$pages_count</div><div class='stat-label'>Pages</div></div>";
                
                // Categories count
                $stmt = $pdo->query("SELECT COUNT(*) FROM wp_terms t JOIN wp_term_taxonomy tt ON t.term_id = tt.term_id WHERE tt.taxonomy = 'category'");
                $categories_count = $stmt->fetchColumn();
                echo "<div class='stat-card'><div class='stat-number'>$categories_count</div><div class='stat-label'>Categories</div></div>";
                
                // Users count
                $stmt = $pdo->query("SELECT COUNT(*) FROM wp_users");
                $users_count = $stmt->fetchColumn();
                echo "<div class='stat-card'><div class='stat-number'>$users_count</div><div class='stat-label'>Users</div></div>";
                
                echo "</div>";
                
                // Tables overview
                echo "<h3>📋 Database Tables</h3>";
                echo "<table>";
                echo "<tr><th>Table Name</th><th>Rows</th><th>Size (KB)</th></tr>";
                
                $stmt = $pdo->query("SELECT table_name, table_rows, ROUND(((data_length + index_length) / 1024), 2) AS size_kb FROM information_schema.tables WHERE table_schema = 'wordpress_db' ORDER BY (data_length + index_length) DESC");
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['table_name']) . "</td>";
                    echo "<td>" . number_format($row['table_rows']) . "</td>";
                    echo "<td>" . $row['size_kb'] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                break;
                
            case 'posts':
                echo "<h3>📝 Posts & Pages</h3>";
                echo "<table>";
                echo "<tr><th>ID</th><th>Title</th><th>Type</th><th>Status</th><th>Date</th></tr>";
                
                $stmt = $pdo->query("SELECT ID, post_title, post_type, post_status, post_date FROM wp_posts WHERE post_type IN ('post', 'page') ORDER BY post_date DESC");
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>" . $row['ID'] . "</td>";
                    echo "<td>" . htmlspecialchars($row['post_title']) . "</td>";
                    echo "<td>" . $row['post_type'] . "</td>";
                    echo "<td>" . $row['post_status'] . "</td>";
                    echo "<td>" . date('Y-m-d H:i', strtotime($row['post_date'])) . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                break;
                
            case 'categories':
                echo "<h3>🏷️ Categories & Terms</h3>";
                echo "<table>";
                echo "<tr><th>ID</th><th>Name</th><th>Slug</th><th>Taxonomy</th><th>Count</th></tr>";
                
                $stmt = $pdo->query("SELECT t.term_id, t.name, t.slug, tt.taxonomy, tt.count FROM wp_terms t JOIN wp_term_taxonomy tt ON t.term_id = tt.term_id ORDER BY tt.count DESC");
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>" . $row['term_id'] . "</td>";
                    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['slug']) . "</td>";
                    echo "<td>" . $row['taxonomy'] . "</td>";
                    echo "<td>" . $row['count'] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                break;
                
            case 'users':
                echo "<h3>👤 Users</h3>";
                echo "<table>";
                echo "<tr><th>ID</th><th>Login</th><th>Email</th><th>Display Name</th><th>Registered</th></tr>";
                
                $stmt = $pdo->query("SELECT ID, user_login, user_email, display_name, user_registered FROM wp_users ORDER BY user_registered DESC");
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>" . $row['ID'] . "</td>";
                    echo "<td>" . htmlspecialchars($row['user_login']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['user_email']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['display_name']) . "</td>";
                    echo "<td>" . date('Y-m-d H:i', strtotime($row['user_registered'])) . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                break;
                
            case 'options':
                echo "<h3>⚙️ WordPress Options</h3>";
                echo "<table>";
                echo "<tr><th>Option Name</th><th>Option Value</th></tr>";
                
                $important_options = ['siteurl', 'home', 'blogname', 'blogdescription', 'permalink_structure', 'category_base', 'active_plugins', 'current_theme'];
                $stmt = $pdo->prepare("SELECT option_name, option_value FROM wp_options WHERE option_name IN ('" . implode("','", $important_options) . "') ORDER BY option_name");
                $stmt->execute();
                
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['option_name']) . "</td>";
                    $value = $row['option_value'];
                    if (strlen($value) > 100) {
                        $value = substr($value, 0, 100) . '...';
                    }
                    echo "<td>" . htmlspecialchars($value) . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                break;
        }
        
    } catch (PDOException $e) {
        echo "<div style='color: red; padding: 20px; background: #fee; border-radius: 4px;'>";
        echo "<strong>Database Connection Error:</strong><br>";
        echo htmlspecialchars($e->getMessage());
        echo "</div>";
    }
    
    exit; // Stop here for AJAX requests
}
?>
