# Project-Taaza Modernization Guide

## 🚀 Overview

Project-Taaza has been modernized with a beautiful React frontend, GSAP animations, and a RESTful PHP API backend. This guide explains the new architecture and how to get everything running.

## 📁 Project Structure

```
Project-Taaza-main/
├── react-frontend/          # Modern React SPA (NEW)
│   ├── src/
│   │   ├── components/      # Reusable React components
│   │   ├── pages/           # Page components
│   │   ├── context/         # Global state management
│   │   ├── hooks/           # Custom React hooks
│   │   ├── utils/           # API utilities
│   │   ├── App.jsx
│   │   ├── App.css
│   │   ├── main.jsx
│   │   └── index.css
│   ├── public/
│   ├── package.json
│   ├── vite.config.js
│   ├── tailwind.config.js
│   └── README.md
├── api/                     # REST API (NEW)
│   ├── index.php
│   ├── routes/
│   │   ├── auth.php
│   │   ├── menu.php
│   │   ├── orders.php
│   │   ├── bookings.php
│   │   ├── user.php
│   │   ├── vip.php
│   │   └── cart.php
│   └── API_DOCUMENTATION.md
├── admin/                   # Original admin panel
├── dashboard/               # Original dashboard
├── includes/                # Original includes
├── assets/                  # Static assets
├── vip/                      # VIP module
├── event-booking/           # Event booking
├── lend-hand/               # Charity module
├── fpdf/                    # PDF generation
└── [PHP files]              # Original PHP pages
```

## 🛠️ Installation & Setup

### Prerequisites
- Node.js 16+ (for React frontend)
- PHP 7.4+ (for backend)
- MySQL 5.7+ (existing database)
- Apache/Nginx with PHP support

### Step 1: Setup React Frontend

```bash
# Navigate to frontend directory
cd react-frontend

# Install dependencies
npm install

# Create environment file
cp .env.example .env.local

# Edit .env.local with your API URL
# VITE_API_URL=http://localhost/taaza/api
```

### Step 2: Run React Development Server

```bash
npm run dev
```

The app will be available at `http://localhost:5173/`

### Step 3: Setup Backend API

The PHP REST API is located in the `api/` folder. Ensure your web server is configured:

**Apache .htaccess** (Create in `api/` directory):
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteBase /taaza/api/
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)$ index.php?route=$1 [QSA,L]
</IfModule>
```

### Step 4: Update Database Connection

Edit `includes/connection.php` to match your database:

```php
$conn = new mysqli(
    "localhost",        // host
    "root",            // username
    "",                // password
    "taaza_db"         // database
);
```

### Step 5: Test the Setup

1. Start React frontend: `npm run dev`
2. Ensure PHP server is running
3. Visit `http://localhost:5173/`
4. Test login/registration at the API: `http://localhost/taaza/api/auth/register`

---

## 📱 Frontend Features

### React Components

**Layout Components:**
- `Header` - Navigation with mobile support
- `Footer` - Site footer with links
- `MenuItem` - Menu item card with animations

**Page Components:**
- `Home` - Landing page with features
- `Menu` - Browse menu by category
- `Cart` - Shopping cart management
- `Checkout` - Order placement
- `Login` / `Register` - Authentication
- `Dashboard` - User profile & orders
- `Bookings` - Table reservation
- `OrderSuccess` - Order confirmation

### State Management (Context API)

Global app state managed in `AppContext`:
- User authentication
- Shopping cart
- Total price calculation
- Loading states

Usage:
```javascript
import { useApp } from './context/AppContext';

function MyComponent() {
  const { user, cart, addToCart } = useApp();
  // ...
}
```

### Animations (GSAP)

Custom hook for animations:
```javascript
import { useAnimation } from './hooks/useAnimation';

function MyComponent() {
  const { fadeIn, slideInLeft, scaleUp } = useAnimation();
  
  const ref = useRef();
  useEffect(() => {
    fadeIn(ref.current);
  }, []);
  
  return <div ref={ref}>Animated content</div>;
}
```

### Styling (Tailwind CSS)

Modern utility-first CSS framework. Examples:
```jsx
<div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
  <button className="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
    Click me
  </button>
</div>
```

---

## 🔌 Backend API

### REST Endpoints

**Authentication:**
- `POST /api/auth/register` - Register user
- `POST /api/auth/login` - Login user
- `POST /api/auth/verify-email` - Verify email
- `POST /api/auth/forgot-password` - Reset password
- `POST /api/auth/reset-password` - Set new password

**Menu:**
- `GET /api/menu` - Get all items
- `GET /api/menu/category/{category}` - Filter by category
- `GET /api/menu/{id}` - Get single item

**Orders:**
- `POST /api/orders` - Create order
- `GET /api/orders` - Get user orders
- `GET /api/orders/{id}` - Get single order
- `GET /api/orders/{id}/bill` - Generate PDF

**Bookings:**
- `POST /api/bookings` - Create booking
- `GET /api/bookings` - Get user bookings
- `GET /api/bookings/{id}` - Get single booking
- `DELETE /api/bookings/{id}` - Cancel booking

**User:**
- `GET /api/user/profile` - Get profile
- `PUT /api/user/profile` - Update profile
- `PUT /api/user/password` - Change password

**VIP:**
- `POST /api/vip/activate` - Activate membership
- `GET /api/vip/status` - Get status
- `GET /api/vip/offers` - Get offers

