@extends('layouts.app')

@section('title', 'Add Books')

@push('head')
    <link href="{{ asset('css/index.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="container" style="margin-top: 30px;">
        <h1 style="text-align: center;">Add New Book</h1>

        <div class="create-form"> 
            <form action="{{ route('books.store') }}" method="POST" autocomplete="off" class="book-form">
                @csrf 

                <div class="form-group">
                    <label for="bookname">Book Name</label>
                    <input type="text" id="bookname" name="bookname" placeholder="Enter book name" required>
                </div>
                <div class="form-group">
                    <label for="author">Author</label>
                    <input type="text" id="author" name="author" placeholder="Enter author name" required>
                </div>
                <div class="form-group">
                    <label for="genre">Genre</label>
                    <input type="text" id="genre" name="genre" placeholder="Enter genre" required>
                </div>
                <div class="form-group">
                    <label for="publisher">Publisher</label>
                    <input type="text" id="publisher" name="publisher" placeholder="Enter publisher name" required>
                </div>
                <div class="form-group">
                    <label for="publication_year">Publication Year</label>
                    <input type="number" id="publication_year" name="publication_year" placeholder="Enter publication year" required>
                </div>
                <div class="form-group">
                    <label for="available_copies">Available Copies</label>
                    <input type="number" id="available_copies" name="available_copies" placeholder="Enter available copies" required>
                </div>
                <div class="action-buttons"> 
                <a href="{{ route('books.index') }}" class="cancel-btn">Cancel</a>
                <button type="submit" class="create-btn">Add Book</button>
                </div>
            </form>
        </div>
    </div>

@endsection