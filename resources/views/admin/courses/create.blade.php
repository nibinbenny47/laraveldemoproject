@if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

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
            <input type="date" class="form-control" id="start_date" name="start_date" value="{{ old('start_date') }}"
                required>
        </div>

        <div class="mb-3">
            <label for="card_img" class="form-label">Card Image</label>
            <input type="file" class="form-control" id="card_img" name="card_img" required>
        </div>

        <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <select name="category" id="category">
                <option value="">--select category-----</option>
                <option value="firstaid" {{old('category') == 'firstaid' ? 'selected' : ''}}>Firstaid</option>
                <option value="general" {{old('category') == 'general' ? 'selected' : ''}}>General</option>
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

        <h4>Careers</h4>
        <div id="careers-section">
            <div class="career-item">
                <div class="mb-3">
                    <label for="career_name_0" class="form-label">Career name</label>
                    <input type="text" name="careers[0][name]" id="career_name_0" class="form-control" required>
                </div>
                <button type="button" class="btn btn-danger remove-career">Remove</button>
            </div>
        </div>
        <button type="button" class="btn btn-secondary" id="add-career">Add career</button>

        

        <h4>Fundings</h4>
        <div id="fundings-section">
            <div class="funding-item">
                <div class="mb-3">
                    <label for="funding_campus_0" class="form-label">Campus</label>
                    
                    <select name="fundings[0][campus_id]" id="funding_campus_0" class="form-control campus-dropdown" required>
                        <option value="">Select Campus</option>
                    </select>



                    
                </div>
                <div class="mb-3">
                    <label for="funding_fees_0" class="form-label">Fees</label>
                    <input type="number" name="fundings[0][fees]" id="funding_fees_0" class="form-control" required>
                </div>
                <div id="additional-details-0">
                    <h6>Additional Details</h6>
                    <div class="additional-detail-item">
                        <label for="funding_0_additional_detail_0" class="form-label">Detail</label>
                        <input type="text" name="fundings[0][additional_details][0][details]" id="funding_0_additional_detail_0" class="form-control">
                        <button type="button" class="btn btn-danger remove-additional-detail">Remove</button>
                    </div>
                </div>
                <button type="button" class="btn btn-secondary add-additional-detail" data-funding="0">Add Additional Detail</button>
                <button type="button" class="btn btn-danger remove-funding">Remove Funding</button>
            </div>
        </div>
        <button type="button" class="btn btn-secondary" id="add-funding">Add Funding</button>
        <button type="submit" class="btn btn-primary mt-3">Submit</button>
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

<script>
    let careerCount = 1;

    document.getElementById('add-career').addEventListener('click', function () {
        const section = document.getElementById('careers-section');
        const newcareer = document.createElement('div');
        newcareer.classList.add('career-item');

        newcareer.innerHTML = `
            <div class="mb-3">
                <label for="career_name_${careerCount}" class="form-label">Career name</label>
                <input type="text" name="careers[${careerCount}][name]" id="career_name_${careerCount}" class="form-control" required>
            </div>
            <button type="button" class="btn btn-danger remove-career">Remove</button>
        `;
        section.appendChild(newcareer);
        careerCount++;
        attachRemovecareerListeners();
    });

    function attachRemovecareerListeners() {
        document.querySelectorAll('.remove-career').forEach(button => {
            button.removeEventListener('click', handleRemovecareer); // Remove previous listener if any
            button.addEventListener('click', handleRemovecareer);
        });
    }

    function handleRemovecareer(event) {
        const careerItem = event.target.closest('.career-item');
        if (careerItem) {
            careerItem.remove();
        }
    }

    // Attach remove functionality to the initial remove button
    attachRemovecareerListeners();
</script>

<script>
    let fundingCount = 1;

    // Fetch campus data from the backend
    async function fetchCampuses() {
        const response = await fetch('{{ route("courses.fetchcampus") }}');
        return response.json();
    }

    // Populate campus dropdown with fetched data
    async function populateCampusDropdown(dropdown) {
        const campuses = await fetchCampuses();
        campuses.forEach(campus => {
            const option = document.createElement('option');
            option.value = campus.id;
            option.textContent = campus.name;
            dropdown.appendChild(option);
        });
    }

    document.getElementById('add-funding').addEventListener('click', function () {
        const section = document.getElementById('fundings-section');
        const newFunding = document.createElement('div');
        newFunding.classList.add('funding-item');
        newFunding.innerHTML = `
            <div class="mb-3">
                <label for="funding_campus_${fundingCount}" class="form-label">Campus</label>
                <select name="fundings[${fundingCount}][campus_id]" id="funding_campus_${fundingCount}" class="form-control campus-dropdown" required>
                    <option value="">Select Campus</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="funding_fees_${fundingCount}" class="form-label">Fees</label>
                <input type="number" name="fundings[${fundingCount}][fees]" id="funding_fees_${fundingCount}" class="form-control" required>
            </div>
            <div id="additional-details-${fundingCount}">
                <h6>Additional Details</h6>
                <div class="additional-detail-item">
                    <label for="funding_${fundingCount}_additional_detail_0" class="form-label">Detail</label>
                    <input type="text" name="fundings[${fundingCount}][additional_details][0][details]" id="funding_${fundingCount}_additional_detail_0" class="form-control">
                    <button type="button" class="btn btn-danger remove-additional-detail">Remove</button>

                </div>
            </div>
            <button type="button" class="btn btn-secondary add-additional-detail" data-funding="${fundingCount}">Add Additional Detail</button>
            <button type="button" class="btn btn-danger remove-funding">Remove Funding</button>
        `;
        section.appendChild(newFunding);

        const newCampusDropdown = newFunding.querySelector('.campus-dropdown');
        populateCampusDropdown(newCampusDropdown);

        fundingCount++;
        attachFundingListeners();
    });

    function attachFundingListeners() {
        document.querySelectorAll('.remove-funding').forEach(button => {
            button.addEventListener('click', function () {
                this.closest('.funding-item').remove();
            });
        });

        document.querySelectorAll('.add-additional-detail').forEach(button => {
            button.addEventListener('click', function () {
                const fundingId = this.dataset.funding;
                const detailsSection = document.getElementById(`additional-details-${fundingId}`);
                const detailCount = detailsSection.children.length - 1; // Exclude heading
                const newDetail = document.createElement('div');
                newDetail.classList.add('additional-detail-item');
                newDetail.innerHTML = `
                    <label for="funding_${fundingId}_additional_detail_${detailCount}" class="form-label">Detail</label>
                    <input type="text" name="fundings[${fundingId}][additional_details][${detailCount}][details]" id="funding_${fundingId}_additional_detail_${detailCount}" class="form-control">
                    <button type="button" class="btn btn-danger remove-additional-detail">Remove</button>
                `;
                detailsSection.appendChild(newDetail);
                attachRemoveAdditionalDetailListeners();
            });
        });
        attachRemoveAdditionalDetailListeners();
    }
    function attachRemoveAdditionalDetailListeners() {
        document.querySelectorAll('.remove-additional-detail').forEach(button => {
            button.addEventListener('click', function () {
                this.closest('.additional-detail-item').remove();
            });
        });
    }
    // Populate initial campus dropdowns
    document.querySelectorAll('.campus-dropdown').forEach(populateCampusDropdown);
    attachFundingListeners();
</script>