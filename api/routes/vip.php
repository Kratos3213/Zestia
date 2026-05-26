<?php
/**
 * VIP Routes
 * POST /api/vip/activate - Activate VIP membership
 * GET /api/vip/status - Get VIP status
 * GET /api/vip/offers - Get VIP offers
 */

global $conn;

$user_id = 1; // Mock user ID
$action = isset($request_parts[2]) ? $request_parts[2] : '';

switch ($action) {
    case 'activate':
        if ($method !== 'POST') {
            error('Method not allowed', 405);
        }
        
        // Check if user is already VIP
        $result = $conn->query("SELECT is_vip FROM registered_users WHERE id = $user_id");
        $user = $result->fetch_assoc();
        
        if ($user['is_vip']) {
            error('User is already VIP');
        }
        
        // Process payment (mock)
        $amount = 500;
        $paymentMethod = $input['paymentMethod'] ?? 'card';
        $transactionId = bin2hex(random_bytes(16));
        
        // Update user VIP status
        $conn->query("UPDATE registered_users SET is_vip = 1 WHERE id = $user_id");
        
        response([
            'success' => true,
            'message' => 'VIP membership activated',
            'transaction_id' => $transactionId,
            'amount' => $amount
        ]);
        break;
    
    case 'status':
        if ($method !== 'GET') {
            error('Method not allowed', 405);
        }
        
        $result = $conn->query("SELECT is_vip FROM registered_users WHERE id = $user_id");
        $user = $result->fetch_assoc();
        
        response([
            'success' => true,
            'data' => [
                'is_vip' => (bool)$user['is_vip'],
                'benefits' => [
                    'Exclusive menu items',
                    '10% discount on all orders',
                    'Free delivery',
                    'Priority table bookings',
                    'Special event invitations'
                ]
            ]
        ]);
        break;
    
    case 'offers':
        if ($method !== 'GET') {
            error('Method not allowed', 405);
        }
        
        response([
            'success' => true,
            'data' => [
                [
                    'id' => 1,
                    'title' => '10% Discount',
                    'description' => 'Get 10% off on all orders',
                    'code' => 'VIP10'
                ],
                [
                    'id' => 2,
                    'title' => 'Free Delivery',
                    'description' => 'Free delivery on all orders above ₹200',
                    'code' => 'FREEDEL'
                ],
                [
                    'id' => 3,
                    'title' => 'Birthday Special',
                    'description' => '20% off in your birthday month',
                    'code' => 'BIRTHDAY20'
                ]
            ]
        ]);
        break;
    
    default:
        error('Invalid action', 404);
}
?>
