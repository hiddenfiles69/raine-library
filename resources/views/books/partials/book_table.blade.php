    <table class="table table-bordered"  id="booksTable">
    <thead>
        <tr>
            <th>Book Name</th>
            <th>Author</th>
            <th>Genre</th>
            <th>Publisher</th>
            <th>Publication Year</th>
            <th>Available Copies</th>
            <th>Actions</th>

        </tr>
    </thead>
    <tbody>
        @foreach ($books as $book)
            <tr id="book-row-{{ $book->id }}">
                <td>{{ $book->bookname }}</td>
                <td>{{ $book->author }}</td>
                <td>{{ $book->genre }}</td>
                <td>{{ $book->publisher }}</td>
                <td>{{ $book->publication_year }}</td>
                <td>{{ $book->available_copies }}</td>
                <td class="action-btn">
                    <a href="{{ route('books.edit', $book->id) }}" class="edit-btn"><i class="bi bi-pencil-square"></i></a>
                    <button class="delete-btn" data-id="{{ $book->id }}"><i class="bi bi-trash-fill"></i></button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
{{ $books->withQueryString()->links('pagination::bootstrap-5') }}