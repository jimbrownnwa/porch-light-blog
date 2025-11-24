<?php
// Router for PHP built-in server
$uri = $_SERVER['REQUEST_URI'];
$path = parse_url($uri, PHP_URL_PATH);

// Serve static files directly
if (preg_match('/\.(?:css|js|png|jpg|jpeg|gif|ico|svg)$/', $path)) {
    return false;
}

// Route to appropriate PHP file
if ($path === '/' || $path === '/index.php') {
    require __DIR__ . '/index.php';
} elseif ($path === '/generate.php') {
    require __DIR__ . '/generate.php';
} elseif ($path === '/post.php') {
    require __DIR__ . '/post.php';
} else {
    // 404 for unknown routes
    http_response_code(404);
    echo 'Not Found';
}
