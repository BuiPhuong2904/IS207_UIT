# User Profile & Admin Customer Management Implementation

## ✅ Implementation Complete

This document summarizes the implementation of user profile pages and admin customer management system with role-based access control.

---

## 1. User Profile Pages (Bên phía User)

### Location: `/profile`

#### Features:
- **View & Edit Personal Information**
  - Full name, email, phone number, birth date, gender, address
  - Real-time form with error validation
  - User avatar display (placeholder if not set)

- **Change Password**
  - Current password verification (validates against stored hash)
  - New password with confirmation
  - Secure password update with bcrypt hashing

- **User Sidebar Menu**
  - Profile (Hồ sơ) - Active tab
  - Purchased Packages (Gói tập đã mua)
  - Registered Classes (Lớp học đã đăng ký)
  - Order History (Lịch sử đơn hàng)
  - Rental/Return History (Lịch sử mượn/trả)

#### Files:
- **View:** `resources/views/user/profile/profile.blade.php`
- **Controller:** `app/Http/Controllers/User/ProfileController.php`
- **Routes:**
  - `GET /profile` → Display profile page
  - `POST /profile/update` → Update personal information
  - `POST /profile/change-password` → Change password
- **Middleware Protection:** `auth` (authenticated users only)

#### Validation Rules:
- **Update Profile:**
  - Email: unique (except current user)
  - Phone: optional
  - Birth date, Gender, Address: optional
  
- **Change Password:**
  - Current password: verified against user's stored hash (uses Laravel's `current_password` rule)
  - Password: required, min 8 chars
  - Password confirmation: must match new password

---

## 2. Admin Customer Management (Bên phía Admin)

### Location: `/admin/customers`

#### Pages:

##### 2.1 Customer List (Danh sách khách hàng)
- **Path:** `/admin/customers` (GET)
- **Features:**
  - Responsive table with all customer details (ID, Name, Email, Phone, Birth Date, Address)
  - Action buttons for each customer:
    - **View** (Xem) - Blue button
    - **Edit** (Sửa) - Yellow button
    - **Delete** (Xóa) - Red button with confirmation dialog
  - Success message after CRUD operations
  - "Add Customer" button to create new customer
  
- **File:** `resources/views/admin/customers/index.blade.php`
- **Controller Method:** `CustomerController@index`

##### 2.2 Create Customer (Thêm khách hàng mới)
- **Path:** `/admin/customers/create` (GET)
- **Features:**
  - Form to create new customer with fields:
    - Full Name (required)
    - Email (required, unique)
    - Password (required, min 8 chars)
    - Password Confirmation (required, must match)
    - Phone (optional)
    - Birth Date (optional)
    - Gender (optional, select: Nam/Nữ/Khác)
    - Address (optional)
    - Avatar Image (optional, max 2MB, jpeg/png/jpg/gif)
  - Error validation display for each field
  - Cancel & Create buttons

- **Post Data:** POST `/admin/customers`
- **File:** `resources/views/admin/customers/create.blade.php`
- **Controller Method:** `CustomerController@store`

##### 2.3 Edit Customer (Chỉnh sửa khách hàng)
- **Path:** `/admin/customers/{id}/edit` (GET)
- **Features:**
  - Pre-filled form with existing customer data
  - Update all customer fields (except password reset on this form)
  - Current avatar display
  - Option to upload new avatar
  - Error validation display
  - Cancel & Update buttons

- **Post Data:** PUT `/admin/customers/{id}`
- **File:** `resources/views/admin/customers/edit.blade.php`
- **Controller Method:** `CustomerController@update`

#### Admin Controller Details:
- **File:** `app/Http/Controllers/Admin/CustomerController.php`
- **Full CRUD Methods:**
  - `index()` - List all customers (filters by role='user')
  - `create()` - Show create form
  - `store()` - Save new customer with image upload
  - `show($id)` - Display single customer
  - `edit($id)` - Show edit form
  - `update($id)` - Update customer with optional image re-upload
  - `destroy($id)` - Delete customer

