# Route Reference Guide

## All Routes in the System

### Authentication Routes
```php
'login'                   → GET /login (show login form)
'login.post'              → POST /login (submit login)
'register'                → GET /register (show register form)
'register.post'           → POST /register (submit register)
'auth.google'             → GET /auth/google/redirect (Google OAuth redirect)
'auth.google.callback'    → GET /auth/google/callback (Google OAuth callback)
'forget-password'         → GET /forget-password (show form)
'forget-password.send'    → POST /forget-password (send reset email)
'password.reset'          → GET /reset-password/{token} (show reset form)
'password.update'         → POST /reset-password (update password)
```

### Homepage & Public Pages
```php
'home'                    → GET / (homepage)
'about'                   → GET /about
'package'                 → GET /package
'class'                   → GET /class
'product'                 → GET /product
'contact'                 → GET /contact
'blog1'                   → GET /blog/1
'blog2'                   → GET /blog/2
'blog3'                   → GET /blog/3
```

### User Profile Routes (Protected by `auth` middleware)
```php
'profile'                 → GET /profile (show profile)
'profile.update'          → POST /profile/update (update personal info)
'profile.change-password' → POST /profile/change-password (change password)
```

### Admin Customer Management Routes (Protected by `auth` + `isAdmin` middleware)
```php
'admin.customers.index'   → GET /admin/customers (list customers)
'admin.customers.create'  → GET /admin/customers/create (show create form)
'admin.customers.store'   → POST /admin/customers (store new customer)
'admin.customers.show'    → GET /admin/customers/{id} (view customer)
'admin.customers.edit'    → GET /admin/customers/{id}/edit (show edit form)
'admin.customers.update'  → PUT /admin/customers/{id} (update customer)
'admin.customers.destroy' → DELETE /admin/customers/{id} (delete customer)
```

---

## Using Routes in Blade Templates

### Navigation Links
```blade
<!-- Login -->
<a href="{{ route('login') }}">Login</a>

<!-- Register -->
<a href="{{ route('register') }}">Register</a>

<!-- Profile -->
<a href="{{ route('profile') }}">My Profile</a>

<!-- Admin Customer List -->
<a href="{{ route('admin.customers.index') }}">Customer Management</a>
```

### Form Submission

#### Profile Update Form
```blade
<form action="{{ route('profile.update') }}" method="POST">
    @csrf
    <!-- form fields -->
    <button type="submit">Update</button>
</form>
```

#### Change Password Form
```blade
<form action="{{ route('profile.change-password') }}" method="POST">
    @csrf
    <!-- form fields -->
    <button type="submit">Change Password</button>
</form>
```

#### Create Customer Form
```blade
<form action="{{ route('admin.customers.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <!-- form fields -->
    <button type="submit">Create Customer</button>
</form>
```

#### Edit Customer Form
```blade
<form action="{{ route('admin.customers.update', $customer->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <!-- form fields -->
    <button type="submit">Update</button>
</form>
```

#### Delete Customer Form
```blade
<form action="{{ route('admin.customers.destroy', $customer->id) }}" method="POST" style="display:inline;">
    @csrf
    @method('DELETE')
    <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
</form>
```

---

## Using Routes in Controllers

### Redirect to Route (with Flash Message)
```php
// From ProfileController
return redirect()->route('profile')->with('success', 'Profile updated!');

// From CustomerController
return redirect()->route('admin.customers.index')->with('success', 'Customer created!');
```

### Generate URL from Route
```php
// In controller or anywhere
$url = route('profile');
$url = route('admin.customers.edit', $customerId);
$url = route('admin.customers.destroy', $customerId);
```

---

## Route Group Structure

### User Profile Group
```php
Route::middleware('auth')->group(function () {
    Route::controller(\App\Http\Controllers\User\ProfileController::class)->group(function () {
        Route::get('/profile', 'show')->name('profile');
        Route::post('/profile/update', 'update')->name('profile.update');
        Route::post('/profile/change-password', 'changePassword')->name('profile.change-password');
    });
});
```

### Admin Customer Group (Using Resource Route)
```php
Route::middleware(['auth', 'isAdmin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('customers', \App\Http\Controllers\Admin\CustomerController::class);
});
```

The `resource()` method automatically generates:
- GET /admin/customers → index (name: admin.customers.index)
- GET /admin/customers/create → create (name: admin.customers.create)
- POST /admin/customers → store (name: admin.customers.store)
- GET /admin/customers/{id} → show (name: admin.customers.show)
- GET /admin/customers/{id}/edit → edit (name: admin.customers.edit)
- PUT/PATCH /admin/customers/{id} → update (name: admin.customers.update)
- DELETE /admin/customers/{id} → destroy (name: admin.customers.destroy)

---

## Quick Reference Card

| Task | Route Name | Method | Path |
|------|-----------|--------|------|
| Show profile | `profile` | GET | `/profile` |
| Update profile | `profile.update` | POST | `/profile/update` |
| Change password | `profile.change-password` | POST | `/profile/change-password` |
| List customers | `admin.customers.index` | GET | `/admin/customers` |
| Create customer | `admin.customers.create` | GET | `/admin/customers/create` |
| Store customer | `admin.customers.store` | POST | `/admin/customers` |
| View customer | `admin.customers.show` | GET | `/admin/customers/{id}` |
| Edit customer | `admin.customers.edit` | GET | `/admin/customers/{id}/edit` |
| Update customer | `admin.customers.update` | PUT | `/admin/customers/{id}` |
| Delete customer | `admin.customers.destroy` | DELETE | `/admin/customers/{id}` |

---

## Common Errors & Solutions

### Error: "Route [admin.customers.index] not defined"
**Solution:** Make sure middleware `isAdmin` is registered in `bootstrap/app.php`:
```php
$middleware->alias([
    'isAdmin' => \App\Http\Middleware\IsAdmin::class,
]);
```

### Error: "403 Forbidden" when accessing admin routes
**Solution:** Check that user has `role='admin'` in database. Regular users have `role='user'`.

### Error: "Undefined variable $customers"
**Solution:** Make sure the controller method returns view with `$customers` variable:
```php
return view('admin.customers.index', ['customers' => User::where('role', 'user')->get()]);
```

### Error: Form doesn't submit
**Solution:** Check route name is correct using: `php artisan route:list`

---

Generated: 2025
