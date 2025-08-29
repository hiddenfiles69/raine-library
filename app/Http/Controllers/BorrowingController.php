<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Patron;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class BorrowingController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $borrowings = Borrowing::with(['patron', 'book'])
            ->when($search, function ($query, $search) {
                $query->whereHas('patron', function($q) use ($search) {
                    $q->where('patronname', 'like', "%{$search}%");
                })->orWhereHas('book', function($q) use ($search) {
                    $q->where('bookname', 'like', "%{$search}%");
                })->orWhere('dateborrowed', 'like', "%{$search}%")
                ->orWhere('datereturned', 'like', "%{$search}%");
            })
            ->paginate(10)
            ->withQueryString();

        if ($request->ajax()) {
            // Correct partial view to render table rows
            return view('borrowings.partials.borrowing_table', ['borrowings' => $borrowings])->render();
        }

        return view('borrowings.index', compact('borrowings'));
    }

    public function create()
    {
        $patrons = Patron::all();
        $books = Book::all();
        return view('borrowings.create', compact('patrons', 'books'));
    }

    public function store(Request $request)
    {
        // Start a database transaction to ensure both operations succeed or fail together.
        try {
            DB::beginTransaction();

            // Find the book to be borrowed and check if copies are available
            $book = Book::find($request->input('book_id'));
            
            // Validate the request, including a check for available copies
            $request->validate([
                'patron_id' => 'required|exists:patrons,id',
                'book_id' => [
                    'required',
                    Rule::exists('books', 'id')->where(function ($query) use ($book) {
                        $query->where('available_copies', '>', 0);
                    }),
                ],
                'dateborrowed' => 'required|date',
                'due_date' => 'required|date',
                'is_returned' => 'nullable',
                'datereturned' => 'nullable|date',
            ], [
                'book_id.exists' => 'The selected book is not available for borrowing.'
            ]);

            // Create the new borrowing record
            $borrowing = new Borrowing;
            $borrowing->patron_id = $request->input('patron_id');
            $borrowing->book_id = $request->input('book_id');
            $borrowing->dateborrowed = $request->input('dateborrowed');
            $borrowing->due_date = $request->input('due_date');
            $borrowing->is_returned = $request->has('is_returned');
            $borrowing->datereturned = $request->input('datereturned');
            $borrowing->save();

            // Decrement the available copies of the book
            $book->decrement('available_copies');

            // Commit the transaction
            DB::commit();

            return redirect()->route('borrowings.index')->with('success', 'Borrowing created successfully.');

        } catch (\Exception $e) {
            // Rollback the transaction on any error
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'An error occurred. The borrowing could not be completed. Please try again.']);
        }
    }

    public function edit(Borrowing $borrowing)
    {
        $patrons = Patron::all();
        $books = Book::all();
        return view('borrowings.edit', compact('borrowing', 'patrons', 'books'));
    }

    public function update(Request $request, Borrowing $borrowing)
    {
        // Store the original book ID and return status
        $originalBookId = $borrowing->book_id;
        $originalIsReturned = $borrowing->is_returned;

        // Start a database transaction
        try {
            DB::beginTransaction();

            $request->validate([
                'patron_id' => 'required|exists:patrons,id',
                'book_id' => 'required|exists:books,id',
                'dateborrowed' => 'required|date',
                'due_date' => 'required|date',
                'is_returned' => 'nullable',
                'datereturned' => 'nullable|date',
            ]);
            
            // Update the borrowing record
            $borrowing->patron_id = $request->input('patron_id');
            $borrowing->book_id = $request->input('book_id');
            $borrowing->dateborrowed = $request->input('dateborrowed');
            $borrowing->due_date = $request->input('due_date');
            $borrowing->is_returned = $request->has('is_returned');
            $borrowing->datereturned = $request->input('datereturned');
            $borrowing->save();

            // Handle logic for book copy count
            if ($borrowing->book_id != $originalBookId) {
                // Book has been changed, increment old book's copies and decrement new book's
                Book::find($originalBookId)->increment('available_copies');
                Book::find($borrowing->book_id)->decrement('available_copies');
            }

            if ($borrowing->is_returned && !$originalIsReturned) {
                // Book was just returned, increment copies
                Book::find($borrowing->book_id)->increment('available_copies');
            } elseif (!$borrowing->is_returned && $originalIsReturned) {
                // Book was un-returned, decrement copies
                Book::find($borrowing->book_id)->decrement('available_copies');
            }

            DB::commit();

            return redirect()->route('borrowings.index')->with('success', 'Borrowing updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'An error occurred. The borrowing could not be updated. Please try again.']);
        }
    }

    public function destroy($id)
    {
        // Start a database transaction
        try {
            DB::beginTransaction();
            $borrowing = Borrowing::findOrFail($id);

            // Increment the available copies of the book ONLY if it was not already returned.
            // This prevents double-counting if the user deletes a record that was already marked as returned.
            if (!$borrowing->is_returned) {
                Book::find($borrowing->book_id)->increment('available_copies');
            }

            $borrowing->delete();

            DB::commit();

            return response()->json(['message' => 'Borrowing deleted successfully.']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'An error occurred. The borrowing could not be deleted.'], 500);
        }
    }
}