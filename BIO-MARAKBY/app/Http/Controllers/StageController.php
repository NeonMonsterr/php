<?php

namespace App\Http\Controllers;

use App\Models\Level;
use App\Models\Stage;
use Illuminate\Http\Request;

class StageController extends Controller
{
    public function create(Level $level)
    {
        $this->authorize('create', Stage::class);
        return view('stages.create', compact('level'));
    }

    public function store(Request $request, Level $level)
    {
        $this->authorize('create', Stage::class);

        $request->validate([
            'name' => 'required|string|max:255|unique:stages',
            'description' => 'nullable|string',
        ]);

        $level->stages()->create($request->only('name', 'description'));

        return redirect()->route('levels.show', $level->id)
            ->with('success', 'تمت إضافة المرحلة بنجاح ✅');
    }

    public function edit(Level $level, Stage $stage)
    {
        $this->authorize('update', $stage);
        return view('stages.edit', compact('level', 'stage'));
    }

    public function update(Request $request, Level $level, Stage $stage)
    {
        $this->authorize('update', $stage);

        $request->validate([
            'name' => 'required|string|max:255|unique:stages,name,' . $stage->id,
            'description' => 'nullable|string',
        ]);

        $stage->update($request->only('name', 'description'));

        return redirect()->route('levels.show', $level->id)
            ->with('success', 'تم تحديث المرحلة بنجاح ✏️');
    }

    public function destroy(Level $level, Stage $stage)
    {
        $this->authorize('delete', $stage);

        $stage->delete();

        return redirect()->route('levels.show', $level->id)
            ->with('success', 'تم حذف المرحلة بنجاح 🗑️');
    }
}
