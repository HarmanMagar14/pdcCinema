# CineMax Admin Panel Documentation

## Overview
The CineMax Admin Panel is a comprehensive management interface for administering the cinema booking system. It includes user management, analytics dashboard, and resource management.

## Features Implemented

### 1. **User Management Module** ✅
- List all users with search and filtering
- Create new users with role assignment
- Edit user details, avatar, and status
- Delete users with confirmation
- Account status toggle (active/banned/pending)
- Email verification status tracking
- Last-seen timestamp tracking
- Profile photo upload
- Bulk actions (select all, delete selected, export selected)
- Pagination with configurable page size (10/25/50)

### 2. **Analytics Dashboard** ✅
- **KPI Cards:**
  - Total Bookings
  - Total Revenue
  - Average Ticket Price
  - Occupancy Rate
  
- **Charts:**
  - Bookings trend (line/bar chart)
  - Revenue trend (area chart)
  - Genre popularity (horizontal bar)
  - Payment methods (doughnut)
  - User growth (area)
  - User status distribution (pie)
  
- **Tables:**
  - Cinema performance with ratings
  - Top movies by bookings
  - Repeat customer analysis
  
- **Date Range Selector:** 7/30/90 days and yearly views

### 3. **Admin Layout & Components** ✅
- **Sidebar Navigation:**
  - Collapsible to icon-only on mobile
  - Grouped sections (Main, Management, Analytics, System)
  - Active state highlighting
  - Responsive design
  
- **Header:**
  - Page title with breadcrumbs
  - Search bar
  - Notification bell
  - User avatar dropdown
  
- **UI Components:**
  - Stat cards with trend indicators
  - Data tables with zebra striping
  - Forms with inline validation errors
  - Modal confirmations for destructive actions
  - Toast notifications (auto-dismiss 4s)
  - Loading skeleton states
  - Empty states with CTAs
  - Pagination controls

### 4. **General Admin Capabilities** ✅
- Full CRUD operations on users
- Advanced search and filtering
- Sorting by any column
- Pagination (10/25/50 items per page)
- Bulk select/delete/export
- Form validation with inline error messages
- Confirmation modals for destructive actions
- Real-time toast notifications
- Loading skeletons for data fetching

### 5. **Additional Modules** (Placeholders ready for expansion)
- Movies Management
- Cinemas Management  
- Bookings Management
- System Settings

## Accessing the Admin Panel

### Login Credentials
- **Email:** `admin@cinemax.com`
- **Password:** `admin123`

### URLs
- Dashboard: `http://localhost:8000/admin/dashboard`
- Users: `http://localhost:8000/admin/users`
- Analytics: `http://localhost:8000/admin/analytics`
- Settings: `http://localhost:8000/admin/settings`

## Directory Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   └── Admin/
│   │       └── AdminController.php
│   └── Middleware/
│       └── IsAdmin.php

resources/
└── views/
    └── admin/
        ├── layouts/
        │   └── app.blade.php (Main admin layout)
        ├── dashboard.blade.php
        ├── analytics.blade.php
        ├── settings.blade.php
        ├── users/
        │   ├── index.blade.php (User list)
        │   └── form.blade.php (Create/Edit user)
        ├── movies/
        │   └── index.blade.php
        ├── cinemas/
        │   └── index.blade.php
        └── bookings/
            └── index.blade.php
