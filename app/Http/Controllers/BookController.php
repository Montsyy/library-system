<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Symfony\Contracts\Service\Attribute\Required;

class BookController extends Controller
{

    public function index()
    {
        $books = Book::all();

        return view('books.index', compact('books'));
    }
    public function show($id)
    {
        $book = Book::findOrFail($id);
        return view('books.show', compact('book'));
    }
    public function create()
    {
        return view('books.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'year' => 'required|integer|min:2000',
            'stock' => 'required|integer|min:0'
        ]);

        Book::create($validated);

        return redirect()
                ->route('books.index')
                ->with('success', 'Data buku berhasil ditambahkan');
    }

    public function edit(Book $book)
    {
        return view('books.edit', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'year' => 'required|integer|min:2000',
            'stock' => 'required|integer|min:0'
        ]);

        $book->update($validated);

        return redirect()->route('books.index');
    }
    public function destroy(Book $book)
    {
        $book->delete();

        return redirect()->route('books.index');
    }

}
