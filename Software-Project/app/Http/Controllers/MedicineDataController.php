<?php

namespace App\Http\Controllers;

use App\Models\MedicineData;
use Illuminate\Http\Request;

class MedicineDataController extends Controller
{
    // Display a paginated list of medicines
    public function indexView()
    {
        $medicines = MedicineData::paginate(10); // Paginate results
        return view('medicines.index', compact('medicines'));
    }

    // Show form to create a new medicine
    public function createView()
    {
        return view('medicines.create');
    }

    // Handle storing a new medicine
    public function store(Request $request)
    {
        $validated = $request->validate([
            'batch_no' => 'required|string|max:50',
            'drug_name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'manufacturer' => 'required|string|max:255',
            'stock_qty' => 'required|integer|min:0',
            'expiry_date' => 'required|date|after:today',
        ]);

        MedicineData::create($validated);

        return redirect()->route('medicines.index')->with('success', 'Medicine created successfully!');
    }

    // Show details of a specific medicine
    public function showView($id)
    {
        $medicine = MedicineData::findOrFail($id);
        return view('medicines.show', compact('medicine'));
    }
}
