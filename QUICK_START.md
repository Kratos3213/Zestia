# Quick Start Guide - Project-Taaza Modern Edition

## ⚡ 5-Minute Setup

### For Frontend Developers

```bash
# 1. Navigate to frontend
cd react-frontend

# 2. Install dependencies
npm install

# 3. Start development server
npm run dev

# App runs on http://localhost:5173/
```

### For Backend Developers

```bash
# 1. Ensure PHP server is running on localhost
# Apache/Nginx should be configured

# 2. Configure database
# Edit includes/connection.php with your MySQL credentials

# 3. Test API
# Visit http://localhost/taaza/api/menu in browser
```

---

## 📁 Key Files to Know

### Frontend
- `src/App.jsx` - Main app component with routing
- `src/context/AppContext.jsx` - Global state management
- `src/components/Header.jsx` - Navigation header
- `src/pages/Menu.jsx` - Menu browsing
- `src/pages/Cart.jsx` - Shopping cart
- `src/hooks/useAnimation.js` - GSAP animation hook
- `src/utils/api.js` - API client

### Backend
- `api/index.php` - Main router
- `api/routes/auth.php` - Authentication endpoints
- `api/routes/menu.php` - Menu endpoints
- `api/routes/orders.php` - Order management
- `api/routes/bookings.php` - Table booking
- `includes/connection.php` - Database connection

---

## 🎯 Common Tasks

### Add a New Page

1. Create component in `src/pages/NewPage.jsx`
2. Add route in `src/App.jsx`:
   ```jsx
   <Route path="/new-page" element={<NewPage />} />
   ```
3. Link in `src/components/Header.jsx`

### Add Animation to Component

```javascript
import { useAnimation } from '../hooks/useAnimation';
import { useRef, useEffect } from 'react';

export default function MyComponent() {
  const { fadeIn } = useAnimation();
  const ref = useRef();

  useEffect(() => {
    fadeIn(ref.current);
  }, []);

  return <div ref={ref}>Animated content</div>;
}
```

### Create New API Endpoint

1. Create route file in `api/routes/newroute.php`
2. Add case in `api/index.php`:
   ```php
   case 'newroute':
       require_once __DIR__ . '/routes/newroute.php';
       break;
   ```
3. Use in frontend with Axios

### Style with Tailwind

```jsx
<button className="
  bg-blue-600 
  text-white 
  px-6 py-3 
  rounded-lg 
  hover:bg-blue-700 
  transition-colors 
  transform hover:scale-105
">
  Click me
</button>
```

---

## 🚀 Build & Deploy

### Build Frontend
```bash
cd react-frontend
npm run build
# Creates optimized build in dist/
```

### Deploy Frontend
- Upload `dist/` folder to Vercel, Netlify, or GitHub Pages
- Or serve from Apache/Nginx static directory

### Deploy Backend
- Upload `api/` folder to your server
- Configure `.htaccess` for routing
- Update environment variables

---

## 🐛 Quick Debug

### Frontend Issues
1. Open DevTools (F12)
2. Check Console tab for errors
3. Check Network tab for API calls
4. Verify `.env.local` has correct API URL

### Backend Issues
1. Check `error_log` in PHP error logs
2. Test API directly in browser: `http://localhost/taaza/api/menu`
3. Verify database connection in `includes/connection.php`
4. Check MySQL user has correct permissions

---

## 📦 Dependencies

### Frontend Packages
- `react` - UI framework
- `react-router-dom` - Client-side routing
- `gsap` - Animations
- `tailwindcss` - Styling
- `axios` - HTTP client
- `lucide-react` - Icons

Install new package:
```bash
npm install package-name
```

---

## 💡 Pro Tips

1. **Use Environment Variables**: Store API URL in `.env.local`
2. **Component Reusability**: Create reusable components in `src/components/`
3. **Custom Hooks**: Create custom hooks in `src/hooks/` for common logic
4. **API Abstraction**: Use `src/utils/api.js` for all API calls
5. **Responsive Design**: Use Tailwind's responsive classes (`md:`, `lg:`, etc.)
6. **Animation Performance**: Use GSAP for complex animations, CSS for simple ones

---

## 📚 Documentation

- **Full Guide**: [MODERNIZATION_GUIDE.md](MODERNIZATION_GUIDE.md)
- **API Docs**: [api/API_DOCUMENTATION.md](api/API_DOCUMENTATION.md)
- **React README**: [react-frontend/README.md](react-frontend/README.md)
- **Original Project**: [README.md](README.md)

---

## ❓ FAQ

**Q: Can I run frontend and backend on same port?**
A: No, use different ports. Frontend on 5173, Backend on Apache/Nginx port.

**Q: How do I make API calls?**
A: Import from `src/utils/api.js` and use the API functions. They handle tokens automatically.

**Q: Can I use CSS modules instead of Tailwind?**
A: Yes, but Tailwind is configured and recommended for consistency.

**Q: How do I add new menu items?**
A: Use the existing admin panel at `admin/admin.php` or add via database directly.

**Q: Is the database shared with old PHP pages?**
A: Yes! New API and old PHP pages share the same `taaza_db` database. Both can coexist.

---

## 🎓 Next Learning Steps

1. Read MODERNIZATION_GUIDE.md for full architecture
2. Explore component structure in `src/components/`
3. Learn GSAP animations: https://gsap.com/docs
4. Review Tailwind CSS: https://tailwindcss.com
5. Understand React hooks: https://react.dev/reference/react

---

**Happy coding! 🚀**
