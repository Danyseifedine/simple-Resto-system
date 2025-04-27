<form id="edit-event-form" form-id="editForm" http-request route="{{ route('dashboard.events.update') }}"
    identifier="single-form-post-handler" feedback close-modal success-toast on-success="RDT">
    <input type="hidden" name="id" id="id" value="{{ $event->id }}">

    {{-- form fields ... --}}

    {{-- example form field --}}
    <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input type="text" value="{{ $event->title }}" feedback-id="title-feedback"
            class="form-control form-control-solid" name="title" id="title">
        <div id="title-feedback" class="invalid-feedback"></div>
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control form-control-solid" feedback-id="description-feedback" placeholder="Description..."
            name="description" id="description">{{ $event->description }}</textarea>
        <div id="description-feedback" class="invalid-feedback"></div>
    </div>

    <div class="mb-3">
        <label for="start_date" class="form-label">Start Date</label>
        <input type="datetime-local" value="{{ $event->start_date }}" feedback-id="start_date-feedback"
            class="form-control form-control-solid" name="start_date" id="start_date">
        <div id="start_date-feedback" class="invalid-feedback"></div>
    </div>

    <div class="mb-3">
        <label for="end_date" class="form-label">End Date</label>
        <input type="datetime-local" value="{{ $event->end_date }}" feedback-id="end_date-feedback"
            class="form-control form-control-solid" name="end_date" id="end_date">
        <div id="end_date-feedback" class="invalid-feedback"></div>
    </div>
</form>
