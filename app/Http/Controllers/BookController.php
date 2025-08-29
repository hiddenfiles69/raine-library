<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
   public function index(Request $request)
{
    $search = $request->input('search');

    $books = Book::query()
        ->when($search, function ($query, $search) {
            $query->where('bookname', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('publisher', 'like', "%{$search}%")
                  ->orWhere('genre', 'like', "%{$search}%")
                  ->orWhere('publication_year', 'like', "%{$search}%")
                  ->orWhere('available_copies', 'like', "%{$search}%");
        })
        ->paginate(10)
        ->withQueryString();

    if ($request->ajax()) {
        return view('books.partials.book_table', ['books' => $books])->render();
    }

    return view('books.index', compact('books'));
}


    public function create()
    {
        return view('books.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'bookname' => 'required',
            'author' => 'required',
            'publisher' => 'required',
            'genre' => 'required',
            'publication_year' => 'required|integer',
            'available_copies' => 'required|integer',
        ]);

        Book::create($request->all());

        if ($request->ajax()) {
            return response()->json([
                'message' => '...',
                'book' => $book, // when applicable
            ]);
        }
        return redirect()->route('books.index')->with('success', 'Book created successfully.');
    }

    public function show(Book $book)
    {
        return view('books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        return view('books.edit', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'bookname' => 'required',
            'author' => 'required',
            'publisher' => 'required',
            'genre' => 'required',
            'publication_year' => 'required|integer',
            'available_copies' => 'required|integer',
        ]);

        $book->update($request->only(['bookname', 'author', 'publisher', 'genre', 'publication_year', 'available_copies']));
         if ($request->ajax()) {
          return response()->json([
                'message' => '...',
                'book' => $book, // when applicable
            ]);
        }

        return redirect()->route('books.index')->with('success', 'Book updated successfully.');
    }

  public function destroy(Book $book)
{
    $book->delete();
    return response()->json(['message' => 'Book deleted successfully.']);
}
}