<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GymClass;

class UserClassController extends Controller
{
    public function index()
    {
        $classes = GymClass::where('is_active', true)->get();

        return view('user.class', [
            'classes' => $classes
        ]);
    }
}