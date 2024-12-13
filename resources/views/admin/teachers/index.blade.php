
<div class="container">
    <h2>Teachers List</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('teachers.create') }}" class="btn btn-primary mb-3">Add New Teacher</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Teacher Name</th>
                <th>Subjects</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($teachers as $teacher)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $teacher->name }}</td>
                    <td>
                        <ul>
                            @foreach ($teacher->subjects as $subject)
                                <li>
                                    <strong>{{ $subject->subject_name }}</strong> 
                                    ({{ $subject->shift }})
                                </li>
                            @endforeach
                        </ul>
                    </td>
                    <td>
                        <a href="{{ route('teachers.edit', $teacher->id) }}" class="btn btn-warning btn-sm">Edit</a>
                       
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">No teachers found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
