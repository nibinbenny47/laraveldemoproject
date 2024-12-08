<div class="container">
    <h1>Campuses</h1>
    <a href="{{ route('campuses.create') }}" class="btn btn-primary mb-3">Add New Campus</a>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($campuses->isEmpty())
        <p>No campuses found.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($campuses as $campus)
                    <tr>
                        <td>{{ $campus->id }}</td>
                        <td>{{ $campus->name }}</td>
                        <td>{{ $campus->slug }}</td>
                        <td>
                            <a href="{{ route('campuses.edit', $campus->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('campuses.destroy', $campus->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this campus?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
