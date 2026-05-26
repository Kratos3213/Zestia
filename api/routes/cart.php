<?php
/**
 * Cart Routes (Session-based for client-side cart)
 * Note: Cart is managed in the frontend using React Context API
 * These endpoints are provided for server-side validation
 */

global $conn;

$action = isset($request_parts[2]) ? $request_parts[2] : '';

switch ($action) {
    case 'validate':
        if ($method !== 'POST') {
            error('Method not allowed', 405);
        }
        
        // Validate cart items
        $items = $input['items'] ?? [];
        $validatedItems = [];
        
        foreach ($items as $item) {
            $item_id = intval($item['id']);
            $quantity = intval($item['quantity']);
            
            $result = $conn->query("SELECT id, price, stock FROM menu_items WHERE id = $item_id");
            
            if ($result->num_rows === 0) {
                error('Item ' . $item_id . ' not found', 404);
            }
            
            $dbItem = $result->fetch_assoc();
            
            if ($quantity > $dbItem['stock']) {
                error('Item ' . $item_id . ' is out of stock');
            }
            
            $validatedItems[] = [
                'id' => $item_id,
                'price' => floatval($dbItem['price']),
                'quantity' => $quantity
            ];
        }
        
        response([
            'success' => true,
            'data' => $validatedItems
        ]);
        break;
    
    default:
        error('Invalid action', 404);
}
?>
