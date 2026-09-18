<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookController extends Controller
{

    public function index()
    {
       $books = [
            ['id' => 1, 'title' => 'Pemrograman PHP', 'author' => 'Diman', 'tahun' => 2020],
            ['id' => 2, 'title' => 'Laravel untuk Pemula', 'author' => 'Rizu', 'tahun' => 1446],
            ['id' => 3, 'title' => 'Basis Data', 'author' => 'Lazuardi', 'tahun' => 2019],
            ['id' => 4, 'title' => 'Algoritma dan Pemrograman', 'author' => 'Fikhri', 'tahun' => 2023],
            ['id' => 5, 'title' => 'Pemrograman Berorientasi Objek', 'author' => 'Dwi', 'tahun' => 2026],
            ['id' => 6, 'title' => 'Jaringan Komputer', 'author' => 'Rizki', 'tahun' => 2025]
        ];
        $stock = [
            ['id' => 1, 'stock' => 10],
            ['id' => 2, 'stock' => 0],
            ['id' => 3, 'stock' => 8],
            ['id' => 4, 'stock' => 0],
            ['id' => 5, 'stock' => 7],
            ['id' => 6, 'stock' => 3]
        ];
        return view('books.index', compact('books', 'stock'));
    }
    public function show($id)
    {
        return view('books.show', ['id' => $id]);
    }
}
