<div class="container">
    <h2>Edit Teacher and Subjects</h2>

    <form action="{{ route('teachers.update', $teacher->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Teacher Name -->
        <div class="mb-3">
            <label for="teacher_name" class="form-label">Teacher Name</label>
            <input type="text" name="name" id="teacher_name" class="form-control" value="{{ old('name', $teacher->name) }}" required>
        </div>

        <h4>Subjects</h4>
        <div id="subjects-section">
            @foreach ($teacher->subjects as $index => $subject)
            <div class="subject-item mb-3" data-index="{{ $index }}">
                <!-- Shift Dropdown -->
                <label for="subject_shift_{{ $index }}" class="form-label">Shift</label>
                <select name="subjects[{{ $index }}][shift]" id="subject_shift_{{ $index }}" class="form-control">
                    <option value="">Select Shift</option>
                    <option value="Morning" {{ old('subjects.' . $index . '.shift', $subject->shift) == 'Morning' ? 'selected' : '' }}>Morning</option>
                    <option value="Afternoon" {{ old('subjects.' . $index . '.shift', $subject->shift) == 'Afternoon' ? 'selected' : '' }}>Afternoon</option>
                    <option value="Evening" {{ old('subjects.' . $index . '.shift', $subject->shift) == 'Evening' ? 'selected' : '' }}>Evening</option>
                </select>

                <!-- Subject Name -->
                <label for="subject_name_{{ $index }}" class="form-label">Subject Name</label>
                <input type="text" name="subjects[{{ $index }}][subject_name]" id="subject_name_{{ $index }}" class="form-control" value="{{ old('subjects.' . $index . '.subject_name', $subject->subject_name) }}" required>

                <input type="hidden" name="subjects[{{ $index }}][id]" value="{{ $subject->id }}">

                <button type="button" class="btn btn-danger remove-subject mt-2">Remove</button>
            </div>
            @endforeach
        </div>

        <button type="button" class="btn btn-secondary" id="add-subject">Add Subject</button>
        <button type="submit" class="btn btn-primary mt-3">Update</button>
    </form>
</div>

<!-- JavaScript for Dynamic Add/Remove -->
<script>
    document.getElementById('add-subject').addEventListener('click', function() {
        let index = document.querySelectorAll('.subject-item').length;
        let template = `
            <div class="subject-item mb-3" data-index="${index}">
                <label for="subject_shift_${index}" class="form-label">Shift</label>
                <select name="subjects[${index}][shift]" id="subject_shift_${index}" class="form-control">
                    <option value="">Select Shift</option>
                    <option value="Morning">Morning</option>
                    <option value="Afternoon">Afternoon</option>
                    <option value="Evening">Evening</option>
                </select>

                <label for="subject_name_${index}" class="form-label">Subject Name</label>
                <input type="text" name="subjects[${index}][subject_name]" id="subject_name_${index}" class="form-control" required>

                <button type="button" class="btn btn-danger remove-subject mt-2">Remove</button>
            </div>
        `;
        document.getElementById('subjects-section').insertAdjacentHTML('beforeend', template);
    });

    document.getElementById('subjects-section').addEventListener('click', function(event) {
        if (event.target.classList.contains('remove-subject')) {
            event.target.closest('.subject-item').remove();
        }
    });
</script>
