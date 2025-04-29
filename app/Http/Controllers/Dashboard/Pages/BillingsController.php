<?php

namespace App\Http\Controllers\Dashboard\Pages;

use App\Http\Controllers\BaseController;
use App\Models\Billings;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BillingsController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        return view('dashboard.pages.billings.index', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->componentResponse(view('dashboard.pages.billings.modal.create'));
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

        Billings::create($request->all());
        return $this->modalToastResponse('Billings created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $billings = Billings::find($id);
        return $this->componentResponse(view('dashboard.pages.billings.modal.show', compact('billings')));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $billings = Billings::find($id);
        return $this->componentResponse(view('dashboard.pages.billings.modal.edit', compact('billings')));
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

        $billings = Billings::find($request->id);
        $billings->update($request->all());
        return $this->modalToastResponse('Billings updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $billings = Billings::find($id);
        $billings->delete();
        return response()->json(['message' => 'Billings deleted successfully']);
    }

    public function datatable(Request $request)
    {
        $search = request()->get('search');
        $value = isset($search['value']) ? $search['value'] : null;

        $billingss = Billings::select(
            'id',
            'menu_id',
            'final_price',
            'created_at',
        )
            ->when($value, function ($query) use ($value) {
                return $query->where(function ($query) use ($value) {
                    $query->where('menu_id', 'like', '%' . $value . '%')
                        ->orWhere('final_price', 'like', '%' . $value . '%');
                });
            });

        return DataTables::of($billingss->latest())
            ->editColumn('created_at', function ($billings) {
                return $billings->created_at->diffForHumans();
            })
            // ... existing code ...
            ->editColumn('menu_id', function ($billings) {
                $menuIds = $billings->menu_id;
                if (!is_array($menuIds)) {
                    $menuIds = [$menuIds];
                }
                $menus = \App\Models\Menu::whereIn('id', $menuIds)->pluck('name')->toArray();
                if (empty($menus)) {
                    return '<span class="badge badge-light-secondary">Unknown</span>';
                }
                return collect($menus)->map(function ($name) {
                    return '<span class="badge badge-light-primary">' . e($name) . '</span>';
                })->implode(' ');
            })
            ->addColumn('actions', function ($billings) {
                return actionButtons($billings->id);
            })
            ->rawColumns(['menu_id', 'actions'])
            ->make(true);
    }
}
