

<div class="container">
    <h1>Add New Campus</h1>
    <form action="{{ route('campuses.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Campus Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="slug" class="form-label">Slug</label>
            <input type="text" name="slug" id="slug" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Create</button>
    </form>
</div>
