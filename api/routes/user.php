<?php
/**
 * User Routes
 * GET /api/user/profile - Get user profile
 * PUT /api/user/profile - Update user profile
 * PUT /api/user/password - Update password
 */

global $conn;

$user_id = 1; // Mock user ID
$action = isset($request_parts[2]) ? $request_parts[2] : '';

switch ($action) {
    case 'profile':
        if ($method === 'GET') {
            $result = $conn->query("SELECT id, name, email, phone, is_vip, created_at FROM registered_users WHERE id = $user_id");
            
            if ($result->num_rows === 0) {
                error('User not found', 404);
            }
            
            $user = $result->fetch_assoc();
            response([
                'success' => true,
                'data' => $user
            ]);
        } elseif ($method === 'PUT') {
            $name = mysqli_real_escape_string($conn, $input['name'] ?? '');
            $phone = mysqli_real_escape_string($conn, $input['phone'] ?? '');
            
            if (!$name) {
                error('Name required');
            }
            
            $conn->query("UPDATE registered_users SET name = '$name', phone = '$phone' WHERE id = $user_id");
            
            response([
                'success' => true,
                'message' => 'Profile updated successfully'
            ]);
        }
        break;
    
    case 'password':
        if ($method !== 'PUT') {
            error('Method not allowed', 405);
        }
        
        $currentPassword = $input['currentPassword'] ?? '';
        $newPassword = $input['newPassword'] ?? '';
        $confirmPassword = $input['confirmPassword'] ?? '';
        
        if (!$currentPassword || !$newPassword || !$confirmPassword) {
            error('All password fields required');
        }
        
        if ($newPassword !== $confirmPassword) {
            error('Passwords do not match');
        }
        
        if (strlen($newPassword) < 6) {
            error('Password must be at least 6 characters');
        }
        
        $result = $conn->query("SELECT password FROM registered_users WHERE id = $user_id");
        $user = $result->fetch_assoc();
        
        if (!password_verify($currentPassword, $user['password'])) {
            error('Current password is incorrect', 401);
        }
        
        $password_hash = password_hash($newPassword, PASSWORD_BCRYPT);
        $conn->query("UPDATE registered_users SET password = '$password_hash' WHERE id = $user_id");
        
        response([
            'success' => true,
            'message' => 'Password updated successfully'
        ]);
        break;
    
    default:
        error('Invalid action', 404);
}
?>
