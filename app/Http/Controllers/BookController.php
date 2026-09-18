<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookController extends Controller
{
    public function show($id)
    {
        return 'Book ID: ' . $id;
    }

public function index()
{
    $title = 'Daftar Buku';
    $description = 'Daftar buku yang tersedia di perpustakaan.';
    return view('books.index', compact('title', 'description'));
}
}
