<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = User::where('role', 'member')
            ->with([
                'packageRegistrations.package',
                // ❌ TẠM THỜI XÓA relationship này
                // 'classRegistrations. schedule.gymClass'
            ])
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('admin.customers', compact('customers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'full_name' => 'required|string|max:255',
            'email'     => 'required|email|unique:user,email',
            'password'  => 'required|min: 6',
            'phone'     => 'nullable|string|max:20',
            'address'   => 'nullable|string|max:255',
        ]);

        User::create([
            'full_name' => $data['full_name'],
            'email'     => $data['email'],
            'password'  => Hash::make($data['password']),
            'phone'     => $data['phone'] ?? null,
            'address'   => $data['address'] ?? null,
            'role'      => 'member',
        ]);

        return response()->json(['message' => 'Created'], 201);
    }

    public function update(Request $request, User $customer)
    {
        $data = $request->validate([
            'full_name' => 'required|string|max:255',
            'email'     => 'required|email|unique:user,email,' . $customer->id,
            'phone'     => 'nullable|string|max: 20',
            'address'   => 'nullable|string|max:255',
        ]);

        $customer->update($data);

        return response()->json(['message' => 'Updated']);
    }
}