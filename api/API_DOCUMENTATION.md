# Taaza REST API Documentation

## Overview
This is the REST API backend for the Taaza restaurant management system. It provides endpoints for authentication, menu management, orders, bookings, and more.

## Base URL
```
http://localhost/taaza/api
```

## Authentication
All protected endpoints require a Bearer token in the Authorization header:
```
Authorization: Bearer <token>
```

## Response Format
All responses are in JSON format:

### Success Response
```json
{
  "success": true,
  "data": { /* response data */ },
  "message": "Success message"
}
```

### Error Response
```json
{
  "error": "Error message"
}
```

---

## Endpoints

### Authentication

#### Register User
- **POST** `/api/auth/register`
- **Body:**
  ```json
  {
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123"
  }
  ```
- **Response:** User object + JWT token

#### Login
- **POST** `/api/auth/login`
- **Body:**
  ```json
  {
    "email": "john@example.com",
    "password": "password123"
  }
  ```
- **Response:** User object + JWT token

#### Verify Email
- **POST** `/api/auth/verify-email`
- **Body:**
  ```json
  {
    "token": "verification_token"
  }
  ```

#### Forgot Password
- **POST** `/api/auth/forgot-password`
- **Body:**
  ```json
  {
    "email": "john@example.com"
  }
  ```

#### Reset Password
- **POST** `/api/auth/reset-password`
- **Body:**
  ```json
  {
    "token": "reset_token",
    "password": "newpassword123"
  }
  ```

---

### Menu

#### Get All Menu Items
- **GET** `/api/menu`
- **Response:** Array of menu items

#### Get Items by Category
- **GET** `/api/menu/category/{category}`
- **Categories:** veg, non-veg, seafood, chinese, local
- **Response:** Array of filtered menu items

#### Get Single Item
- **GET** `/api/menu/{id}`
- **Response:** Menu item object

---

### Orders

#### Create Order
- **POST** `/api/orders`
- **Auth:** Required
- **Body:**
  ```json
  {
    "items": [
      {
        "id": 1,
        "name": "Butter Chicken",
        "price": 280,
        "quantity": 2
      }
    ],
    "address": "123 Main St, City",
    "phone": "1234567890",
    "paymentMethod": "cash",
    "total": 590
  }
  ```
- **Response:** Order ID + confirmation message

#### Get User Orders
- **GET** `/api/orders`
- **Auth:** Required
- **Response:** Array of user orders

#### Get Single Order
- **GET** `/api/orders/{id}`
- **Auth:** Required
- **Response:** Order object with items

#### Generate Bill PDF
- **GET** `/api/orders/{id}/bill`
- **Auth:** Required
- **Response:** PDF bill download URL

---

### Table Bookings

#### Create Booking
- **POST** `/api/bookings`
- **Auth:** Required
- **Body:**
  ```json
  {
    "date": "2024-06-15",
    "time": "18:30",
    "guests": "4",
    "name": "John Doe",
    "phone": "1234567890",
    "bookingType": "ground",
    "specialRequests": "Window table preferred",
    "decor": "none"
  }
  ```
- **VIP Decor Options:** none, romantic, birthday, anniversary, corporate

#### Get User Bookings
- **GET** `/api/bookings`
- **Auth:** Required
- **Response:** Array of user bookings

#### Get Single Booking
- **GET** `/api/bookings/{id}`
- **Auth:** Required
- **Response:** Booking object

#### Cancel Booking
- **DELETE** `/api/bookings/{id}`
- **Auth:** Required
- **Response:** Cancellation confirmation

---

### User Profile

#### Get Profile
- **GET** `/api/user/profile`
- **Auth:** Required
- **Response:** User profile object

#### Update Profile
- **PUT** `/api/user/profile`
- **Auth:** Required
- **Body:**
  ```json
  {
    "name": "John Doe",
    "phone": "1234567890"
  }
  ```

#### Update Password
- **PUT** `/api/user/password`
- **Auth:** Required
- **Body:**
  ```json
  {
    "currentPassword": "oldpass123",
    "newPassword": "newpass123",
    "confirmPassword": "newpass123"
  }
  ```

---

### VIP Membership

#### Activate VIP
- **POST** `/api/vip/activate`
- **Auth:** Required
- **Body:**
  ```json
  {
    "paymentMethod": "card"
  }
  ```
- **Response:** Transaction confirmation

#### Get VIP Status
- **GET** `/api/vip/status`
- **Auth:** Required
- **Response:** VIP status + benefits list

#### Get VIP Offers
- **GET** `/api/vip/offers`
- **Auth:** Required
- **Response:** Array of current VIP offers

---

### Cart (Client-side Validation)

#### Validate Cart
- **POST** `/api/cart/validate`
- **Auth:** Optional
- **Body:**
  ```json
  {
    "items": [
      {"id": 1, "quantity": 2}
    ]
  }
  ```
- **Response:** Validated items with current prices

---

## HTTP Status Codes
- `200` - OK
- `201` - Created
- `400` - Bad Request
- `401` - Unauthorized
- `403` - Forbidden
- `404` - Not Found
- `405` - Method Not Allowed
- `500` - Server Error

---

## Error Handling
Always check the `error` field in the response. Common errors:
- Missing required fields
- Invalid credentials
- Resource not found
- Unauthorized access
- Invalid data format

---

## Rate Limiting
Currently no rate limiting. In production, implement:
- 100 requests per minute per IP
- 1000 requests per hour per user

---

## CORS
API allows requests from all origins. In production, restrict to specific domains:
```
Access-Control-Allow-Origin: https://yourdomain.com
```

---

## Future Enhancements
- [ ] JWT token expiration
- [ ] Refresh tokens
- [ ] Role-based access control
- [ ] Request validation middleware
- [ ] Rate limiting
- [ ] API versioning (v2)
- [ ] Webhook support for order updates
- [ ] Real-time notifications
