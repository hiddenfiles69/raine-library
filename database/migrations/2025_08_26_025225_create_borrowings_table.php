<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('borrowings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patron_id')->constrained()->after('id');
            $table->foreignId('book_id')->constrained()->after('patron_id');
            $table->date('dateborrowed');
            $table->date('datereturned')->nullable();
            $table->boolean('is_returned')->default(false);
            $table->date('due_date');
            $table->timestamps();

        
            $table->unique(['patron_id', 'book_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrowings');
    }
};