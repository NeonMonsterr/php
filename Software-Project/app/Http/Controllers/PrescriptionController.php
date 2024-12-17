<?php

namespace App\Http\Controllers;

use App\Models\Prescription;
use Illuminate\Http\Request;

class PrescriptionController extends Controller
{
    // Display a list of prescriptions
    public function indexView()
    {
        $prescriptions = Prescription::with(['medicines', 'client'])->get();
        return view('prescriptions.index', compact('prescriptions'));
    }

    // Show form to create a new prescription
    public function createView()
    {
        return view('prescriptions.create');
    }

    // Handle storing a new prescription
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pres_date' => 'required|date',
            'client_id' => 'required|exists:client_data,id',
        ]);

        Prescription::create($validated);

        return redirect()->route('prescriptions.index')->with('success', 'Prescription created successfully!');
    }

    // Show details of a specific prescription
    public function showView($id)
    {
        $prescription = Prescription::with(['medicines', 'client'])->findOrFail($id);
        return view('prescriptions.show', compact('prescription'));
    }
}

