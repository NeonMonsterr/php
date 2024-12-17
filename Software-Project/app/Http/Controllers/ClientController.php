<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    // Access general client info
    public function accessInfo()
    {
        $id = auth('client')->id();
        $client = Client::with(['privateDetails', 'medicalHistory', 'contactDetails'])->findOrFail($id);
        return view('clients.profile', compact('client'));
    }
    public function editContactDetails()
    {
        $id = auth('client')->id();
        $client = Client::findOrFail($id);
        return view('clients.editContactDetails', compact('client'));
    }
    public function showprescriptions() {
        $client = auth('client')->user();
        $prescription=$client->load('prescriptions');
        return view('clients.prescription',compact('prescription'));
    }

    public function updateContactDetails(Request $request)
    {
        // Validate the input data
        $validatedData = $request->validate([
            'phone_number' => 'nullable|string|max:15',
            'mobile_number' => 'nullable|string|max:15',
            'mailing_address' => 'nullable|string|max:255',
        ]);

        $client = auth('client')->user();

        // Update the contact details
        if ($client->contactDetails) {
            $client->contactDetails->update($validatedData);
        } else {
            $client->contactDetails()->create($validatedData);
        }

        // Redirect back with a success message
        return redirect()->route('profile');
    }


    public function accessPrivateDetails($id) {}

    public function accessMedicalHistory($id) {}

    public function accessContactDetails($id) {}
}
