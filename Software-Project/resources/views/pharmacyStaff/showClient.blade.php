@extends('layouts.app')

@section('title', 'Client Details')

@section('content')
<div class="container">
    <h2>Client Details</h2>
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h4>General Information</h4>
            <p><strong>First Name:</strong> {{ $client->Fname }}</p>
            <p><strong>Last Name:</strong> {{ $client->Lname }}</p>
            <p><strong>Email:</strong> {{ $client->email }}</p>
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h4>Contact Details</h4>
            <p><strong>Phone Number:</strong> {{ $client->contactDetails->phone_number ?? 'N/A' }}</p>
            <p><strong>Mobile Number:</strong> {{ $client->contactDetails->mobile_number ?? 'N/A' }}</p>
            <p><strong>Mailing Address:</strong> {{ $client->contactDetails->mailing_address ?? 'N/A' }}</p>
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h4>Private Details</h4>
            <p><strong>SSN:</strong> {{ $client->privateDetails->ssn ?? 'N/A' }}</p>
            <p><strong>Date of Birth:</strong> {{ $client->privateDetails->date_of_birth ?? 'N/A' }}</p>
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h4>Medical History</h4>
            <p><strong>Conditions:</strong> {{ $client->medicalHistory->conditions ?? 'N/A' }}</p>
            <p><strong>Allergies:</strong> {{ $client->medicalHistory->allergies ?? 'N/A' }}</p>
            <p><strong>Medications:</strong> {{ $client->medicalHistory->medications ?? 'N/A' }}</p>
            <p><strong>Immunizations:</strong> {{ $client->medicalHistory->immunizations ?? 'N/A' }}</p>
            <p><strong>Procedures:</strong> {{ $client->medicalHistory->procedures ?? 'N/A' }}</p>
            <p><strong>Notes:</strong> {{ $client->medicalHistory->notes ?? 'N/A' }}</p>
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h4>Prescriptions</h4>
            @if($client->prescriptions->isNotEmpty())
                <ul class="list-group">
                    @foreach($client->prescriptions as $prescription)
                        <li class="list-group-item">
                            <p><strong>Prescription Date:</strong> {{ $prescription->pres_date }}</p>
                            <p><strong>Medicines:</strong></p>
                            <ul>
                                @foreach($prescription->medicines as $medicine)
                                    <li>{{ $medicine->name }}</li>
                                @endforeach
                            </ul>
                        </li>
                    @endforeach
                </ul>
            @else
                <p>No prescriptions available.</p>
            @endif
        </div>
    </div>

    <a href="{{ route('pharmacyStaff.clients.index') }}" class="btn btn-secondary">Back to Clients</a>
</div>
@endsection
