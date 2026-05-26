Zestia
Zestia is a full website project. It is a responsive restaurant website which provides online services related to a restaurant.

Key Features
🍪 Good Template for a restaurant website

🍪 Main pages: Home, About, Services, Our Menu, Contact, Dashboard, Register/Login

🍪 Register/Login: Forgot password, Mail sending etc.

🍪 Main services website offer(modules): Food ordering (Add to cart --> checkout || Increase/decrease quantity), Table booking (Normal & vip || Book & View Bookings), Vip membership (For discount and more)

🍪 Bill printing functionality (PDF generation) [Discounted for vip & non discounted]

🍪 Email sending functionality (During registration, forgot password, delete order by admin like events)

🍪 Admin functionality (To manage users, orders feedbacks, enabling/disabling pages, giving message etc)

Screenshot
This is a web template that I have created and made available for private use. Please note the licensing terms before using this template.

License
This work is licensed under the Creative Commons Attribution-NonCommercial 4.0 International License.

Usage
You are free to download and use this template for personal projects, educational purposes, or for non-commercial use. However, any public or commercial use, including publishing, marketing, or using it in a commercial project, is not permitted without explicit permission.

Adaptations
If you choose to adapt this template for your own needs, you must share your adaptations under the same Creative Commons Attribution-NonCommercial 4.0 International License. This ensures that others can benefit from your modifications while respecting the original creator's intentions.

Please read the full license text at http://creativecommons.org/licenses/by-nc/4.0/ for more details.

How to run
Create a database, tables, and columns with the following details using phpMyAdmin (Detailed structure and query given below this box):

Database name: zestia_db

Table names:

admin

Column names: id, email, name, password, resettoken, resettokenexpire, enable_table_booking, enable_menu_page

admin_message

Column names: id, message, enable_meessage

contact

Column names: id, email, timestamp

feedback

Column names: feedback_id, user_email, feedback_text, timestamp

lend_hand

Column names: id, name, email, amount, timestamp, show_detail

menu_items

Column names: id, name, description, category, price, quantity, available, image_path

orders

Column names: order_id, name, email, address, item, quantity, total_price, timestamp

registered_users

Column names: name, email, password, gender, state, district, verification_code, is_verified, resettoken, resettokenexpire, is_vip

table_booking_ground

Column names: id, name, email, section, seat, date, time, payment

table_booking_vip

Column names: id, name, email, section, seat, decor, date, time, payment

Database Structure & Creating Queries [Table By Table]
Database name: zestia_db

SQL
CREATE DATABASE zestia_db;
Table structure for table admin

CREATE TABLE admin (
    id INT NOT NULL,
    email VARCHAR(50) NOT NULL,
    name VARCHAR(100) NOT NULL,
    password VARCHAR(190) NOT NULL,
    resettoken VARCHAR(190) NOT NULL,
    resettokenexpire DATE DEFAULT NULL,
    enable_table_booking TINYINT NOT NULL,
    enable_menu_page TINYINT NOT NULL
);
Table structure for table admin_message

CREATE TABLE admin_message (
    id INT NOT NULL,
    message VARCHAR(5000) NOT NULL,
    enable_message TINYINT NOT NULL
);
Table structure for table contact
CREATE TABLE contact (
    id INT NOT NULL,
    email VARCHAR(90) NOT NULL,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
Table structure for table feedback
CREATE TABLE feedback (
    feedback_id INT NOT NULL,
    user_email VARCHAR(255) NOT NULL,
    feedback_text TEXT NOT NULL,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
Table structure for table lend_hand
CREATE TABLE lend_hand (
    id INT NOT NULL,
    name VARCHAR(50) NOT NULL,
    email VARCHAR(90) NOT NULL,
    amount INT NOT NULL,
    timestamp TIMESTAMP NOT NULL,
    show_detail TINYINT NOT NULL
);
Table structure for table menu_items
CREATE TABLE menu_items (
    id int NOT NULL AUTO_INCREMENT,
    name varchar(255) NOT NULL,
    description text,
    category varchar(50),
    price decimal(10,2) NOT NULL,
    quantity int NOT NULL DEFAULT 0,
    available tinyint(1) NOT NULL DEFAULT 1,
    image_path varchar(255),
    PRIMARY KEY (id)
);
Table structure for table orders
CREATE TABLE orders (
    order_id INT NOT NULL,
    name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    address VARCHAR(200) NOT NULL,
    item VARCHAR(30) NOT NULL,
    quantity VARCHAR(30) NOT NULL,
    total_price VARCHAR(30) NOT NULL,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
Table structure for table registered_users
CREATE TABLE registered_users (
    name VARCHAR(30) NOT NULL,
    email VARCHAR(30) NOT NULL,
    password VARCHAR(100) NOT NULL,
    gender VARCHAR(18) NOT NULL,
    state VARCHAR(30) NOT NULL,
    district VARCHAR(30) NOT NULL,
    verification_code VARCHAR(225) NOT NULL,
    is_verified INT NOT NULL DEFAULT 0,
    resettoken VARCHAR(255) DEFAULT NULL,
    resettokenexpire DATE DEFAULT NULL,
    is_vip TINYINT NOT NULL
);
Table structure for table table_booking_ground
CREATE TABLE table_booking_ground (
    id INT NOT NULL,
    name VARCHAR(30) NOT NULL,
    email VARCHAR(50) NOT NULL,
    section VARCHAR(30) NOT NULL,
    seat VARCHAR(30) DEFAULT NULL,
    date DATE NOT NULL,
    time VARCHAR(50) NOT NULL,
    payment TINYINT NOT NULL
);
Table structure for table table_booking_vip
CREATE TABLE table_booking_vip (
    id INT NOT NULL,
    name VARCHAR(30) NOT NULL,
    email VARCHAR(30) NOT NULL,
    section VARCHAR(30) NOT NULL,
    seat VARCHAR(30) NOT NULL,
    decor VARCHAR(50) NOT NULL,
    date DATE NOT NULL,
    time VARCHAR(20) NOT NULL,
    payment TINYINT NOT NULL
);
Technologies Used
Don't just copy, hit the star also 😊
Zestia - The website for restaurant
This includes front-end design and back-end code for a restaurant-based website.

This pack comes under the Creative Commons Attribution-NonCommercial license (CC BY-NC).
~Work by Vivek Gautam
©Vivek Gautam    Reach me at GitHub

~Work by Vivek Gautam

©Vivek Gautam    Reach me at GitHub
