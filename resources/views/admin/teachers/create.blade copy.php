<div class="container">
    <h2>Add Teacher and Subjects</h2>

    <form action="{{ route('teachers.store') }}" method="POST">
        @csrf

        <!-- Teacher Name -->
        <div class="mb-3">
            <label for="teacher_name" class="form-label">Teacher Name</label>
            <input type="text" name="name" id="teacher_name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <h4>Subjects</h4>
        <div id="subjects-section">
            @forelse (old('subjects', [null]) as $index => $subject)
            <div class="subject-item mb-3" data-index="{{ $index }}">
                <!-- Shift Dropdown -->
                <label for="subject_shift_{{ $index }}" class="form-label">Shift</label>
                <select name="subjects[{{ $index }}][shift]" id="subject_shift_{{ $index }}" class="form-control">
                    <option value="">Select Shifts</option>
                    <option value="Morning" {{ ($subject['shift'] ?? '') == 'Morning' ? 'selected' : '' }}>Morning</option>
                    <option value="Afternoon" {{ ($subject['shift'] ?? '') == 'Afternoon' ? 'selected' : '' }}>Afternoon</option>
                    <option value="Evening" {{ ($subject['shift'] ?? '') == 'Evening' ? 'selected' : '' }}>Evening</option>
                </select>

                <!-- Subject Name -->
                <label for="subject_name_{{ $index }}" class="form-label">Subject Name</label>
                <input type="text" name="subjects[{{ $index }}][subject_name]" id="subject_name_{{ $index }}" class="form-control" value="{{ $subject['subject_name'] ?? '' }}" required>

                <button type="button" class="btn btn-danger remove-subject mt-2">Remove</button>
            </div>
            @empty
            <!-- Default empty row when no old input -->
            <div class="subject-item mb-3" data-index="0">
                <p>helooooooooooooooooo</p>
                <!-- Shift Dropdown -->
                <label for="subject_shift_0" class="form-label">Shift</label>
                <select name="subjects[0][shift]" id="subject_shift_0" class="form-control">
                    <option value="">Select Shiftssssssssssssss</option>
                    <option value="Morning">Morning</option>
                    <option value="Afternoon">Afternoon</option>
                    <option value="Evening">Evening</option>
                </select>

                <!-- Subject Name -->
                <label for="subject_name_0" class="form-label">Subject Name</label>
                <input type="text" name="subjects[0][subject_name]" id="subject_name_0" class="form-control" required>

                <button type="button" class="btn btn-danger remove-subject mt-2">Remove</button>
            </div>
            @endforelse
        </div>

        <button type="button" class="btn btn-secondary" id="add-subject">Add Subject</button>
        <button type="submit" class="btn btn-primary mt-3">Save</button>
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
