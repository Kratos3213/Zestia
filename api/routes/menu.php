<?php
/**
 * Menu Routes
 * GET /api/menu - Get all menu items
 * GET /api/menu/category/{category} - Get items by category
 * GET /api/menu/{id} - Get single menu item
 */

global $conn;

$id = isset($request_parts[2]) ? $request_parts[2] : '';
$action = isset($request_parts[2]) && !is_numeric($request_parts[2]) ? $request_parts[2] : '';

if ($method !== 'GET') {
    error('Method not allowed', 405);
}

if ($action === 'category') {
    $category = isset($request_parts[3]) ? $request_parts[3] : '';
    
    if (!$category) {
        error('Category required');
    }
    
    $result = $conn->query("SELECT * FROM menu_items WHERE category = '$category' AND status = 1");
    $items = [];
    
    while ($row = $result->fetch_assoc()) {
        $items[] = $row;
    }
    
    response([
        'success' => true,
        'data' => $items
    ]);
} elseif ($id && is_numeric($id)) {
    $result = $conn->query("SELECT * FROM menu_items WHERE id = $id");
    
    if ($result->num_rows === 0) {
        error('Menu item not found', 404);
    }
    
    response([
        'success' => true,
        'data' => $result->fetch_assoc()
    ]);
} else {
    // Get all items
    $result = $conn->query("SELECT * FROM menu_items WHERE status = 1");
    $items = [];
    
    while ($row = $result->fetch_assoc()) {
        $items[] = $row;
    }
    
    response([
        'success' => true,
        'data' => $items
    ]);
}
?>