```

## Usage Guide

### Creating a User

1. Navigate to **Admin** → **Users**
2. Click **"Create User"** button
3. Fill in user details:
   - Name
   - Email
   - Password (min 8 characters)
   - Role (Admin/Customer)
   - Status (Active/Pending/Banned)
   - Email verification (optional)
   - Profile photo (optional)
4. Click **"Create User"** to save

### Managing Users

**View/Edit:**
- Click the pencil icon next to any user
- Modify details and click **"Update User"**

**Delete:**
- Click the trash icon next to a user
- Confirm the deletion in the modal

**Quick Actions:**
- Reset Password: Sends password reset email
- Ban User: Marks user as banned
- Send Email: Send notification email

**Bulk Actions:**
- Select multiple users with checkboxes
- Use bulk action menu to delete/export selected users
- Use "Select All" checkbox to select entire page

### Filtering & Search

**Search:**
- Use the search box to find by name or email
- Results appear in real-time

**Status Filter:**
- Filter users by Active/Banned/Pending status

**Pagination:**
- Change items per page (10/25/50)
- Navigate between pages

### Viewing Analytics

1. Navigate to **Admin** → **Analytics**
2. Select date range: 7/30/90 days or yearly
3. View KPI cards with trends
4. Analyze charts and trends
5. Review cinema and movie performance
6. Check user growth and retention metrics

## Features Technical Details

### Form Validation
- All forms include real-time validation
- Inline error messages appear below fields
- Required fields marked with asterisk (*)
- Password confirmation required for password changes
- Email uniqueness validated
- File upload size limits (2MB for images)

### Modals
- Centered overlay with backdrop blur
- Smooth animations
- Keyboard escape to close
- Click outside to dismiss
- Confirmation required for destructive actions

### Notifications
- Toast notifications in top-right
- Auto-dismiss after 4 seconds
- Three types: success (green), danger (red), warning (orange)
- Smooth slide-in/out animation

### Responsive Design
- Mobile-first approach
- Sidebar collapses on small screens
- Tables scroll horizontally on mobile
- Flexible grid layouts
- Touch-friendly button sizes

## Customization

### Adding New Admin Routes

Edit `routes/web.php`:
```php
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('new-resource', NewResourceController::class);
});
```

### Adding New Sidebar Item

Edit `resources/views/admin/layouts/app.blade.php`:
```php
<div class="sidebar-section">
    <h6 class="sidebar-section-title">New Section</h6>
    <ul class="sidebar-nav">
        <li><a href="{{ route('admin.new.index') }}" class="@if(request()->routeIs('admin.new.*')) active @endif">
            <i class="bi bi-icon"></i> New Item
        </a></li>
    </ul>
</div>
```

### Customizing Colors

Edit the CSS variables in `resources/views/admin/layouts/app.blade.php`:
```css
:root {
    --bg: #0d0d0f;
    --accent: #e8340a;
    --success: #48bb78;
    /* ... etc */
}
```

## API Endpoints

All admin endpoints require authentication and admin role.

### Users
- `GET /admin/users` - List users
- `GET /admin/users/create` - Create form
- `POST /admin/users` - Store user
- `GET /admin/users/{user}/edit` - Edit form
- `PUT /admin/users/{user}` - Update user
- `DELETE /admin/users/{user}` - Delete user

### Analytics
- `GET /admin/analytics` - Analytics dashboard

### Other Modules
- `GET /admin/movies` - Movies list
- `GET /admin/cinemas` - Cinemas list
- `GET /admin/bookings` - Bookings list
- `GET /admin/settings` - Settings page

## Security

- All admin routes require authentication (`auth` middleware)
- Admin role verification (IsAdmin middleware)
- CSRF protection on all forms
- Password hashing with bcrypt
- File upload validation
- Input validation and sanitization

## Database Columns Added

The following columns were added to the `users` table:
- `status` (enum: active, pending, banned) - Default: pending
- `avatar` (string) - Profile photo path
- `avatar_color` (string) - Background color for avatar fallback
- `last_seen` (timestamp) - Last activity timestamp

## Future Enhancements

1. **User Management:**
   - Email notifications system
   - Two-factor authentication
   - Role-based permissions
   - User activity logs

2. **Analytics:**
   - Export reports (PDF, Excel)
   - Custom date range picker
   - Advanced filtering
   - Real-time data updates

3. **Resources:**
   - Complete CRUD for movies, cinemas, bookings
   - Bulk import from CSV
   - Advanced search with filters
   - Multi-language support

4. **System:**
   - Email template editor
   - Backup management
   - Activity logging
   - System health dashboard

## Troubleshooting

**Can't access admin panel:**
- Ensure user has admin role
- Check authentication middleware
- Clear browser cache

**Forms not saving:**
- Check CSRF token in forms
- Verify form validation rules
- Check database migrations

**Charts not displaying:**
- Ensure Chart.js is loaded
- Check browser console for errors
- Verify data endpoints

## Support

For issues or questions about the admin panel, refer to the main project README or contact the development team.
