

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="container">
    <h1>Campuses</h1>
    <a href="{{ route('campuses.create') }}" class="btn btn-primary mb-3">Add New Campus</a>
    
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
                           
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
