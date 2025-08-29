@extends('layouts.app')

@section('title', 'Edit Patrons')

@push('head')
    <link href="{{ asset('css/index.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="container" style="margin-top: 30px;">
        <h1 style="text-align: center;">Edit Patron</h1>

        <div class="create-form"> 
            <form action="{{ route('patrons.update', $patron->id) }}" method="POST" autocomplete="off" class="patron-form">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="patronname">Name</label>
                    <input type="text" id="patronname" name="patronname" value="{{ $patron->patronname }}" placeholder="Enter patron name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ $patron->email }}" placeholder="Enter email" required>
                </div>
                <div class="form-group">
                    <label for="phonenumber">Phone</label>
                    <input type="text" id="phonenumber" name="phonenumber" value="{{ $patron->phonenumber }}" placeholder="Enter phone number" required>
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" id="address" name="address" value="{{ $patron->address }}" placeholder="Enter address" required>
                </div>
                <div class="action-buttons"> 
                    <a href="{{ route('patrons.index') }}" class="cancel-btn">Cancel</a>
                    <button type="submit" class="update-btn">Update Patron</button>
                </div>
            </form>
        </div>
    </div>

@endsection