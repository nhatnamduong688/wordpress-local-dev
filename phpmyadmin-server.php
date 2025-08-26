<?php
// Simple router for phpMyAdmin with PHP built-in server
$request = $_SERVER['REQUEST_URI'];

// Remove query string
$path = parse_url($request, PHP_URL_PATH);

// If it's a phpMyAdmin request, serve from phpMyAdmin directory
if (strpos($path, '/phpmyadmin') === 0) {
    $file = '/usr/local/share/phpmyadmin' . substr($path, 11);
    
    if (is_file($file)) {
        $ext = pathinfo($file, PATHINFO_EXTENSION);
        
        // Set appropriate content type
        switch ($ext) {
            case 'css':
                header('Content-Type: text/css');
                break;
            case 'js':
                header('Content-Type: application/javascript');
                break;
            case 'png':
                header('Content-Type: image/png');
                break;
            case 'jpg':
            case 'jpeg':
                header('Content-Type: image/jpeg');
                break;
            case 'gif':
                header('Content-Type: image/gif');
                break;
            case 'svg':
                header('Content-Type: image/svg+xml');
                break;
            case 'php':
                // Change working directory to phpMyAdmin
                chdir('/usr/local/share/phpmyadmin');
                include $file;
                return;
        }
        
        readfile($file);
        return;
    }
}

// Default WordPress handling
if (file_exists(__DIR__ . $path)) {
    return false; // Let PHP built-in server handle static files
}

// WordPress routing
include __DIR__ . '/index.php';
?>
