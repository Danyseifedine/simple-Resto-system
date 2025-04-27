<form id="create-menu-form" form-id="createForm" http-request route="{{ route('dashboard.menus.store') }}"
    identifier="single-form-post-handler" feedback close-modal success-toast on-success="RDT">

    {{-- form fields ... --}}

    {{-- example form field --}}
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" feedback-id="name-feedback" class="form-control form-control-solid" name="name"
            id="name">
        <div id="name-feedback" class="invalid-feedback"></div>
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control form-control-solid" feedback-id="description-feedback" name="description"
            id="description"></textarea>
        <div id="description-feedback" class="invalid-feedback"></div>
    </div>

    <div class="mb-3">
        <label for="category_id" class="form-label">Category</label>
        <select class="form-control form-control-solid" feedback-id="category_id-feedback" name="category_id"
            id="category_id">
            <option value="">Select Category</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
        <div id="category_id-feedback" class="invalid-feedback"></div>
    </div>

    <div class="mb-3">
        <label for="price" class="form-label">Price</label>
        <input type="number" feedback-id="price-feedback" class="form-control form-control-solid" name="price"
            id="price">
        <div id="price-feedback" class="invalid-feedback"></div>
    </div>

    <div class="mb-3">
        <label for="image" class="form-label">Image</label>
        <input type="file" feedback-id="image-feedback" class="form-control form-control-solid" name="image"
            id="image">
        <div id="image-feedback" class="invalid-feedback"></div>
    </div>


</form>
