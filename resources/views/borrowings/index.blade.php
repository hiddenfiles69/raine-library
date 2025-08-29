@extends('layouts.app')

@section('title', 'Borrowings')

@push('head')
     <link href="{{ asset('css/index.css') }}" rel="stylesheet">
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

@section('content')


<div class="container">
    <div class="headings"> 
        <h1> Borrowed Books Lists </h1>
        <div class="headings-row"> 
            <a href="{{ route('borrowings.create') }}" class="add-btn"><i class="bi bi-plus-lg"></i> Add Borrowing</a>
            <form method="GET" action="{{ route('borrowings.index') }}" id="search-form">
                <div class="input-group">
                    <input 
                        type="text" 
                        name="search" 
                        class="form-control" 
                        placeholder="Search by patron or book name..." 
                        value="{{ request('search') }}"
                    >
                </div>
                <button class="search-btn" type="submit"> <i class="bi bi-search"></i></button>
            </form>
        </div>
    </div>
</div> 

<div style="margin-top: 30px;" id="borrowings-table-container"> 
    @include('borrowings.partials.borrowing_table', ['borrowings' => $borrowings])
</div>


<script>
document.addEventListener('DOMContentLoaded', function() {
    const csrfToken = '{{ csrf_token() }}';

    @if(session('success'))
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 10000,
            timerProgressBar: true,
        });
    @endif

    // AJAX live search
    const searchForm = document.getElementById('search-form');
    searchForm.querySelector('input[name="search"]').addEventListener('input', function(e) {
    const query = e.target.value;
    performSearch(query);
});
function performSearch(query) {
    const params = new URLSearchParams({ search: query }).toString();

    fetch("{{ route('borrowings.index') }}?" + params, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
        }
    })
    .then(response => response.text())
    .then(html => {
        document.querySelector('#borrowings-table-container').innerHTML = html;
        attachDeleteEvents(); // re-attach delete buttons
    })
    .catch(error => {
        console.error(error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Failed to fetch search results.',
        });
    });
}

    // Attach delete events
    function attachDeleteEvents() {
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function() {
                const borrowingId = this.getAttribute('data-id');
                if (!borrowingId) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Borrowing ID not found.',
                    });
                    return;
                }

                Swal.fire({
                    title: 'Are you sure?',
                    text: 'Do you want to delete this borrowing?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#b40000',
                    cancelButtonColor: '#1C2A39',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                })
                    .then((result) => {
                        if (result.isConfirmed) {
                            // Updated fetch URL here
                            fetch(`{{ route('borrowings.destroy', '') }}/${borrowingId}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': csrfToken,
                                    'Accept': 'application/json',
                                    'Content-Type': 'application/json',
                                },
                            })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Failed to delete borrowing.');
                            }
                            return response.json();
                        })
                        .then(data => {
                            const row = document.getElementById(`borrowing-row-${borrowingId}`);
                            if (row) row.remove();
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'success',
                                title: data.message || 'Borrowing deleted successfully.',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                            });
                        })
                        .catch(error => {
                            console.error(error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: error.message || 'Error deleting borrowing.',
                            });
                        });
                    }
                });
            });
        });
    }

    attachDeleteEvents(); // initial attachment on page load
});
</script>

@endsection



