@extends('layouts.app')

@section('title', 'Edit Contact Details')

@section('content')
<div class="container">
    <h2>Edit Contact Details for {{ $client->Fname }} {{ $client->Lname }}</h2>
    <form action="{{ route('updateContactDetails', $client->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="phone_number">Phone Number</label>
            <input type="text" class="form-control" name="phone_number" value="{{ $client->contactDetails->phone_number ?? '' }}">
        </div>
        <div class="form-group">
            <label for="mobile_number">Mobile Number</label>
            <input type="text" class="form-control" name="mobile_number" value="{{ $client->contactDetails->mobile_number ?? '' }}">
        </div>
        <div class="form-group">
            <label for="mailing_address">Mailing Address</label>
            <textarea class="form-control" name="mailing_address">{{ $client->contactDetails->mailing_address ?? '' }}</textarea>
        </div>
        <button type="submit" class="btn btn-success">Update Contact Details</button>
    </form>
</div>
@endsection
