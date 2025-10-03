<?php

namespace App\Http\Controllers;

use App\Models\Level;
use App\Models\Stage;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    /**
     * Display a listing of levels.
     */
    public function index()
    {
        $levels = Level::with('stages')->paginate(10);
        $this->authorize('viewAny', Level::class);
        return view('levels.index', compact('levels'));
    }

    public function show(Level $level)
    {
         $level->load('stages');
         $this->authorize('view', $level);
        return view('levels.show',compact('level'));
    }

    /**
     * Show the form for creating a new level.
     */
    public function create()
    {
        $this->authorize('create', Level::class);
        return view('levels.create');
    }

    /**
     * Store a newly created level in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Level::class);
        $request->validate([
            'name' => 'required|string|max:255|unique:levels',
            'description' => 'nullable|string',
        ]);

        Level::create($request->only('name', 'description'));

        return redirect()->route('levels.index')->with('success', 'تمت إضافة المستوى بنجاح ✅');
    }

    /**
     * Show the form for editing the specified level.
     */
    public function edit(Level $level)
    {
        $this->authorize('update', $level);
        return view('levels.edit', compact('level'));
    }

    /**
     * Update the specified level in storage.
     */
    public function update(Request $request, Level $level)
    {
        $this->authorize('update', $level);
        $request->validate([
            'name' => 'required|string|max:255|unique:levels,name,' . $level->id,
            'description' => 'nullable|string',
        ]);

        $level->update($request->only('name', 'description'));

        return redirect()->route('levels.index')->with('success', 'تم تحديث المستوى بنجاح ✏️');
    }

    /**
     * Remove the specified level from storage.
     */
    public function destroy(Level $level)
    {
        $this->authorize('delete', $level);
        $level->delete();
        return redirect()->route('levels.index')->with('success', 'تم حذف المستوى بنجاح 🗑️');
    }
}
