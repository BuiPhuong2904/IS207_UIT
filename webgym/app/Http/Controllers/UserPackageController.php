<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MembershipPackage;

class UserPackageController extends Controller
{
    /**
     * Hiển thị trang "Gói tập" 
     */
    public function index()
    {
        $packages = MembershipPackage::where('status', 'active')
                                    ->orderBy('price', 'asc')
                                    ->get();

        return view('user.package', [ 
            'packages' => $packages  // Gửi biến $packages vào view
        ]);
    }
}