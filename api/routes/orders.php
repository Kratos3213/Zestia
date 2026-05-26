<?php
/**
 * Orders Routes
 * POST /api/orders - Create new order
 * GET /api/orders - Get user orders
 * GET /api/orders/{id} - Get single order
 * GET /api/orders/{id}/bill - Generate PDF bill
 */

global $conn;

// Get user ID from token (mock implementation)
$user_id = 1; // In production, validate JWT token

$id = isset($request_parts[2]) ? $request_parts[2] : '';
$action = isset($request_parts[3]) ? $request_parts[3] : '';

switch ($method) {
    case 'POST':
        if (!isset($input['items']) || !isset($input['address'])) {
            error('Missing required fields');
        }
        
        $items = $input['items'];
        $address = mysqli_real_escape_string($conn, $input['address']);
        $phone = mysqli_real_escape_string($conn, $input['phone'] ?? '');
        $paymentMethod = $input['paymentMethod'] ?? 'cash';
        $total = floatval($input['total'] ?? 0);
        
        $conn->query("INSERT INTO orders (user_id, total_amount, delivery_address, phone, payment_method, status, created_at) 
                     VALUES ($user_id, $total, '$address', '$phone', '$paymentMethod', 'pending', NOW())");
        
        $order_id = $conn->insert_id;
        
        // Insert order items
        foreach ($items as $item) {
            $item_id = intval($item['id']);
            $quantity = intval($item['quantity']);
            $price = floatval($item['price']);
            
            $conn->query("INSERT INTO order_items (order_id, menu_item_id, quantity, price) 
                         VALUES ($order_id, $item_id, $quantity, $price)");
        }
        
        response([
            'success' => true,
            'message' => 'Order created successfully',
            'order_id' => $order_id
        ], 201);
        break;
    
    case 'GET':
        if ($action === 'bill' && $id) {
            // Generate PDF bill
            response([
                'success' => true,
                'message' => 'Bill URL',
                'bill_url' => "/taaza/admin/functions/generate-bill.php?order_id=$id"
            ]);
        } elseif ($id && is_numeric($id)) {
            // Get single order
            $result = $conn->query("SELECT * FROM orders WHERE id = $id AND user_id = $user_id");
            
            if ($result->num_rows === 0) {
                error('Order not found', 404);
            }
            
            $order = $result->fetch_assoc();
            
            // Get order items
            $items_result = $conn->query("SELECT * FROM order_items WHERE order_id = $id");
            $items = [];
            while ($row = $items_result->fetch_assoc()) {
                $items[] = $row;
            }
            
            $order['items'] = $items;
            
            response([
                'success' => true,
                'data' => $order
            ]);
        } else {
            // Get all user orders
            $result = $conn->query("SELECT * FROM orders WHERE user_id = $user_id ORDER BY created_at DESC");
            $orders = [];
            
            while ($row = $result->fetch_assoc()) {
                $orders[] = $row;
            }
            
            response([
                'success' => true,
                'data' => $orders
            ]);
        }
        break;
    
    default:
        error('Method not allowed', 405);
}
?>
