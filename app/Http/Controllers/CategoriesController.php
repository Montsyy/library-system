<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function show($id)
    {
        return 'Category ID: ' . $id;
    }
}
