<form id="create-event-form" form-id="createForm" http-request route="{{ route('dashboard.events.store') }}"
    identifier="single-form-post-handler" feedback close-modal success-toast on-success="RDT">

    {{-- form fields ... --}}

    {{-- example form field --}}
    <div class="mb-3">
        <label for="title" class="form-label" placeholder="Title">Title</label>
        <input type="text" feedback-id="title-feedback" placeholder="Title..." class="form-control form-control-solid"
            name="title" id="title">
        <div id="title-feedback" class="invalid-feedback"></div>
    </div>

    <div class="mb-3">
        <label for="description" class="form-label" placeholder="Description">Description</label>
        <textarea class="form-control form-control-solid" feedback-id="description-feedback" placeholder="Description..."
            name="description" id="description"></textarea>
        <div id="description-feedback" class="invalid-feedback"></div>
    </div>

    <div class="mb-3">
        <label for="start_date" class="form-label" placeholder="Start Date">Start Date</label>
        <input type="datetime-local" feedback-id="start_date-feedback" placeholder="Start Date"
            class="form-control form-control-solid" name="start_date" id="start_date">
        <div id="start_date-feedback" class="invalid-feedback"></div>
    </div>

    <div class="mb-3">
        <label for="end_date" class="form-label">End Date</label>
        <input type="datetime-local" feedback-id="end_date-feedback" placeholder="End Date"
            class="form-control form-control-solid" name="end_date" id="end_date">
        <div id="end_date-feedback" class="invalid-feedback"></div>
    </div>



</form>
