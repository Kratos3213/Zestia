# 🍽️ Zestia

A fully responsive restaurant website project providing comprehensive online services for restaurants.

## ✨ Key Features

- 🍪 **Professional Restaurant Template** - Ready-to-use design for restaurant websites
- 📄 **Main Pages** - Home, About, Services, Our Menu, Contact, Dashboard, Register/Login
- 🔐 **User Authentication** - Secure login with forgot password and email notifications
- 🛒 **Food Ordering System** - Add to cart, checkout, quantity management
- 🪑 **Table Booking** - Standard and VIP reservation options with booking management
- 👑 **VIP Membership** - Special discounts for VIP members
- 📑 **Bill Generation** - PDF bill printing with automatic VIP discounts
- 📧 **Email Notifications** - Registration, password reset, order confirmations
- ⚙️ **Admin Panel** - Manage users, orders, feedback, pages, and messaging

## 📋 Tech Stack

- **Frontend:** HTML5, CSS3, JavaScript
- **Backend:** PHP
- **Database:** MySQL
- **Tools:** VSCode, ChatGPT

## 🚀 Getting Started

### Prerequisites
- PHP (v7.0+)
- MySQL Database
- phpMyAdmin

### Database Setup

Create the database with the following structure:

```sql
CREATE DATABASE zestia_db;
```

#### 1. Admin Table
```sql
CREATE TABLE admin (
    id INT NOT NULL PRIMARY KEY,
    email VARCHAR(50) NOT NULL,
    name VARCHAR(100) NOT NULL,
    password VARCHAR(190) NOT NULL,
    resettoken VARCHAR(190) NOT NULL,
    resettokenexpire DATE DEFAULT NULL,
    enable_table_booking TINYINT NOT NULL,
    enable_menu_page TINYINT NOT NULL
);
```

#### 2. Admin Messages Table
```sql
CREATE TABLE admin_message (
    id INT NOT NULL PRIMARY KEY,
    message VARCHAR(5000) NOT NULL,
    enable_message TINYINT NOT NULL
);
```

#### 3. Contact Table
```sql
CREATE TABLE contact (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(90) NOT NULL,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

#### 4. Feedback Table
```sql
CREATE TABLE feedback (
    feedback_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    user_email VARCHAR(255) NOT NULL,
    feedback_text TEXT NOT NULL,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

#### 5. Lend Hand Table
```sql
CREATE TABLE lend_hand (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    email VARCHAR(90) NOT NULL,
    amount INT NOT NULL,
    timestamp TIMESTAMP NOT NULL,
    show_detail TINYINT NOT NULL
);
```

#### 6. Menu Items Table
```sql
CREATE TABLE menu_items (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    category VARCHAR(50),
    price DECIMAL(10,2) NOT NULL,
    quantity INT NOT NULL DEFAULT 0,
    available TINYINT(1) NOT NULL DEFAULT 1,
    image_path VARCHAR(255)
);
```

#### 7. Orders Table
```sql
CREATE TABLE orders (
    order_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    address VARCHAR(200) NOT NULL,
    item VARCHAR(30) NOT NULL,
    quantity VARCHAR(30) NOT NULL,
    total_price VARCHAR(30) NOT NULL,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

#### 8. Registered Users Table
```sql
CREATE TABLE registered_users (
    email VARCHAR(30) NOT NULL PRIMARY KEY,
    name VARCHAR(30) NOT NULL,
    password VARCHAR(100) NOT NULL,
    gender VARCHAR(18) NOT NULL,
    state VARCHAR(30) NOT NULL,
    district VARCHAR(30) NOT NULL,
    verification_code VARCHAR(225) NOT NULL,
    is_verified INT NOT NULL DEFAULT 0,
    resettoken VARCHAR(255) DEFAULT NULL,
    resettokenexpire DATE DEFAULT NULL,
    is_vip TINYINT NOT NULL DEFAULT 0
);
```

#### 9. Table Booking (Ground) Table
```sql
CREATE TABLE table_booking_ground (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(30) NOT NULL,
    email VARCHAR(50) NOT NULL,
    section VARCHAR(30) NOT NULL,
    seat VARCHAR(30) DEFAULT NULL,
    date DATE NOT NULL,
    time VARCHAR(50) NOT NULL,
    payment TINYINT NOT NULL
);
```

#### 10. Table Booking (VIP) Table
```sql
CREATE TABLE table_booking_vip (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(30) NOT NULL,
    email VARCHAR(30) NOT NULL,
    section VARCHAR(30) NOT NULL,
    seat VARCHAR(30) NOT NULL,
    decor VARCHAR(50) NOT NULL,
    date DATE NOT NULL,
    time VARCHAR(20) NOT NULL,
    payment TINYINT NOT NULL
);
```

### Installation

1. Clone the repository
2. Create the database and tables using the SQL queries above
3. Update database credentials in your PHP configuration
4. Upload files to your web server
5. Access the application through your browser

## 📄 License

This work is licensed under the [Creative Commons Attribution-NonCommercial 4.0 International License](http://creativecommons.org/licenses/by-nc/4.0/).

![Creative Commons License](https://i.creativecommons.org/l/by-nc/4.0/88x31.png)

### Usage Rights

✅ **You may:**
- Download and use for personal projects
- Use for educational purposes
- Use for non-commercial websites

❌ **You cannot:**
- Use for commercial purposes
- Publish without attribution
- Use for commercial marketing

### Modifications

If you adapt this template, you must share your modifications under the same CC BY-NC 4.0 license.

For the full license details, visit: [creativecommons.org/licenses/by-nc/4.0/](http://creativecommons.org/licenses/by-nc/4.0/)

---

## 👨‍💻 About

**Zestia** - A complete restaurant website solution with front-end design and back-end functionality.

Created by **Vivek Gautam**  
[GitHub Profile](https://github.com/Kratos3213)

⭐ **Don't forget to star this repository!** ⭐