#### Image Handling:
- Storage path: `storage/users/`
- File naming: slugified customer name (e.g., "john-doe-1234567890.jpg")
- Public disk access: `storage/` URL prefix
- Validation: max 2MB, allowed types (jpeg, png, jpg, gif)
- Automatic cleanup: old image deleted when new one uploaded

#### Validation Rules (Store):
```
full_name: required|string|max:255
email: required|email|unique:users,email
password: required|min:8|confirmed
phone: nullable|regex:/^[0-9]{10,11}$/
birth_date: nullable|date|before:today
gender: nullable|in:Nam,Nữ,Khác
address: nullable|string|max:500
image: nullable|image|mimes:jpeg,png,jpg,gif|max:2048
```

#### Validation Rules (Update):
```
full_name: required|string|max:255
email: required|email|unique:users,email,{id}
phone: nullable|regex:/^[0-9]{10,11}$/
birth_date: nullable|date|before:today
gender: nullable|in:Nam,Nữ,Khác
address: nullable|string|max:500
image: nullable|image|mimes:jpeg,png,jpg,gif|max:2048
```

---

## 3. Role-Based Access Control (Phân quyền)

### Permission System:

#### Admin Role (`role='admin'`)
- **Access:** `/admin/*` routes
- **Can:** 
  - View all customers
  - Create new customers
  - Edit customer details
  - Delete customers
  - Upload/manage customer avatars
  - Change customer information
  
- **Protected By:** `isAdmin` middleware

#### User Role (`role='user'`)
- **Access:** `/profile` routes
- **Can:**
  - View own profile
  - Edit own profile information
  - Change own password
  
- **Protected By:** `auth` middleware

### Middleware Configuration:

#### IsAdmin Middleware (`app/Http/Middleware/IsAdmin.php`)
```php
// Checks: User must be authenticated AND have role='admin'
// If not: Returns 403 Forbidden error (Bạn không có quyền truy cập.)
```

#### Route Protection:

**User Profile Routes:**
```php
Route::middleware('auth')->group(function () {
    Route::get('/profile', ...)->name('profile');
    Route::post('/profile/update', ...)->name('profile.update');
    Route::post('/profile/change-password', ...)->name('profile.change-password');
});
```
- Requires: Authentication only
- Middleware: `auth`

**Admin Routes:**
```php
Route::middleware(['auth', 'isAdmin'])->prefix('admin')->group(function () {
    Route::resource('customers', CustomerController::class);
});
```
- Requires: Authentication + Admin role
- Middleware: `auth`, then `isAdmin`
- Generated routes:
  - `GET /admin/customers` (index)
  - `GET /admin/customers/create` (create)
  - `POST /admin/customers` (store)
  - `GET /admin/customers/{id}` (show)
  - `GET /admin/customers/{id}/edit` (edit)
  - `PUT /admin/customers/{id}` (update)
  - `DELETE /admin/customers/{id}` (destroy)

### Middleware Registration:

**File:** `bootstrap/app.php`

```php
->withMiddleware(function (Middleware $middleware) {
    // Register IsAdmin middleware with aliases
    $middleware->alias([
        'isAdmin' => \App\Http\Middleware\IsAdmin::class,
        'admin.role' => \App\Http\Middleware\IsAdmin::class,
    ]);
})
```

---

## 4. Route Summary

### Public Routes:
- `GET /` → Home
- `GET /login` → Login page
- `POST /login` → Login submit
- `GET /register` → Register page
- `POST /register` → Register submit
- `GET /about, /package, /class, /product, /contact` → Pages

### User Protected Routes:
- `GET /profile` → View profile (name: `profile`)
- `POST /profile/update` → Update profile (name: `profile.update`)
- `POST /profile/change-password` → Change password (name: `profile.change-password`)

