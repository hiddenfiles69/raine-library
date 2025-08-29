<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patron extends Model
{
    use HasFactory;
    
    protected $table = 'patrons'; 
    protected $fillable = [
        'patronname', 'email', 'phonenumber', 'address',
    ];

        public function borrowings()
    {
        return $this->hasMany(Borrowing::class, 'patronname', 'patronname');
    }

}
