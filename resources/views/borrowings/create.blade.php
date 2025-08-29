@extends('layouts.app')

@section('title', 'Add Borrowing')

@push('head')
    <link href="{{ asset('css/index.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="container" style="margin-top: 30px;">
        <h1 style="text-align: center;">Add New Borrowing</h1>

        <div class="create-form"> 
            <form action="{{ route('borrowings.store') }}" method="POST" autocomplete="off" class="borrowing-form">
                @csrf 

                <div class="form-group">
                    <label for="patron_id">Patron Name</label>
                    <select id="patron_id" name="patron_id" required>
                        <option value="" disabled selected>Select an Existing Patron</option>
                        @foreach($patrons as $patron)
                            <option value="{{ $patron->id }}">{{ $patron->patronname }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="book_id">Book Name</label>
                    <select id="book_id" name="book_id" required>
                        <option value="" disabled selected>Select an Existing Book</option>
                        @foreach($books as $book)
                            <option value="{{ $book->id }}">{{ $book->bookname }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="dateborrowed">Date Borrowed</label>
                    <input type="date" id="dateborrowed" name="dateborrowed" required>
                </div>
                <div class="form-group">
                    <label for="due_date">Due Date</label>
                    <input type="date" id="due_date" name="due_date" required>
                </div>

                <div class="form-group form-check-inline">
                    <div class="checkbox-container"> 
                        <input type="checkbox" id="is_returned" name="is_returned" onchange="toggleDateReturned()">
                        <label for="is_returned" class="checkbox-label">Mark as Returned</label>
                    </div>
                </div>
                
                <div class="form-group" id="datereturned-group" style="display:none;">
                    <label for="datereturned">Date Returned</label>
                    <input type="date" id="datereturned" name="datereturned">
                </div>
                
                <div class="action-buttons"> 
                    <a href="{{ route('borrowings.index') }}" class="cancel-btn">Cancel</a>
                    <button type="submit" class="create-btn">Add Borrowing</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        function toggleDateReturned() {
            const isReturnedCheckbox = document.getElementById('is_returned');
            const dateReturnedGroup = document.getElementById('datereturned-group');
            if (isReturnedCheckbox.checked) {
                dateReturnedGroup.style.display = 'block';
                document.getElementById('datereturned').setAttribute('required', 'required');
            } else {
                dateReturnedGroup.style.display = 'none';
                document.getElementById('datereturned').removeAttribute('required');
            }
        }
    </script>
@endsection