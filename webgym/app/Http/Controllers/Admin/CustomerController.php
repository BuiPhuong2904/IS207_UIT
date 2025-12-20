<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('isAdmin');
    }

    // List all customers
    public function index()
    {
        $customers = User::where('role', 'user')->get();
        return view('admin.customers.index', compact('customers'));
    }

    // Show customer detail
    public function show($id)
    {
        $customer = User::findOrFail($id);
        $this->authorize('isAdmin', $customer);
        return view('admin.customers.show', compact('customer'));
    }

    // Show create form
    public function create()
    {
        return view('admin.customers.create');
    }

    // Store new customer
    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'phone' => 'nullable|string',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|string',
            'address' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imageUrl = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = Str::slug($validated['full_name'] . '-' . time()) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('users', $filename, 'public');
            $imageUrl = 'storage/' . $path;
        }

        User::create([
            'full_name' => $validated['full_name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'] ?? null,
            'birth_date' => $validated['birth_date'] ?? null,
            'gender' => $validated['gender'] ?? null,
            'address' => $validated['address'] ?? null,
            'image_url' => $imageUrl,
            'role' => 'user',
            'status' => 'active',
        ]);

        return redirect('/admin/customers')->with('success', 'Khách hàng được tạo thành công.');
    }

    // Show edit form
    public function edit($id)
    {
        $customer = User::findOrFail($id);
        return view('admin.customers.edit', compact('customer'));
    }

    // Update customer
    public function update(Request $request, $id)
    {
        $customer = User::findOrFail($id);

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'nullable|string',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|string',
            'address' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imageUrl = $customer->image_url;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = Str::slug($validated['full_name'] . '-' . time()) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('users', $filename, 'public');
            $imageUrl = 'storage/' . $path;
        }

        $customer->update([
            'full_name' => $validated['full_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'birth_date' => $validated['birth_date'] ?? null,
            'gender' => $validated['gender'] ?? null,
            'address' => $validated['address'] ?? null,
            'image_url' => $imageUrl,
        ]);

        return redirect('/admin/customers')->with('success', 'Khách hàng được cập nhật thành công.');
    }

    // Delete customer
    public function destroy($id)
    {
        $customer = User::findOrFail($id);
        $customer->delete();

        return redirect('/admin/customers')->with('success', 'Khách hàng được xóa thành công.');
    }
}
