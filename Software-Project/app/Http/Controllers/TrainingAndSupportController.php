<?php

namespace App\Http\Controllers;

use App\Models\TrainingAndSupport;
use Illuminate\Http\Request;

class TrainingAndSupportController extends Controller
{
    // Display a list of training and support items
    public function indexView()
    {
        $trainings = TrainingAndSupport::all();
        return view('training_support.index', compact('trainings'));
    }

    // Show form to create a new training or support item
    public function createView()
    {
        return view('training_support.create');
    }

    // Handle storing a new training or support item
    public function store(Request $request)
    {
        $validated = $request->validate([
            'knowledge_base' => 'required|string|max:255',
        ]);

        TrainingAndSupport::create($validated);

        return redirect()->route('training_support.index')->with('success', 'Training/Support item created successfully!');
    }

    // Show details of a specific training or support item
    public function showView($id)
    {
        $training = TrainingAndSupport::findOrFail($id);
        return view('training_support.show', compact('training'));
    }
}

