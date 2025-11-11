<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClassScheduleController extends Controller
{
    public function index()
    {
        return view('admin.class_schedule');
    }
}
