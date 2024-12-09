
<div class="container">
    <h1>Create New Course</h1>

    <!-- Display Validation Errors -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('courses.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Course Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label for="campus_id" class="form-label">Campus</label>
            <select class="form-control" id="campus_id" name="campus_id" required>
                <option value="" disabled selected>Select Campus</option>
                <!-- Assuming you pass $campuses from the controller -->
                @foreach ($campuses as $campus)
                    <option value="{{ $campus->id }}" {{ old('campus_id') == $campus->id ? 'selected' : '' }}>
                        {{ $campus->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="start_date" class="form-label">Start Date</label>
            <input type="date" class="form-control" id="start_date" name="start_date" value="{{ old('start_date') }}" required>
        </div>

        <div class="mb-3">
            <label for="card_img" class="form-label">Card Image</label>
            <input type="file" class="form-control" id="card_img" name="card_img" required>
        </div>

        <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <select name="category" id="category">
                <option value="">--select category-----</option>
                <option value="firstaid" {{old('category')=='firstaid'?'selected':''}}>Firstaid</option>
                <option value="general" {{old('category')=='general'?'selected':''}}>General</option>
            </select>
            <!-- <input type="text" class="form-control" id="category" name="category" value="{{ old('category') }}" required> -->
        </div>
        <h4>Deliveries</h4>
        <div id="deliveries-section">
            <div class="delivery-item">
                <div class="mb-3">
                    <label for="delivery_name_0" class="form-label">Delivery Name</label>
                    <select name="deliveries[0][name]" id="delivery_name_0" class="form-control" required>
                        <option value="Domestic">Domestic</option>
                        <option value="International">International</option>
                        <option value="Onshore">Onshore</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="delivery_slug_0" class="form-label">Delivery Slug</label>
                    <input type="text" name="deliveries[0][slug]" id="delivery_slug_0" class="form-control" required>
                </div>
                <button type="button" class="btn btn-danger remove-delivery">Remove</button>
            </div>
        </div>
        <button type="button" class="btn btn-secondary" id="add-delivery">Add Delivery</button>

        <button type="submit" class="btn btn-primary">Create Course</button>
    </form>
</div>

<script>
    let deliveryCount = 1;

    document.getElementById('add-delivery').addEventListener('click', function () {
        const section = document.getElementById('deliveries-section');
        const newDelivery = document.createElement('div');
        newDelivery.classList.add('delivery-item');

        newDelivery.innerHTML = `
            <div class="mb-3">
                <label for="delivery_name_${deliveryCount}" class="form-label">Delivery Name</label>
                <select name="deliveries[${deliveryCount}][name]" id="delivery_name_${deliveryCount}" class="form-control" required>
                    <option value="Domestic">Domestic</option>
                    <option value="International">International</option>
                    <option value="Onshore">Onshore</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="delivery_slug_${deliveryCount}" class="form-label">Delivery Slug</label>
                <input type="text" name="deliveries[${deliveryCount}][slug]" id="delivery_slug_${deliveryCount}" class="form-control" required>
            </div>
            <button type="button" class="btn btn-danger remove-delivery">Remove</button>

        `;
        section.appendChild(newDelivery);
        deliveryCount++;
        attachRemoveDeliveryListeners();
    });
    function attachRemoveDeliveryListeners() {
        document.querySelectorAll('.remove-delivery').forEach(button => {
            button.removeEventListener('click', handleRemoveDelivery); // Remove previous listener if any
            button.addEventListener('click', handleRemoveDelivery);
        });
    }

    function handleRemoveDelivery(event) {
        const deliveryItem = event.target.closest('.delivery-item');
        if (deliveryItem) {
            deliveryItem.remove();
        }
    }

    // Attach remove functionality to the initial remove button
    attachRemoveDeliveryListeners();
</script>