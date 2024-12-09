
    <div class="container">
        <!-- Success Message -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Error Message -->
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <h1 class="mb-4">Courses</h1>

        <!-- Button to Create New Course -->
        <a href="{{ route('courses.create') }}" class="btn btn-primary mb-3">Add New Course</a>

        <!-- Courses Table -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Campus</th>
                    <th>Start Date</th>
                    <th>Category</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($courses as $course)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $course->name }}</td>
                        <td>{{ $course->campus->name }}</td> <!-- Assuming you have a campus relationship in the Course model -->
                        <td>{{ \Carbon\Carbon::parse($course->start_date)->format('d M Y') }}</td>
                        <td>{{ $course->category }}</td>
                        <td>
                        @if($course->card_img)
                            <img src="{{ asset($course->card_img) }}" alt="{{ $course->name }}" class="img-thumbnail" style="max-width: 100px; max-height: 100px;">
                        @else
                            <span>No image available</span>
                        @endif
                    </td>
                        
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No courses found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>
