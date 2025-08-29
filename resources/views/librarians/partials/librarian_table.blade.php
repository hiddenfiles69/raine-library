    <table class="table table-bordered"  id="librariansTable">
    <thead>
        <tr>
            <th>Librarian Name</th>
            <th>Email</th>
            <th>Address</th>
            <th>Contact Number</th>
            <th>Actions</th>

        </tr>
    </thead>
    <tbody>
        @foreach ($librarians as $librarian)
            <tr id="librarian-row-{{ $librarian->id }}">
                <td>{{ $librarian->librarianname }}</td>
                <td>{{ $librarian->email }}</td>
                <td>{{ $librarian->address }}</td>
                <td>{{ $librarian->phonenumber }}</td>
                <td class="action-btn">
                    <a href="{{ route('librarians.edit', $librarian->id) }}" class="edit-btn"><i class="bi bi-pencil-square"></i></a>
                    <button class="delete-btn" data-id="{{ $librarian->id }}"><i class="bi bi-trash-fill"></i></button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
{{ $librarians->withQueryString()->links('pagination::bootstrap-5') }}