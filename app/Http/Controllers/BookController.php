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
       $books = [
            'Pemrograman PHP',
            'Laravel untuk Pemula',
            'Basis Data',
            'Algoritma dan Pemrograman',
            'Pemrograman Berorientasi Objek'
        ];
        $stock = [
            'Pemrograman PHP' => 10,
            'Laravel untuk Pemula' => 0,
            'Basis Data' => 0,
            'Algoritma dan Pemrograman' => 12,
            'Pemrograman Berorientasi Objek' => 7
        ];
        return view('books.index',compact('books', 'stock'));
        
    } 
}
