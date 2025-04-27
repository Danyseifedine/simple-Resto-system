<form id="edit-contact-form" form-id="editForm" http-request route="{{ route('dashboard.contacts.update') }}"
    identifier="single-form-post-handler" feedback close-modal success-toast on-success="RDT">
    <input type="hidden" name="id" id="id" value="{{ $contact->id }}">

     {{-- form fields ... --}}

     {{-- example form field --}}
    {{-- <div class="mb-3">
        <label for="name" class="form-label">name</label>
        <input type="text" value="{{ $contact->name }}" feedback-id="name-feedback" class="form-control form-control-solid"
            name="name" id="name">
        <div id="name-feedback" class="invalid-feedback"></div>
    </div> --}}
</form>
