<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function show($id)
    {
        return 'Category ID: ' . $id;
    }

    public function index()
    {
        $categories = [
            'Pemrograman',
            'Basis Data',
            'Jaringan Komputer',
            'Sistem Informasi',
            'Algoritma'
        ];
        return view('categories.index', compact('categories'));
    }
}
