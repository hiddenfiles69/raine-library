@extends('layouts.app')

@section('title', 'Patrons')

@push('head')
     <link href="{{ asset('css/index.css') }}" rel="stylesheet">
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

@section('content')


<div class="container">
    <div class="headings"> 
         <h1> Patron Lists </h1>
        <div class="headings-row"> 
            <a href="{{ route('patrons.create') }}" class="add-btn"><i class="bi bi-plus-lg"></i> Add Patron</a>
                <form method="GET" action="{{ route('patrons.index') }}" id="search-form">
        
                <div class="input-group">
                <input 
                    type="text" 
                    name="search" 
                    class="form-control" 
                    placeholder="Search patrons..." 
                    value="{{ request('search') }}"
                >
                
            </div>
            <button class="search-btn" type="submit"> <i class="bi bi-search"></i></button>
            </form>
        </div>
    </div>
     </div> 

    <div style="margin-top: 30px;" id="patrons-table-container"> 
    @include('patrons.partials.patron_table', ['patrons' => $patrons])
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

    fetch("{{ route('patrons.index') }}?" + params, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
        }
    })
    .then(response => response.text())
    .then(html => {
        document.querySelector('#patrons-table-container').innerHTML = html;
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
                const patronId = this.getAttribute('data-id');
                if (!patronId) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Patron ID not found.',
                    });
                    return;
                }

                Swal.fire({
                    title: 'Are you sure?',
                    text: 'Do you want to delete this patron?',
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
                            fetch(`{{ route('patrons.destroy', '') }}/${patronID}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': csrfToken,
                                    'Accept': 'application/json',
                                    'Content-Type': 'application/json',
                                },
                            })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Failed to delete patron.');
                            }
                            return response.json();
                        })
                        .then(data => {
                            const row = document.getElementById(`patron-row-${patronId}`);
                            if (row) row.remove();
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'success',
                                title: data.message || 'Patron deleted successfully.',
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
                                text: error.message || 'Error deleting patron.',
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



