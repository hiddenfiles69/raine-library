<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Book;
use App\Models\Patron;
use App\Models\Borrowing;
use App\Models\Librarian; // Make sure this is imported
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBooks = Book::count();
        $totalPatrons = Patron::count();
        $totalLibrarians = Librarian::count();
        $totalBorrowedBooks = Borrowing::count();
        $returnedToday = Borrowing::whereDate('datereturned', today())->count();
        $borrowedToday = Borrowing::whereDate('dateborrowed', today())->count();

        $overdueBorrowings = Borrowing::with('book', 'patron')
            ->where('due_date', '<', Carbon::now())
            ->whereNull('datereturned')
            ->get();

        // Pass all the variables to the view
        return view('dashboard', compact('totalBooks', 'totalPatrons', 'totalLibrarians', 'totalBorrowedBooks', 'returnedToday', 'borrowedToday', 'overdueBorrowings'));
    }
}