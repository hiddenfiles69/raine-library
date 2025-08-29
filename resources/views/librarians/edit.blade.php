@extends('layouts.app')

@section('title', 'Edit Librarians')

@push('head')
    <link href="{{ asset('css/index.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="container" style="margin-top: 30px;">
        <h1 style="text-align: center;">Edit Librarian</h1>

        <div class="create-form"> 
            <form action="{{ route('librarians.update', $librarian->id) }}" method="POST" autocomplete="off" class="librarian-form">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="librarianname">Name</label>
                    <input type="text" id="librarianname" name="librarianname" value="{{ $librarian->librarianname }}" placeholder="Enter librarian name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ $librarian->email }}" placeholder="Enter email" required>
                </div>
                <div class="form-group">
                    <label for="phonenumber">Phone</label>
                    <input type="text" id="phonenumber" name="phonenumber" value="{{ $librarian->phonenumber }}" placeholder="Enter phone number" required>
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" id="address" name="address" value="{{ $librarian->address }}" placeholder="Enter address" required>
                </div>
                <div class="action-buttons"> 
                    <a href="{{ route('librarians.index') }}" class="cancel-btn">Cancel</a>
                    <button type="submit" class="update-btn">Update Librarian</button>
                </div>
            </form>
        </div>
    </div>

@endsection