### Admin Protected Routes:
- `GET /admin/customers` → List customers (name: `admin.customers.index`)
- `GET /admin/customers/create` → Create form (name: `admin.customers.create`)
- `POST /admin/customers` → Store customer (name: `admin.customers.store`)
- `GET /admin/customers/{id}` → View customer (name: `admin.customers.show`)
- `GET /admin/customers/{id}/edit` → Edit form (name: `admin.customers.edit`)
- `PUT /admin/customers/{id}` → Update customer (name: `admin.customers.update`)
- `DELETE /admin/customers/{id}` → Delete customer (name: `admin.customers.destroy`)

---

## 5. Database Relationships

### User Model Fields Used:
```
id, full_name, email, password, phone, birth_date, gender, 
address, image_url, role, created_at, updated_at
```

### Field Types:
- `full_name`: string (255)
- `email`: string (255), unique
- `password`: string (255), hashed
- `phone`: string (20), nullable
- `birth_date`: date, nullable
- `gender`: enum('Nam', 'Nữ', 'Khác'), nullable
- `address`: text, nullable
- `image_url`: string (255), nullable
- `role`: enum('admin', 'user'), default 'user'

---

## 6. Flash Messages (Session Feedback)

All forms use session flash messages with 'success' key:

**Profile Update:**
- "Thông tin cá nhân đã được cập nhật thành công!"

**Change Password:**
- "Mật khẩu đã được thay đổi thành công!"

**Customer Create:**
- "Khách hàng mới đã được thêm thành công!"

**Customer Update:**
- "Thông tin khách hàng đã được cập nhật thành công!"

**Customer Delete:**
- "Khách hàng đã được xóa thành công!"

---

## 7. File Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/
│   │   │   └── CustomerController.php (NEW)
│   │   └── User/
│   │       └── ProfileController.php (NEW)
│   └── Middleware/
│       └── IsAdmin.php (UPDATED - Added role check)
│
resources/
└── views/
    ├── user/
    │   └── profile/
    │       └── profile.blade.php (NEW)
    └── admin/
        └── customers/
            ├── index.blade.php (NEW)
            ├── create.blade.php (NEW)
            └── edit.blade.php (NEW)

routes/
└── web.php (UPDATED - Added user profile & admin customer routes)

bootstrap/
└── app.php (UPDATED - Registered isAdmin middleware alias)
```

---

## 8. Testing Checklist

- [ ] Create a user account with role='admin'
- [ ] Create a user account with role='user'
- [ ] Login as admin user
  - [ ] Access `/admin/customers` - should work
  - [ ] Create new customer - should work
  - [ ] Edit customer - should work
  - [ ] Delete customer - should work
- [ ] Login as regular user
  - [ ] Access `/admin/customers` - should return 403 Forbidden
  - [ ] Access `/profile` - should work
  - [ ] Update profile information - should work
  - [ ] Change password - should work
- [ ] Upload customer avatar - should store in `storage/users/`
- [ ] Edit customer with new avatar - old image should be deleted
- [ ] Form validation - required fields should show errors

---

## 9. Security Notes

✅ **Implemented:**
- CSRF protection on all forms (@csrf)
- Password hashing using bcrypt (Hash::make)
- Role-based access control via middleware
- Current password verification for password changes
- Request validation on all inputs
- Soft delete support for customers

⚠️ **Recommendations:**
- Implement rate limiting on login/register
- Add email verification for password changes
- Add audit logging for customer modifications
- Implement 2FA for admin accounts
- Add password history to prevent reuse

---

## 10. Next Steps (Optional)

- [ ] Implement customer avatar upload on profile page for users
- [ ] Add search/filter functionality to customer list
- [ ] Implement export customer data to CSV/Excel
- [ ] Add customer activity log/timeline
- [ ] Implement bulk customer operations (bulk edit, bulk delete)
- [ ] Add customer notes/comments section
- [ ] Implement customer status (active/inactive/suspended)
- [ ] Add customer membership level/tier

---

**Implementation Date:** 2025
**Status:** ✅ Complete and Ready for Testing
