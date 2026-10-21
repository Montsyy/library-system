<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Models\Category;
use Symfony\Contracts\Service\Attribute\Required;

class BookController extends Controller
{

    public function index()
    {
        $books = Book::with('category')->latest()->get();

        return view('books.index', compact('books'));
    }
    public function show($id)
    {
        $book = Book::with('category')->findOrFail($id);
        return view('books.show', compact('book'));
    }
    public function create()
    {   
        $categories = Category::orderBy('name')->get();

        return view('books.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'year' => 'required|integer|min:2000',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id'
        ]);

        Book::create($validated);

        return redirect()
                ->route('books.index')
                ->with('success', 'Data buku berhasil ditambahkan');
    }

    public function edit(Book $book)
    {   
        $categories = Category::orderBy('name')->get();
        return view('books.edit', compact('book', 'categories'));
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'year' => 'required|integer|min:2000',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id'
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
