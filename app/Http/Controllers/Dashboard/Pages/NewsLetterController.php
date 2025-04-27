<?php

namespace App\Http\Controllers\Dashboard\Pages;

use App\Http\Controllers\BaseController;
use App\Models\NewsLetter;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class NewsLetterController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        return view('dashboard.pages.newsLetter.index', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->componentResponse(view('dashboard.pages.newsLetter.modal.create'));
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

        NewsLetter::create($request->all());
        return $this->modalToastResponse('NewsLetter created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $newsLetter = NewsLetter::find($id);
        return $this->componentResponse(view('dashboard.pages.newsLetter.modal.show', compact('newsLetter')));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $newsLetter = NewsLetter::find($id);
        return $this->componentResponse(view('dashboard.pages.newsLetter.modal.edit', compact('newsLetter')));
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

        $newsLetter = NewsLetter::find($request->id);
        $newsLetter->update($request->all());
        return $this->modalToastResponse('NewsLetter updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $newsLetter = NewsLetter::find($id);
        $newsLetter->delete();
        return response()->json(['message' => 'NewsLetter deleted successfully']);
    }

    public function datatable(Request $request)
    {
        $search = request()->get('search');
        $value = isset($search['value']) ? $search['value'] : null;

        $newsLetters = NewsLetter::select(
        'id',
        'email',
        'created_at',
        )
            ->when($value, function ($query) use ($value) {
                return $query->where(function ($query) use ($value) {
                    $query->where('email', 'like', '%' . $value . '%');
                });
            });

        return DataTables::of($newsLetters->latest())
            ->editColumn('created_at', function ($newsLetter) {
                return $newsLetter->created_at->diffForHumans();
            })
            ->make(true);
    }
}