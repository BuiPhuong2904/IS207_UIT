# Quick Start Guide - User Profile & Admin Management

## What Was Just Implemented

You now have a complete user profile management system and admin customer management backend with proper role-based access control.

---

## For Users (Role: `user`)

### Access Your Profile
1. **Login** → Click login button
2. **Go to profile** → `/profile` or click your name in header
3. **Edit your information:**
   - Name, email, phone, birth date, gender, address
   - Click "Lưu thông tin" (Save) button
4. **Change password:**
   - Scroll down to "Thay đổi mật khẩu" section
   - Enter current password, new password, confirm
   - Click "Cập nhật mật khẩu" (Update Password)

### What You Can Do
- ✅ View your profile information
- ✅ Edit personal details (name, email, phone, etc.)
- ✅ Change your password
- ✅ See your avatar
- ✅ View links to packages, classes, orders, rentals

### What You CAN'T Do
- ❌ Access `/admin/customers` (will get 403 error)
- ❌ Manage other users
- ❌ Delete accounts

---

## For Admins (Role: `admin`)

### Access Customer Management
1. **Login with admin account**
2. **Go to admin panel** → `/admin/customers`
3. **You should see a table of all customers**

### Customer Management Features

#### View All Customers
- **URL:** `/admin/customers`
- **Shows:** Table with ID, name, email, phone, birth date, address
- **Actions:** View, Edit, Delete buttons for each customer

#### Create New Customer
- **Click:** "+ Thêm khách hàng" (Add Customer) button
- **Fill form:** Full name, email, password, phone, birth date, gender, address, avatar
- **Upload:** Customer profile image (max 2MB)
- **Click:** "Thêm khách hàng" (Create Customer)
- **Result:** Customer added to database, appears in customer list

#### Edit Customer
- **In list:** Click yellow "Sửa" (Edit) button
- **Or:** Go directly to `/admin/customers/{id}/edit`
- **Update:** Any customer field
- **Change avatar:** Upload new image (old one is automatically deleted)
- **Click:** "Cập nhật" (Update)
- **Result:** Customer information updated

#### Delete Customer
- **In list:** Click red "Xóa" (Delete) button
- **Confirm:** Click "OK" on confirmation dialog
- **Result:** Customer removed from database

#### View Customer Details
- **In list:** Click blue "Xem" (View) button
- **Shows:** Full customer profile page

### What Admins Can Do
- ✅ View all customers
- ✅ Create new customers
- ✅ Edit customer details
- ✅ Delete customers
- ✅ Manage customer avatars/images
- ✅ Reset customer passwords (create with new password)
- ✅ View customer information

### What Admins CAN'T Do
- ❌ Edit another admin's profile
- ❌ Change roles (must be done via database currently)

---

## Important Things to Know

### Database Setup
1. Make sure you have a SQLite database at `database/database.sqlite`
2. Run migrations: `php artisan migrate`
3. The `users` table needs a `role` column (admin or user)

### User Roles in Database
```sql
-- Admin user
UPDATE users SET role = 'admin' WHERE id = 1;

-- Regular user
UPDATE users SET role = 'user' WHERE id = 2;
```

### Image Storage
- Customer images stored in: `/storage/users/`
- Images are public and accessible via URL
- Max file size: 2MB
- Allowed formats: JPEG, PNG, GIF
- Old images automatically deleted when updated

### Password Security
- All passwords are hashed with bcrypt
- Current password must be verified when changing password
- Passwords must be at least 8 characters

### Form Validation
- **Required fields** are marked with red asterisk (*)
- **Email** must be unique (not used by another customer)
- **Phone** must be 10-11 digits (if provided)
- **Birth date** must be in the past
- **Password** must be 8+ characters

---

## Testing Checklist

### Before Starting
- [ ] Database is set up and migrations run
- [ ] At least one admin user exists (role='admin')
- [ ] At least one regular user exists (role='user')

### User Tests
- [ ] Login as regular user
- [ ] Go to /profile - should work
- [ ] Update name and save - should see success message
- [ ] Go to /admin/customers - should get 403 Forbidden error
- [ ] Change password - should work with current password verification

