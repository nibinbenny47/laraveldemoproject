<div class="container">
    <h1>Edit Campus</h1>

    <form action="{{ route('campuses.update', $campus->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Campus Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $campus->name }}" required>
        </div>

        <div class="mb-3">
            <label for="slug" class="form-label">Slug</label>
            <input type="text" name="slug" id="slug" class="form-control" value="{{ $campus->slug }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('campuses.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
