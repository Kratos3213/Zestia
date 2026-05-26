<?php
/**
 * Authentication Routes
 * POST /api/auth/register - Register new user
 * POST /api/auth/login - Login user
 * POST /api/auth/verify-email - Verify email
 * POST /api/auth/forgot-password - Forgot password
 * POST /api/auth/reset-password - Reset password
 */

global $conn;

$action = isset($request_parts[1]) ? $request_parts[1] : '';
$input = json_decode(file_get_contents('php://input'), true);

switch ($action) {
    case 'register':
        if ($method !== 'POST') error('Method not allowed', 405);
        
        $name = trim($input['name'] ?? '');
        $email = trim($input['email'] ?? '');
        $password = trim($input['password'] ?? '');
        
        if (!$name || !$email || !$password) {
            error('Missing required fields');
        }
        
        if (strlen($password) < 6) {
            error('Password must be at least 6 characters');
        }
        
        // Check if user exists
        $result = $conn->query("SELECT id FROM registered_users WHERE email = '$email'");
        if ($result->num_rows > 0) {
            error('Email already registered');
        }
        
        $password_hash = password_hash($password, PASSWORD_BCRYPT);
        $verification_token = bin2hex(random_bytes(16));
        
        $sql = "INSERT INTO registered_users (name, email, password, verification_token, is_verified) 
                VALUES ('$name', '$email', '$password_hash', '$verification_token', 0)";
        
        if ($conn->query($sql)) {
            $user_id = $conn->insert_id;
            $token = bin2hex(random_bytes(32));
            
            response([
                'success' => true,
                'message' => 'Registration successful. Please verify your email.',
                'user' => [
                    'id' => $user_id,
                    'name' => $name,
                    'email' => $email,
                    'is_vip' => false
                ],
                'token' => $token
            ], 201);
        } else {
            error('Registration failed');
        }
        break;
    
    case 'login':
        if ($method !== 'POST') error('Method not allowed', 405);
        
        $email = trim($input['email'] ?? '');
        $password = trim($input['password'] ?? '');
        
        if (!$email || !$password) {
            error('Email and password required');
        }
        
        $result = $conn->query("SELECT * FROM registered_users WHERE email = '$email'");
        
        if ($result->num_rows === 0) {
            error('Invalid credentials', 401);
        }
        
        $user = $result->fetch_assoc();
        
        if (!password_verify($password, $user['password'])) {
            error('Invalid credentials', 401);
        }
        
        if (!$user['is_verified']) {
            error('Please verify your email first', 403);
        }
        
        $token = bin2hex(random_bytes(32));
        
        response([
            'success' => true,
            'message' => 'Login successful',
            'user' => [
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email'],
                'is_vip' => (bool)$user['is_vip']
            ],
            'token' => $token
        ]);
        break;
    
    case 'verify-email':
        if ($method !== 'POST') error('Method not allowed', 405);
        
        $token = trim($input['token'] ?? '');
        
        if (!$token) {
            error('Verification token required');
        }
        
        $result = $conn->query("SELECT id FROM registered_users WHERE verification_token = '$token'");
        
        if ($result->num_rows === 0) {
            error('Invalid verification token', 401);
        }
        
        $user = $result->fetch_assoc();
        $conn->query("UPDATE registered_users SET is_verified = 1 WHERE id = " . $user['id']);
        
        response([
            'success' => true,
            'message' => 'Email verified successfully'
        ]);
        break;
    
    default:
        error('Invalid auth action', 404);
}
?>
