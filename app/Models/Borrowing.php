<?php

namespace App\Models;

use App\Models\Book;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Borrowing extends Model
{
    use HasFactory;
        
    protected $fillable = [
        'patron_id', 'book_id', 'dateborrowed', 'datereturned', 'is_returned', 'due_date'
    ];

    /**
     * Get the patron that owns the borrowing.
     */
    public function patron()
    {
        return $this->belongsTo(Patron::class);
    }

    /**
     * Get the book that was borrowed.
     */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}