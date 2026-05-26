<?php
/**
 * Bookings Routes
 * POST /api/bookings - Create new booking
 * GET /api/bookings - Get user bookings
 * GET /api/bookings/{id} - Get single booking
 * DELETE /api/bookings/{id} - Cancel booking
 */

global $conn;

$user_id = 1; // Mock user ID
$id = isset($request_parts[2]) ? $request_parts[2] : '';

switch ($method) {
    case 'POST':
        if (!isset($input['date']) || !isset($input['time']) || !isset($input['guests'])) {
            error('Missing required fields');
        }
        
        $date = mysqli_real_escape_string($conn, $input['date']);
        $time = mysqli_real_escape_string($conn, $input['time']);
        $guests = intval($input['guests']);
        $name = mysqli_real_escape_string($conn, $input['name'] ?? '');
        $phone = mysqli_real_escape_string($conn, $input['phone'] ?? '');
        $bookingType = $input['bookingType'] === 'vip' ? 'vip' : 'ground';
        $specialRequests = mysqli_real_escape_string($conn, $input['specialRequests'] ?? '');
        $decor = mysqli_real_escape_string($conn, $input['decor'] ?? 'none');
        
        $table = $bookingType === 'vip' ? 'table_booking_vip' : 'table_booking_ground';
        
        $sql = "INSERT INTO $table (user_id, booking_date, booking_time, guests, name, phone, special_requests, decor_preference, status, created_at) 
                VALUES ($user_id, '$date', '$time', $guests, '$name', '$phone', '$specialRequests', '$decor', 'confirmed', NOW())";
        
        if ($conn->query($sql)) {
            $booking_id = $conn->insert_id;
            response([
                'success' => true,
                'message' => 'Table booked successfully',
                'booking_id' => $booking_id
            ], 201);
        } else {
            error('Booking failed: ' . $conn->error);
        }
        break;
    
    case 'GET':
        if ($id && is_numeric($id)) {
            // Get single booking
            $ground_result = $conn->query("SELECT *, 'ground' as type FROM table_booking_ground WHERE id = $id AND user_id = $user_id");
            $vip_result = $conn->query("SELECT *, 'vip' as type FROM table_booking_vip WHERE id = $id AND user_id = $user_id");
            
            $booking = null;
            if ($ground_result->num_rows > 0) {
                $booking = $ground_result->fetch_assoc();
            } elseif ($vip_result->num_rows > 0) {
                $booking = $vip_result->fetch_assoc();
            }
            
            if (!$booking) {
                error('Booking not found', 404);
            }
            
            response([
                'success' => true,
                'data' => $booking
            ]);
        } else {
            // Get all user bookings
            $ground = [];
            $vip = [];
            
            $ground_result = $conn->query("SELECT *, 'ground' as type FROM table_booking_ground WHERE user_id = $user_id ORDER BY booking_date DESC");
            while ($row = $ground_result->fetch_assoc()) {
                $ground[] = $row;
            }
            
            $vip_result = $conn->query("SELECT *, 'vip' as type FROM table_booking_vip WHERE user_id = $user_id ORDER BY booking_date DESC");
            while ($row = $vip_result->fetch_assoc()) {
                $vip[] = $row;
            }
            
            $bookings = array_merge($ground, $vip);
            usort($bookings, function($a, $b) {
                return strtotime($b['booking_date']) - strtotime($a['booking_date']);
            });
            
            response([
                'success' => true,
                'data' => $bookings
            ]);
        }
        break;
    
    case 'DELETE':
        if (!$id || !is_numeric($id)) {
            error('Booking ID required');
        }
        
        // Try to cancel from both tables
        $deleted = false;
        
        $result = $conn->query("UPDATE table_booking_ground SET status = 'cancelled' WHERE id = $id AND user_id = $user_id");
        if ($conn->affected_rows > 0) {
            $deleted = true;
        }
        
        if (!$deleted) {
            $result = $conn->query("UPDATE table_booking_vip SET status = 'cancelled' WHERE id = $id AND user_id = $user_id");
            if ($conn->affected_rows > 0) {
                $deleted = true;
            }
        }
        
        if ($deleted) {
            response(['success' => true, 'message' => 'Booking cancelled']);
        } else {
            error('Booking not found', 404);
        }
        break;
    
    default:
        error('Method not allowed', 405);
}
?>