See [API_DOCUMENTATION.md](api/API_DOCUMENTATION.md) for detailed examples.

---

## 🎨 Design System

### Colors
- Primary: `#2563eb` (Blue)
- Secondary: `#1e40af` (Dark Blue)
- Success: `#16a34a` (Green)
- Error: `#dc2626` (Red)
- Gray: Shades from 50-900

### Typography
- Font: System fonts (Segoe UI, Roboto, etc.)
- Body: 16px line height 145%
- Heading: Bold weight

### Spacing
- Base unit: 4px
- Standard: 8px, 16px, 24px, 32px, 48px

### Responsive Breakpoints
- Mobile: < 640px
- Tablet: 640px - 1024px
- Desktop: > 1024px

---

## 🚀 Building for Production

### Frontend Build

```bash
cd react-frontend
npm run build
```

Creates optimized production build in `dist/` folder.

Deploy to any static host:
- Vercel
- Netlify
- GitHub Pages
- AWS S3 + CloudFront

### Backend Deployment

1. Upload `api/` folder to your server
2. Configure `.htaccess` for URL rewriting
3. Update database credentials
4. Ensure CORS headers are set correctly
5. Set up SSL certificates (HTTPS)

### Environment Variables

**Frontend (.env.production):**
```
VITE_API_URL=https://yourapi.com/taaza/api
```

**Backend (config file):**
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'username');
define('DB_PASS', 'password');
define('DB_NAME', 'taaza_db');
define('API_URL', 'https://yourdomain.com/taaza/api');
```

---

## 🔒 Security Improvements

### Current Implementation
- ✅ Password hashing with BCRYPT
- ✅ Email verification
- ✅ Session management
- ✅ CORS protection

### Recommended Enhancements
- [ ] JWT tokens with expiration
- [ ] Refresh token rotation
- [ ] Rate limiting (100 req/min)
- [ ] Input validation & sanitization
- [ ] Prepared statements (mysqli_prepare)
- [ ] CSRF token validation
- [ ] Content Security Policy headers
- [ ] SQL injection prevention

### Minimal Security Checklist
```php
// Use prepared statements
$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();

// Validate & sanitize input
$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);

// Hash passwords
$hash = password_hash($password, PASSWORD_BCRYPT);
```

---

## 📊 Performance Tips

### Frontend
1. Use React.lazy() for code splitting
2. Implement image lazy loading
3. Optimize bundle size
4. Cache API responses
5. Use production build for deployment

### Backend
1. Add database indexes on frequently queried fields
2. Implement caching (Redis)
3. Use GZIP compression
4. Minimize database queries
5. Monitor slow queries

### Database Optimization
```sql
-- Add indexes
CREATE INDEX idx_email ON registered_users(email);
CREATE INDEX idx_order_user ON orders(user_id);
CREATE INDEX idx_booking_user ON table_booking_ground(user_id);

-- Check query performance
EXPLAIN SELECT * FROM orders WHERE user_id = 1;
```

---

## 🐛 Troubleshooting

### "Cannot connect to API"
1. Check if PHP server is running
2. Verify API URL in `.env.local`
3. Check CORS headers
4. Review browser console for errors

### "Database connection error"
1. Verify credentials in `includes/connection.php`
2. Ensure MySQL is running
3. Check database exists: `SHOW DATABASES;`
4. Check user privileges: `SHOW GRANTS FOR 'root'@'localhost';`

### "Cart not persisting"
1. Cart is session-based in frontend
2. Data only sends to backend on checkout
3. Review `AppContext.jsx` for state issues

### "Animations not working"
1. Ensure GSAP is installed: `npm list gsap`
2. Check ref is properly assigned
3. Verify element exists in DOM before animation

---

## 📚 Learning Resources

### React
- [React Documentation](https://react.dev)
- [React Router Guide](https://reactrouter.com)
- [Context API](https://react.dev/learn/passing-data-deeply-with-context)

### GSAP
- [GSAP Documentation](https://gsap.com/docs)
- [Animation Tutorials](https://gsap.com/community)

### Tailwind CSS
- [Tailwind Docs](https://tailwindcss.com/docs)
- [Component Examples](https://tailwindui.com)

### PHP
- [PHP Documentation](https://www.php.net/manual)
- [MySQLi Guide](https://www.php.net/manual/en/book.mysqli.php)

---

## 📞 Support & Questions

For issues or questions:
1. Check [API_DOCUMENTATION.md](api/API_DOCUMENTATION.md)
2. Review [react-frontend/README.md](react-frontend/README.md)
3. Check browser console for errors
4. Review server logs for backend issues

---

## 📝 License

CC BY-NC 4.0 International (Non-commercial use only)

---

## 🎉 What's New

### Version 2.0 (Modernized)
- ✨ Modern React SPA frontend
- 🎨 Beautiful UI with Tailwind CSS
- 🔄 GSAP animations throughout
- 🔌 RESTful API backend
- 📱 Fully responsive design
- ⚡ Improved performance
- 🚀 Better user experience
- 🛡️ Enhanced security

### Next Steps
1. [ ] Implement JWT authentication
2. [ ] Add email notifications
3. [ ] Set up payment gateway
4. [ ] Add real-time order tracking
5. [ ] Implement admin dashboard in React
6. [ ] Add PWA support
7. [ ] Set up CI/CD pipeline
8. [ ] Add automated testing

---

Good luck with your modern restaurant management platform! 🚀
