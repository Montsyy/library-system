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
        return view('books.index',compact('books'));
    } 
}
