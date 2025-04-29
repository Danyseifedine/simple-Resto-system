<!---------------------------
    Layout
---------------------------->
@extends('dashboard.layout.index')

<!---------------------------
    Title
---------------------------->
@section('title', 'Billings')

<!---------------------------
    Toolbar
---------------------------->
@section('toolbar')
    @include('dashboard.common.toolbar', [
        'title' => 'Billings',
        'currentPage' => 'Billings Management',
    ])
@endsection

<!---------------------------
    Columns
---------------------------->

@php
$columns = ['menu_id', 'final_price', 'actions'];
@endphp

<!---------------------------
    Main Content
---------------------------->
@section('content')
    <x-lebify-table
    id="billingsTable"
    :columns="$columns"

    {{-- create="true"                         // BY DEFAULT TRUE
    selected="true"                            // BY DEFAULT TRUE
    filter="true"                              // BY DEFAULT TRUE
    showCheckbox="true"                        // BY DEFAULT TRUE
    showSearch="true"                          // BY DEFAULT TRUE
    showColumnVisibility="true"                // BY DEFAULT TRUE
    columnVisibilityPlacement="bottom-end"     // BY DEFAULT BOTTOM-END
    columnSettingsTitle="Column Settingss"     // BY DEFAULT COLUMN SETTINGS
    columnToggles=""                           // BY DEFAULT EMPTY
    tableClass="table-class"                   // BY DEFAULT EMPTY
    searchPlaceholder="Search..."              // BY DEFAULT SEARCH...
    selectedText="Selected"                    // BY DEFAULT SELECTED
    selectedActionButtonClass="btn-success"    // BY DEFAULT btn-danger
    selectedActionButtonText="Delete Selected" // BY DEFAULT DELETE SELECTED
    selectedAction=""                          // BY DEFAULT EMPTY
    --}}
    >


{{-- start Filter Options --}}

@section('filter-options')


     {{--  Filters... --}}

     {{-- example form field --}}
   {{-- <label class="form-check form-check-sm form-check-custom form-check-solid">
        <select class="form-select form-select-solid" data-control="select2" data-placeholder="Select Status" name="status">
            <option></option>
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
        </select>
    </label> --}}
@endsection
{{-- End Filter Options --}}

    </x-lebify-table>
@endsection


<!---------------------------
    Filter Options
---------------------------->


<!---------------------------
    Modals
---------------------------->
<x-lebify-modal modal-id="create-modal" size="lg" submit-form-id="createForm" title="Create"></x-lebify-modal>
<x-lebify-modal modal-id="edit-modal" size="lg" submit-form-id="editForm" title="Edit"></x-lebify-modal>
<x-lebify-modal modal-id="show-modal" size="lg" :show-submit-button="false" title="Show"></x-lebify-modal>

<!---------------------------
    Scripts
---------------------------->
@push('scripts')
    <script src="{{ asset('js/dashboard/billings.js') }}" type="module" defer></script>
@endpush
