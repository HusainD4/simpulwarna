<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Theme;

class ThemeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $themes = Theme::query()
            ->when($request->q, function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->q . '%')
                      ->orWhere('folder', 'like', '%' . $request->q . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('dashboard.themes.index', [
            'themes' => $themes,
            'q' => $request->q,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.themes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'folder' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        if($request->status === 'active') {
            Theme::where('status', 'active')->update(['status' => 'inactive']);
        }

        $theme = new Theme();
        $theme->name = $request->name;
        $theme->description = $request->description;
        $theme->folder = $request->folder;
        $theme->status = $request->has('status') ? 'active' : 'inactive';;
        $theme->save();

        return redirect()->route('themes.index')->with('successMessage', 'Theme created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $theme = Theme::findOrFail($id);
        return view('dashboard.themes.show', compact('theme'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $theme = Theme::findOrFail($id);
        return view('dashboard.themes.edit', compact('theme'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'folder' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        if($request->status === 'active') {
            Theme::where('status', 'active')->update(['status' => 'inactive']);
        }

        $theme = Theme::findOrFail($id);
        $theme->update($request->all());

        return redirect()->route('themes.index')->with('successMessage', 'Theme updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $theme = Theme::findOrFail($id);
        $theme->delete();

        return redirect()->route('themes.index')->with('success', 'Theme deleted successfully.');
    }
}
