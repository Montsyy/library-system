<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $bookCount = 6;
        $categoryCount = 5;
        $memberCount = 5;

        return view('dashboard.index', compact('bookCount', 'categoryCount', 'memberCount'));
    }
    
}
