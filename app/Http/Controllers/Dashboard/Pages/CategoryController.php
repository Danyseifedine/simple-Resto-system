<?php

namespace App\Http\Controllers\Dashboard\Pages;

use App\Http\Controllers\BaseController;
use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:category-view-all')->only('index');
        $this->middleware('permission:category-create')->only('create');
        $this->middleware('permission:category-edit')->only('edit');
        $this->middleware('permission:category-delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumbs = [
            ['title' => 'Dashboard', 'url' => route('dashboard.index')],
            ['title' => 'Categories', 'url' => route('dashboard.categories.index')],
        ];
        $user = auth()->user();
        return view('dashboard.pages.category.index', compact('user', 'breadcrumbs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->componentResponse(view('dashboard.pages.category.modal.create'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string'
        ]);

        Category::create($request->all());
        return $this->modalToastResponse('Category created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::find($id);
        return $this->componentResponse(view('dashboard.pages.category.modal.show', compact('category')));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::find($id);
        return $this->componentResponse(view('dashboard.pages.category.modal.edit', compact('category')));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string'
        ]);

        $category = Category::find($request->id);
        $category->update($request->all());
        return $this->modalToastResponse('Category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::find($id);
        $category->delete();
        return response()->json(['message' => 'Category deleted successfully']);
    }

    public function datatable(Request $request)
    {
        $search = request()->get('search');
        $value = isset($search['value']) ? $search['value'] : null;

        $categorys = Category::select(
            'id',
            'name',
            'created_at',
        )
            ->when($value, function ($query) use ($value) {
                return $query->where(function ($query) use ($value) {
                    $query->where('name', 'like', '%' . $value . '%');
                });
            });

        return DataTables::of($categorys->latest())
            ->editColumn('created_at', function ($category) {
                return $category->created_at->diffForHumans();
            })
            ->make(true);
    }
}
