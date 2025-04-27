<?php

namespace App\Http\Controllers\Dashboard\Pages;

use App\Http\Controllers\BaseController;
use App\Models\Event;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class EventController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:event-view-all')->only('index');
        $this->middleware('permission:event-create')->only('create');
        $this->middleware('permission:event-edit')->only('edit');
        $this->middleware('permission:event-delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumbs = [
            ['title' => 'Dashboard', 'url' => route('dashboard.index')],
            ['title' => 'Events', 'url' => route('dashboard.events.index')],
        ];
        $user = auth()->user();
        return view('dashboard.pages.event.index', compact('user', 'breadcrumbs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->componentResponse(view('dashboard.pages.event.modal.create'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ], [
            'end_date.after' => 'End date must be greater than start date',
        ]);

        Event::create($request->all());
        return $this->modalToastResponse('Event created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $event = Event::find($id);
        return $this->componentResponse(view('dashboard.pages.event.modal.show', compact('event')));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $event = Event::find($id);
        return $this->componentResponse(view('dashboard.pages.event.modal.edit', compact('event')));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ], [
            'end_date.after' => 'End date must be greater than start date',
        ]);

        $event = Event::find($request->id);
        $event->update($request->all());
        return $this->modalToastResponse('Event updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $event = Event::find($id);
        $event->delete();
        return response()->json(['message' => 'Event deleted successfully']);
    }

    public function datatable(Request $request)
    {
        $search = request()->get('search');
        $value = isset($search['value']) ? $search['value'] : null;

        $events = Event::select(
            'id',
            'title',
            'description',
            'start_date',
            'end_date',
            'created_at',
        )
            ->when($value, function ($query) use ($value) {
                return $query->where(function ($query) use ($value) {
                    $query->where('title', 'like', '%' . $value . '%')
                        ->orWhere('description', 'like', '%' . $value . '%')
                        ->orWhere('start_date', 'like', '%' . $value . '%')
                        ->orWhere('end_date', 'like', '%' . $value . '%');
                });
            });

        return DataTables::of($events->latest())
            ->editColumn('created_at', function ($event) {
                return $event->created_at->diffForHumans();
            })
            ->make(true);
    }
}
