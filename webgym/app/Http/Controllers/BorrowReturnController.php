<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BorrowReturnController extends Controller
{
    public function index()
    {
        return view('admin.borrow_return');
    }

}
