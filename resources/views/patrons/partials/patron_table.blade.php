    <table class="table table-bordered"  id="patronsTable">
    <thead>
        <tr>
            <th>Patron Name</th>
            <th>Email</th>
            <th>Address</th>
            <th>Contact Number</th>
            <th>Actions</th>

        </tr>
    </thead>
    <tbody>
        @foreach ($patrons as $patron)
            <tr id="patron-row-{{ $patron->id }}">
                <td>{{ $patron->patronname }}</td>
                <td>{{ $patron->email }}</td>
                <td>{{ $patron->address }}</td>
                <td>{{ $patron->phonenumber }}</td>
                <td class="action-btn">
                    <a href="{{ route('patrons.edit', $patron->id) }}" class="edit-btn"><i class="bi bi-pencil-square"></i></a>
                    <button class="delete-btn" data-id="{{ $patron->id }}"><i class="bi bi-trash-fill"></i></button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
{{ $patrons->withQueryString()->links('pagination::bootstrap-5') }}