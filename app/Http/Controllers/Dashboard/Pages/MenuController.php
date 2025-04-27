<?php

namespace App\Http\Controllers\Dashboard\Pages;

use App\Http\Controllers\BaseController;
use App\Models\Category;
use App\Models\Menu;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MenuController extends BaseController
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:menu-view-all')->only('index');
        $this->middleware('permission:menu-create')->only('create');
        $this->middleware('permission:menu-edit')->only('edit');
        $this->middleware('permission:menu-delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumbs = [
            ['title' => 'Dashboard', 'url' => route('dashboard.index')],
            ['title' => 'Menu', 'url' => route('dashboard.menus.index')],
        ];
        $user = auth()->user();
        return view('dashboard.pages.menu.index', compact('user', 'breadcrumbs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return $this->componentResponse(view('dashboard.pages.menu.modal.create', compact('categories')));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $menu = Menu::create($request->all());

        // Handle image upload using Spatie Media Library
        if ($request->hasFile('image')) {
            $menu->addMedia($request->file('image'))
                ->toMediaCollection('image');
        }

        return $this->modalToastResponse('Menu created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $menu = Menu::find($id);
        return $this->componentResponse(view('dashboard.pages.menu.modal.show', compact('menu')));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $menu = Menu::find($id);
        $categories = Category::all();
        return $this->componentResponse(view('dashboard.pages.menu.modal.edit', compact('menu', 'categories')));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $menu = Menu::find($request->id);
        $menu->update($request->all());

        // Handle image upload using Spatie Media Library
        if ($request->hasFile('image')) {
            $menu->addMedia($request->file('image'))
                ->toMediaCollection('image');
        }

        return $this->modalToastResponse('Menu updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $menu = Menu::find($id);
        $menu->delete();
        return response()->json(['message' => 'Menu deleted successfully']);
    }

    public function datatable(Request $request)
    {
        $search = request()->get('search');
        $value = isset($search['value']) ? $search['value'] : null;

        $menus = Menu::with('category', 'media')
            ->select(
                'id',
                'name',
                'description',
                'category_id',
                'price',
                'created_at',
            )
            ->when($value, function ($query) use ($value) {
                return $query->where(function ($query) use ($value) {
                    $query->where('name', 'like', '%' . $value . '%')
                        ->orWhere('description', 'like', '%' . $value . '%')
                        ->orWhere('category_id', 'like', '%' . $value . '%')
                        ->orWhere('price', 'like', '%' . $value . '%');
                });
            });

        return DataTables::of($menus->latest())
            ->editColumn('category_id', function ($menu) {
                return $menu->category->name;
            })
            ->editColumn('created_at', function ($menu) {
                return $menu->created_at->diffForHumans();
            })

            ->addColumn('image', function ($menu) {
                return $menu->getImageAttribute();
            })
            ->make(true);
    }
}
