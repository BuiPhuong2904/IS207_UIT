<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PackageRegistrationController extends Controller
{
    public function index()
    {
        return view('admin.package_registration');
    }
}
