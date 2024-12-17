<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Inventory;
use App\Models\MedicineData;
use App\Models\PharmacyStaff;
use App\Models\Prescription;
use App\Models\TrainingAndSupport;
use Illuminate\Http\Request;

class PharmacyStaffController extends Controller
{
    public function index(Request $request)
{
    // Get paginated list of clients
    $clients = Client::paginate(10); // You can adjust the number of items per page

    return view('pharmacyStaff.index', compact('clients'));
}
public function showClient($id)
{
    $client = Client::with(['contactDetails', 'privateDetails', 'medicalHistory', 'prescriptions.medicines'])->findOrFail($id);

    return view('pharmacyStaff.showClient', compact('client'));
}

    public function createClient()
    {
        return view('pharmacyStaff.createClient'); // return the view for creating a new client
    }

    public function storeClient(Request $request)
    {
        // Validate the input data
        $validatedData = $request->validate([
            'Fname' => 'required|string|max:255',
            'Lname' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email',
            'password' => 'required|min:6|confirmed',
        ]);

        // Create the new client
        $validatedData['password'] = bcrypt($request->password); // Make sure password is hashed
        Client::create($validatedData);

        // Redirect back with a success message
        return redirect()->route('clients.index')->with('success', 'Client created successfully.');
    }
    public function editClient($id)
{
    $client = Client::findOrFail($id);  // Find the client by ID
    return view('pharmacyStaff.editClient', compact('client'));  // Return the edit view with the client data
}

public function updateClient(Request $request, $id)
{
    // Validate the input data
    $validatedData = $request->validate([
        'Fname' => 'required|string|max:255',
        'Lname' => 'required|string|max:255',
        'email' => 'required|email|unique:clients,email,' . $id,  // Ensure the email is unique, except for the current client
    ]);

    // Find and update the client
    $client = Client::findOrFail($id);
    $client->update($validatedData);

    // Redirect back with a success message
    return redirect()->route('clients.index')->with('success', 'Client updated successfully.');
}
public function createPrescription($clientId)
{
    $client = Client::findOrFail($clientId);
    $medicines = MedicineData::all(); // Fetch all available medicines
    return view('pharmacyStaff.createPrescription', compact('client', 'medicines'));
}

public function storePrescription(Request $request, $clientId)
{
    $request->validate([
        'pres_date' => 'required|date',
        'medicines' => 'required|array',
        'medicines.*' => 'exists:medicine_data,id',
    ]);

    $staffId = auth('staff')->id(); // Replace with appropriate authentication

    $prescription = Prescription::create([
        'client_id' => $clientId,
        'staff_id' => $staffId,
        'pres_date' => $request->pres_date,
    ]);

    $prescription->medicines()->attach($request->medicines);

    return redirect()->route('pharmacyStaff.clients.index')
        ->with('success', 'Prescription created successfully.');
}

public function editContactDetails($clientId)
{
    $client = Client::findOrFail($clientId);
    return view('pharmacyStaff.editContactDetails', compact('client'));  // Show form for editing contact details
}

public function updateContactDetails(Request $request, $clientId)
{
    // Validate the input data
    $validatedData = $request->validate([
        'phone_number' => 'nullable|string|max:15',
        'mobile_number' => 'nullable|string|max:15',
        'mailing_address' => 'nullable|string|max:255',
    ]);

    $client = Client::findOrFail($clientId);

    // Update the contact details
    if ($client->contactDetails) {
        $client->contactDetails->update($validatedData);
    } else {
        $client->contactDetails()->create($validatedData);
    }

    // Redirect back with a success message
    return redirect()->route('clients.show', $clientId)->with('success', 'Contact details updated successfully.');
}
public function editPrivateDetails($clientId)
{
    $client = Client::findOrFail($clientId);
    return view('pharmacyStaff.editPrivateDetails', compact('client'));  // Show form for editing private details
}

public function updatePrivateDetails(Request $request, $clientId)
{
    // Validate the input data
    $validatedData = $request->validate([
        'ssn' => 'nullable|string|max:15',
        'date_of_birth' => 'nullable|date',
    ]);

    $client = Client::findOrFail($clientId);

    // Update the private details
    if ($client->privateDetails) {
        $client->privateDetails->update($validatedData);
    } else {
        $client->privateDetails()->create($validatedData);
    }

    // Redirect back with a success message
    return redirect()->route('clients.show', $clientId)->with('success', 'Private details updated successfully.');
}
public function editMedicalHistory($clientId)
{
    $client = Client::findOrFail($clientId);
    return view('pharmacyStaff.editMedicalHistory', compact('client'));  // Show form for editing medical history
}

public function updateMedicalHistory(Request $request, $clientId)
{
    // Validate the input data
    $validatedData = $request->validate([
        'conditions' => 'nullable|string|max:255',
        'allergies' => 'nullable|string|max:255',
        'medications' => 'nullable|string|max:255',
        'immunizations' => 'nullable|string|max:255',
        'procedures' => 'nullable|string|max:255',
        'notes' => 'nullable|string|max:255',
    ]);

    $client = Client::findOrFail($clientId);

    // Update the medical history
    if ($client->medicalHistory) {
        $client->medicalHistory->update($validatedData);
    } else {
        $client->medicalHistory()->create($validatedData);
    }

    // Redirect back with a success message
    return redirect()->route('clients.show', $clientId)->with('success', 'Medical history updated successfully.');
}

public function indexMedicines()
{
    $medicines = MedicineData::paginate(10);
    return view('pharmacyStaff.medicines.index', compact('medicines'));
}

// Show details of a specific medicine
public function showMedicine($id)
{
    $medicine = MedicineData::findOrFail($id);
    return view('pharmacyStaff.medicines.show', compact('medicine'));
}

// Show form to add a new medicine
public function createMedicine()
{
    return view('pharmacyStaff.medicines.create');
}

// Store a new medicine
public function storeMedicine(Request $request)
{
    $validatedData = $request->validate([
        'batch_no' => 'required|string|max:50',
        'drug_name' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'manufacturer' => 'required|string|max:255',
        'stock_qty' => 'required|integer|min:0',
        'expiry_date' => 'required|date|after:today',
    ]);

    MedicineData::create($validatedData);

    return redirect()->route('pharmacyStaff.medicines.index')->with('success', 'Medicine added successfully.');
}

// Delete a medicine
public function destroyMedicine($id)
{
    $medicine = MedicineData::findOrFail($id);
    $medicine->delete();

    return redirect()->route('pharmacyStaff.medicines.index')->with('success', 'Medicine deleted successfully.');
}

public function inventoryIndex()
{
    $inventoryItems = Inventory::paginate(10); // Paginated list of inventory items
    return view('pharmacyStaff.inventory.index', compact('inventoryItems'));
}

// Show form to create a new inventory item
public function inventoryCreateView()
{
    return view('pharmacyStaff.inventory.create');
}

// Handle adding a new inventory item
public function inventoryStore(Request $request)
{
    $validated = $request->validate([
        'description' => 'required|string|max:255',
        'dosage' => 'required|string|max:50',
        'unit_price' => 'required|numeric|min:0',
        'stock_level' => 'required|integer|min:0',
        'reorder_level' => 'required|integer|min:0',
    ]);

    Inventory::create($validated);

    return redirect()->route('pharmacyStaff.inventory.index')->with('success', 'Inventory item added successfully!');
}

// Show form to edit an inventory item
public function inventoryEditView($medicine_id)
{
    $inventoryItem = Inventory::where('medicine_id', $medicine_id)->firstOrFail();
    return view('pharmacyStaff.inventory.edit', compact('inventoryItem'));
}

// Handle updating an inventory item
public function inventoryUpdate(Request $request, $medicine_id)
{
    $inventoryItem = Inventory::where('medicine_id', $medicine_id)->firstOrFail();

    // Validate and update the inventory item
    $validatedData = $request->validate([
        'description' => 'required|string|max:255',
        'dosage' => 'required|string|max:255',
        'unit_price' => 'required|numeric',
        'stock_level' => 'required|integer',
        'reorder_level' => 'required|integer',
    ]);

    $inventoryItem->update($validatedData);

    return redirect()->route('pharmacyStaff.inventory.index')->with('success', 'Inventory item updated successfully!');
}

public function inventoryDestroy($medicine_id)
{
    $inventoryItem = Inventory::where('medicine_id', $medicine_id)->firstOrFail();
    $inventoryItem->delete();

    return redirect()->route('pharmacyStaff.inventory.index')->with('success', 'Inventory item deleted successfully!');
}

// Display a list of all trainings
public function trainingsIndex()
{
    $trainings = TrainingAndSupport::all(); // Fetch all training records
    return view('pharmacyStaff.trainings.index', compact('trainings')); // Pass to view
}

// Show form to create a new training
public function trainingsCreateView()
{
    return view('pharmacyStaff.trainings.create'); // Show create form
}

// Store a new training record
public function trainingsStore(Request $request)
{
    $validated = $request->validate([
        'knowledge_base' => 'required|string|max:255',
    ]);

    // Create a new Training and Support record
    TrainingAndSupport::create($validated);

    return redirect()->route('pharmacyStaff.trainings.index')->with('success', 'Training and Support created successfully!');
}

// Show details of a specific training
public function trainingsShow($training_id)
{
    $training = TrainingAndSupport::findOrFail($training_id); // Find the training by ID
    return view('pharmacyStaff.trainings.show', compact('training')); // Pass to view
}

// Show form to edit an existing training
public function trainingsEditView($training_id)
{
    $training = TrainingAndSupport::findOrFail($training_id); // Find the training by ID
    return view('pharmacyStaff.trainings.edit', compact('training')); // Pass to edit view
}

// Update an existing training record
public function trainingsUpdate(Request $request, $training_id)
{
    // Validate the input data
    $validated = $request->validate([
        'knowledge_base' => 'required|string|max:255', // Example field
    ]);

    // Find and update the training record
    $training = TrainingAndSupport::findOrFail($training_id);
    $training->update($validated);

    return redirect()->route('pharmacyStaff.trainings.index')->with('success', 'Training updated successfully!');
}

// Delete a specific training record
public function trainingsDestroy($training_id)
{
    $training = TrainingAndSupport::findOrFail($training_id); // Find the training by ID
    $training->delete(); // Delete the record

    return redirect()->route('pharmacyStaff.trainings.index')->with('success', 'Training deleted successfully!');
}
}
