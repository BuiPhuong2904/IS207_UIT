<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return redirect()->route('admin.dashboard');
    }

    // public function index()
    // {
    //     // Yêu cầu Laravel trả về 1 file giao diện tên là 'ad_layout'
    //     return view('layouts.ad_layout'); 
    // }
}
