@extends('layouts.app')

@section('title', 'Dashboard')

@push('head')
     <link href="{{ asset('css/index.css') }}" rel="stylesheet">
@endpush

@section('content')
    <h1>Dashboard</h1>

   <div class="row" style="margin-top:40px;">
    <div class="col-md-4">
        <div class="card text-white mb-4" style="background-color: #212529;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="mb-0">{{ $totalBooks }}</h1>
                    <i class="bi bi-book-fill fs-1"></i>
                </div>
                <div class="mt-2">Total Books</div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a href="{{ route('books.index') }}" class="small text-white text-decoration-none">More Info</a>
                <span class="small text-white"><i class="bi bi-arrow-right"></i></span>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card text-white mb-4" style="background-color: #1c1e21;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="mb-0">{{ $totalPatrons }}</h1>
                    <i class="bi bi-person-fill fs-1"></i>
                </div>
                <div class="mt-2">Total Patrons</div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a href="{{ route('patrons.index') }}" class="small text-white text-decoration-none">More Info</a>
                <span class="small text-white"><i class="bi bi-arrow-right"></i></span>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card text-white mb-4" style="background-color: #16181b;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="mb-0">{{ $totalLibrarians }}</h1>
                    <i class="bi bi-person-lines-fill fs-1"></i>
                </div>
                <div class="mt-2">Total Librarians</div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a href="{{ route('patrons.index') }}" class="small text-white text-decoration-none">More Info</a>
                <span class="small text-white"><i class="bi bi-arrow-right"></i></span>
            </div>
        </div>
    </div>
</div>

<div class="row"> 

        <div class="col-md-4">
        <div class="card text-black mb-4" style="background-color: #ced4da;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="mb-0">{{ $totalBorrowedBooks }}</h1>
                    <i class="bi bi-card-checklist fs-1"></i>
                </div>
                <div class="mt-2">Total Borrowed Books</div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a href="{{ route('borrowings.index') }}" class="small text-black text-decoration-none">More Info</a>
                <span class="small text-black"><i class="bi bi-arrow-right"></i></span>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card text-black mb-4" style="background-color: #adb5bd;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="mb-0">{{ $returnedToday }}</h1>
                    <i class="bi bi-box-arrow-in-right fs-1"></i>
                </div>
                <div class="mt-2">Returned Today</div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a href="{{ route('borrowings.index') }}" class="small text-black text-decoration-none">More Info</a>
                <span class="small text-black"><i class="bi bi-arrow-right"></i></span>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card text-white mb-4" style="background-color: #495057;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="mb-0">{{ $borrowedToday }}</h1>
                    <i class="bi bi-box-arrow-right fs-1"></i>
                </div>
                <div class="mt-2">Borrowed Today</div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a href="{{ route('borrowings.index') }}" class="small text-white text-decoration-none">More Info</a>
                <span class="small text-white"><i class="bi bi-arrow-right"></i></span>
            </div>
        </div>
    </div>
</div>

<div class="container mt-5">

    <div class="card p-3 mb-4">
        <h4 class="card-title" style="margin-bottom:20px;">Urgent Alerts</h4>
        @if($overdueBorrowings->isEmpty())
            <p>No urgent alerts at this time.</p>
        @else
            @foreach($overdueBorrowings as $borrowing)
            <div class="alert-item d-flex align-items-center justify-content-between p-2 mb-2 rounded" style="border: 1px solid #dee2e6;">
                <div class="d-flex align-items-center">
                    <i class="bi bi-person-circle fs-3 me-3"></i>
                    <div>
                        <p class="mb-0 fw-bold">{{ $borrowing->book->title }}</p>
                        <small class="text-muted">{{ $borrowing->patron->patronname }}</small>
                    </div>
                </div>
                <div class="text-danger fw-bold">
                      Due {{ \Carbon\Carbon::parse($borrowing->due_date)->format('F j, Y') }}
                </div>
            </div>
            @endforeach
        @endif
    </div>
    
    </div>
@endsection