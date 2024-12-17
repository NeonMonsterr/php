@extends('layouts.app')

@section('title', 'Client Profile')

@section('content')
<div class="container py-5">
    <!-- Profile Card -->
    <div class="card shadow-lg mx-auto" style="max-width: 900px;">
        <div class="card-body">
            <div class="text-center mb-4">
                <h2 class="display-4 font-weight-bold">Client Profile</h2>
                <p class="text-muted">View and update your personal information</p>
            </div>

            <!-- Client Basic Info -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5 class="text-primary">Personal Information</h5>
                    <p><strong>First Name:</strong> {{ $client->Fname }}</p>
                    <p><strong>Last Name:</strong> {{ $client->Lname }}</p>
                    <p><strong>Email:</strong> {{ $client->email }}</p>
                </div>
            </div>

            <!-- Contact Details -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5 class="text-primary">Contact Details</h5>
                    <p><strong>Phone:</strong> {{ $client->contactDetails->phone_number ?? 'N/A' }}</p>
                    <p><strong>Mobile:</strong> {{ $client->contactDetails->mobile_number ?? 'N/A' }}</p>
                    <p><strong>Mailing Address:</strong> {{ $client->contactDetails->mailing_address ?? 'N/A' }}</p>
                </div>
            </div>

            <!-- Private Details -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5 class="text-primary">Private Details</h5>
                    <p><strong>SSN:</strong> {{ $client->privateDetails->ssn ?? 'No private details available' }}</p>
                    <p><strong>Date of Birth:</strong> {{ $client->privateDetails->date_of_birth ?? 'No private details available' }}</p>
                </div>
            </div>

            <!-- Medical History -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <h5 class="text-primary">Medical History</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Conditions:</strong></p>
                            <pre class="bg-light p-3 rounded">{{ $client->medicalHistory->conditions ?? 'No medical history available' }}</pre>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Allergies:</strong></p>
                            <pre class="bg-light p-3 rounded">{{ $client->medicalHistory->allergies ?? 'No medical history available' }}</pre>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Medications:</strong></p>
                            <pre class="bg-light p-3 rounded">{{ $client->medicalHistory->medications ?? 'No medical history available' }}</pre>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Immunizations:</strong></p>
                            <pre class="bg-light p-3 rounded">{{ $client->medicalHistory->immunizations ?? 'No medical history available' }}</pre>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Procedures:</strong></p>
                            <pre class="bg-light p-3 rounded">{{ $client->medicalHistory->procedures ?? 'No medical history available' }}</pre>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Notes:</strong></p>
                            <pre class="bg-light p-3 rounded">{{ $client->medicalHistory->notes ?? 'No medical history available' }}</pre>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Profile Button -->
            <div class="text-center mt-5">
                <a href="{{ route('editContact') }}" class="btn btn-primary btn-lg">Edit Profile</a>
            </div>
            <div class="text-center mt-5">
                <a href="{{ route('clientPrescription') }}" class="btn btn-primary btn-lg">Show Prescriptions</a>
            </div>
        </div>
    </div>
</div>

@endsection
