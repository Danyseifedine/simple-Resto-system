<?php

namespace App\Http\Controllers\Dashboard\Pages;

use App\Http\Controllers\BaseController;
use App\Models\Contact;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ContactController extends BaseController
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:contact-view-all')->only('index');
        $this->middleware('permission:contact-create')->only('create');
        $this->middleware('permission:contact-edit')->only('edit');
        $this->middleware('permission:contact-delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        return view('dashboard.pages.contact.index', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->componentResponse(view('dashboard.pages.contact.modal.create'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string',
        ]);

        Contact::create($request->all());
        return $this->modalToastResponse('Contact created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $contact = Contact::find($id);
        return $this->componentResponse(view('dashboard.pages.contact.modal.show', compact('contact')));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $contact = Contact::find($id);
        return $this->componentResponse(view('dashboard.pages.contact.modal.edit', compact('contact')));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string',
        ]);

        $contact = Contact::find($request->id);
        $contact->update($request->all());
        return $this->modalToastResponse('Contact updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $contact = Contact::find($id);
        $contact->delete();
        return response()->json(['message' => 'Contact deleted successfully']);
    }

    public function datatable(Request $request)
    {
        $search = request()->get('search');
        $value = isset($search['value']) ? $search['value'] : null;

        $contacts = Contact::select(
            'id',
            'subject',
            'message',
            'created_at',
        )
            ->when($value, function ($query) use ($value) {
                return $query->where(function ($query) use ($value) {
                    $query->where('subject', 'like', '%' . $value . '%')
                        ->orWhere('message', 'like', '%' . $value . '%');
                });
            });

        return DataTables::of($contacts->latest())
            ->editColumn('created_at', function ($contact) {
                return $contact->created_at->diffForHumans();
            })
            ->addColumn('actions', function ($contact) {
                return actionButtons($contact->id);
            })
            ->make(true);
    }
}
