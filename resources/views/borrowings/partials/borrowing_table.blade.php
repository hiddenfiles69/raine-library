<table class="table table-bordered" id="borrowingsTable">
    <thead>
        <tr>
            <th>Patron Name</th>
            <th>Book Name</th>
            <th>Date Borrowed</th>
            <th>Date Due</th>
            <th>Returned</th>
            <th>Date Returned</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($borrowings as $borrowing)
            <tr id="borrowing-row-{{ $borrowing->id }}">
                <td>{{ $borrowing->patron->patronname }}</td>
                <td>{{ $borrowing->book->bookname }}</td>
                <td>{{ $borrowing->dateborrowed }}</td>
                <td>{{ $borrowing->due_date }}</td>
                <td>{{ $borrowing->is_returned ? 'Yes' : 'No' }}</td>
                <td>{{ $borrowing->datereturned ?? 'N/A' }}</td>
                <td class="action-btn">
                    <a href="{{ route('borrowings.edit', $borrowing->id) }}" class="edit-btn"><i class="bi bi-pencil-square"></i></a>
                    <button class="delete-btn" data-id="{{ $borrowing->id }}"><i class="bi bi-trash-fill"></i></button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
{{ $borrowings->withQueryString()->links('pagination::bootstrap-5') }}