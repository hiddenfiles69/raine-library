@extends('layouts.app')

@section('title', 'Edit Borrowing')

@push('head')
    <link href="{{ asset('css/index.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="container" style="margin-top: 30px;">
        <h1 style="text-align: center;">Edit Borrowing</h1>

        <div class="create-form"> 
            <form action="{{ route('borrowings.update', $borrowing->id) }}" method="POST" autocomplete="off" class="borrowing-form">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="patron_id">Patron Name</label>
                    <select id="patron_id" name="patron_id" required>
                        @foreach($patrons as $patron)
                            <option value="{{ $patron->id }}" {{ $patron->id == $borrowing->patron_id ? 'selected' : '' }}>
                                {{ $patron->patronname }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="book_id">Book Name</label>
                    <select id="book_id" name="book_id" required>
                        @foreach($books as $book)
                            <option value="{{ $book->id }}" {{ $book->id == $borrowing->book_id ? 'selected' : '' }}>
                                {{ $book->bookname }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="dateborrowed">Date Borrowed</label>
                    <input type="date" id="dateborrowed" name="dateborrowed" value="{{ $borrowing->dateborrowed }}" required>
                </div>
                <div class="form-group">
                    <label for="due_date">Due Date</label>
                    <input type="date" id="due_date" name="due_date" value="{{ $borrowing->due_date }}" required>
                </div>
                <div class="form-group form-check-inline">
                    <div class="checkbox-container"> 
                    <input type="checkbox" id="is_returned" name="is_returned" {{ $borrowing->is_returned ? 'checked' : '' }} onchange="toggleDateReturned()">
                    <label for="is_returned">Mark as Returned</label>
                </div>
                </div>
                <div class="form-group" id="datereturned-group" style="{{ $borrowing->is_returned ? 'display:block;' : 'display:none;' }}">
                    <label for="datereturned">Date Returned</label>
                    <input type="date" id="datereturned" name="datereturned" value="{{ $borrowing->datereturned }}" {{ $borrowing->is_returned ? 'required' : '' }}>
                </div>
                
                <div class="action-buttons"> 
                    <a href="{{ route('borrowings.index') }}" class="cancel-btn">Cancel</a>
                    <button type="submit" class="update-btn">Update Borrowing</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        function toggleDateReturned() {
            const isReturnedCheckbox = document.getElementById('is_returned');
            const dateReturnedGroup = document.getElementById('datereturned-group');
            const dateReturnedInput = document.getElementById('datereturned');
            if (isReturnedCheckbox.checked) {
                dateReturnedGroup.style.display = 'block';
                dateReturnedInput.setAttribute('required', 'required');
            } else {
                dateReturnedGroup.style.display = 'none';
                dateReturnedInput.removeAttribute('required');
            }
        }
    </script>
@endsection
