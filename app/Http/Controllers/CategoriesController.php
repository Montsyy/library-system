<?php

namespace App\Http\Controllers;

use App\Models\category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function show($id)
    {
        return 'Category ID: ' . $id;
    }

    public function index()
    {
        $categories = Category::latest()->get();
        return view('categories.index', compact('categories'));
    }
}
