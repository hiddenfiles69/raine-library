@extends('layouts.app')

@section('title', 'Add Librarian')

@push('head')
    <link href="{{ asset('css/index.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="container" style="margin-top: 30px;">
        <h1 style="text-align: center;">Add New Librarian</h1>

        <div class="create-form"> 
            <form action="{{ route('librarians.store') }}" method="POST" autocomplete="off" class="librarian-form">
                @csrf

                <div class="form-group">
                    <label for="librarianname">Librarian Name</label>
                    <input type="text" id="librarianname" name="librarianname" placeholder="Enter librarian name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter email" required>
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" id="address" name="address" placeholder="Enter address" required>
                </div>
                <div class="form-group">
                    <label for="phonenumber">Contact Number</label>
                    <input type="text" id="phonenumber" name="phonenumber" placeholder="Enter contact number" required>
                </div>
                
                <div class="action-buttons"> 
                <a href="{{ route('librarians.index') }}" class="cancel-btn">Cancel</a>
                <button type="submit" class="create-btn">Add Librarian</button>
                </div>
            </form>
        </div>
    </div>

@endsection