### Admin Tests  
- [ ] Login as admin user
- [ ] Go to /admin/customers - should see customer list
- [ ] Click "+ Thêm khách hàng" - should see create form
- [ ] Create new customer with image upload - should see in list
- [ ] Click "Sửa" (Edit) on a customer - should open edit form
- [ ] Upload new avatar - should replace old image
- [ ] Click "Xóa" (Delete) - should remove customer
- [ ] Try going to /profile - should work (admins can also have profiles)

---

## File Locations

### New Views Created
```
resources/views/
├── user/profile/profile.blade.php
└── admin/customers/
    ├── index.blade.php
    ├── create.blade.php
    └── edit.blade.php
```

### New Controllers Created
```
app/Http/Controllers/
├── User/ProfileController.php
└── Admin/CustomerController.php
```

### Updated Files
```
routes/web.php              (Added user profile & admin customer routes)
bootstrap/app.php           (Registered isAdmin middleware)
app/Http/Middleware/IsAdmin.php (Updated to check admin role)
```

### Documentation Files Created
```
IMPLEMENTATION_SUMMARY.md   (Complete feature documentation)
ROUTES_REFERENCE.md         (All routes and usage examples)
QUICK_START.md              (This file - you are here)
```

---

## Common Tasks

### I want to make a user an admin
```bash
# Run in tinker or in a database tool
php artisan tinker
User::find(2)->update(['role' => 'admin']);
exit
```

### I want to reset a customer's password
1. Go to `/admin/customers/{id}/edit`
2. Create a new customer with the password you want (you can't change passwords for existing customers via UI, only create new ones)
3. Or manually update in database using `php artisan tinker`

### I want to change file upload location
Edit `CustomerController.php` and find the line:
```php
'storage/users/' . $filename
```
Change `storage/users/` to your desired path.

### I want to require email verification
Add to `ProfileController@update` method:
```php
'email' => 'required|email|unique:users,email,'.$user->id.'|verified',
```

---

## Troubleshooting

### Error: "Undefined variable: customers"
- Make sure you're accessing `/admin/customers` (list page), not `/admin/customers/create`
- Check CustomerController@index is returning the right variable

### Error: "403 Forbidden" on admin pages
- Check user has `role='admin'` in database
- Make sure you're logged in
- Clear your session: `php artisan tinker` → `cache('clear')`

### Image uploads not working
- Check `storage/users/` directory exists and is writable
- Check file size is under 2MB
- Check file format is jpg/jpeg/png/gif
- Make sure `php artisan storage:link` was run (creates public/storage symlink)

### Routes not working
- Run `php artisan route:list` to see all available routes
- Make sure middleware aliases are registered in `bootstrap/app.php`
- Clear cache: `php artisan config:cache`

### Session messages not showing
- Make sure you're using `->with('success', 'message')` in redirects
- Check Blade template displays session with `@if(session('success'))`

---

## Next Steps (Optional Enhancements)

1. **Add customer search/filter** - Find customers by name or email
2. **Add bulk operations** - Edit/delete multiple customers at once
3. **Add customer status** - Mark as active/inactive/suspended
4. **Add customer notes** - Store admin notes about customers
5. **Add customer history** - Track when customers were created/updated
6. **Add customer activity** - Show customer orders, classes, etc.
7. **Add profile avatar upload for users** - Let users upload their own avatar
8. **Add customer export** - Download customer list as CSV/Excel
9. **Add multi-language support** - Translate all text to English/other languages
10. **Add email notifications** - Send emails when customer account is created

---

## Support Resources

- **Laravel Documentation:** https://laravel.com/docs
- **Blade Templating:** https://laravel.com/docs/blade
- **Authentication:** https://laravel.com/docs/authentication
- **Validation:** https://laravel.com/docs/validation
- **Middleware:** https://laravel.com/docs/middleware
- **Resource Routes:** https://laravel.com/docs/controllers#resource-controllers

---

**Last Updated:** 2025
**Status:** ✅ Ready to Use
