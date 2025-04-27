<form id="edit-category-form" form-id="editForm" http-request route="{{ route('dashboard.categories.update') }}"
    identifier="single-form-post-handler" feedback close-modal success-toast on-success="RDT">
    <input type="hidden" name="id" id="id" value="{{ $category->id }}">

    {{-- form fields ... --}}

    {{-- example form field --}}
    <div class="mb-3">
        <label for="name" class="form-label">name</label>
        <input type="text" value="{{ $category->name }}" feedback-id="name-feedback"
            class="form-control form-control-solid" name="name" id="name">
        <div id="name-feedback" class="invalid-feedback"></div>
    </div>
</form>
