<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Routing
$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$request_parts = array_filter(explode('/', $request_uri));

// Remove 'taaza', 'api' from path
$request_parts = array_values($request_parts);
if (count($request_parts) >= 2 && $request_parts[count($request_parts) - 2] === 'api') {
    array_pop($request_parts);
    array_pop($request_parts);
}

$endpoint = isset($request_parts[0]) ? $request_parts[0] : '';
$method = $_SERVER['REQUEST_METHOD'];

// Include required files
require_once __DIR__ . '/../includes/connection.php';

// Response helper
function response($data, $status = 200) {
    http_response_code($status);
    echo json_encode($data);
    exit();
}

// Error response
function error($message, $status = 400) {
    response(['error' => $message], $status);
}

// Route dispatcher
try {
    switch ($endpoint) {
        case 'auth':
            require_once __DIR__ . '/routes/auth.php';
            break;
        case 'menu':
            require_once __DIR__ . '/routes/menu.php';
            break;
        case 'cart':
            require_once __DIR__ . '/routes/cart.php';
            break;
        case 'orders':
            require_once __DIR__ . '/routes/orders.php';
            break;
        case 'bookings':
            require_once __DIR__ . '/routes/bookings.php';
            break;
        case 'user':
            require_once __DIR__ . '/routes/user.php';
            break;
        case 'vip':
            require_once __DIR__ . '/routes/vip.php';
            break;
        default:
            error('Invalid endpoint', 404);
    }
} catch (Exception $e) {
    error($e->getMessage(), 500);
}
?>
