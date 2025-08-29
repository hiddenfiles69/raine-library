<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\PatronController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LibrarianController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Home page route
    Route::get('/', function () {
        return view('welcome');
    }); 

// Authentication Routes
    Route::get("register", [AuthController::class, 'register'])->name('register');
    Route::post("register", [AuthController::class, 'registerUser'])->name('register.user');
    Route::get("login", [AuthController::class, 'login'])->name('login');
    Route::post("login", [AuthController::class, 'loginUser'])->name('login.user');

// Routes that require authentication
    Route::middleware('auth')->group(function () {
    // Dashboard route
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Resource routes (they have .index, .create, etc. automatically)
    Route::resource('books', BookController::class);
    Route::resource('patrons', PatronController::class);
    Route::resource('librarians', LibrarianController::class);
    Route::resource('borrowings', BorrowingController::class);
    
    // Logout route
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::delete('/books/{book}', [BookController::class, 'destroy'])->name('books.destroy');
    Route::delete('/patrons/{patron}', [PatronController::class, 'destroy'])->name('patrons.destroy');
    Route::delete('/librarians/{librarian}', [LibrarianController::class, 'destroy'])->name('librarians.destroy');
    Route::delete('/borrowings/{borrowing}', [BorrowingController::class, 'destroy'])->name('borrowings.destroy');
});