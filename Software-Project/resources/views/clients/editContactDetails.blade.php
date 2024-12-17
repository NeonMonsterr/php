@extends('layouts.app')

@section('title', 'Edit Contact Details')

@section('content')
<div class="card mx-auto shadow-sm" style="max-width: 600px;">
    <div class="card-body">
        <h4>Edit Contact Details</h4>

        <form method="POST" action="{{ route('updateContactDetails') }}">
            @csrf
            @method('PUT') <!-- This tells Laravel to treat this as a PUT request for updating -->

            <div class="mb-3">
                <label for="phone_number" class="form-label">Phone Number</label>
                <input type="text" name="phone_number" class="form-control" id="phone_number" value="{{ old('phone_number', $client->contactDetails->phone_number ?? '') }}" placeholder="Enter your phone number" required>
                @error('phone_number')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="mobile_number" class="form-label">Mobile Number</label>
                <input type="text" name="mobile_number" class="form-control" id="mobile_number" value="{{ old('mobile_number', $client->contactDetails->mobile_number ?? '') }}" placeholder="Enter your mobile number" required>
                @error('mobile_number')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="mailing_address" class="form-label">Mailing Address</label>
                <textarea name="mailing_address" class="form-control" id="mailing_address" placeholder="Enter your mailing address" required>{{ old('mailing_address', $client->contactDetails->mailing_address ?? '') }}</textarea>
                @error('mailing_address')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary w-100">Update Contact Details</button>
        </form>
    </div>
</div>
@endsection
