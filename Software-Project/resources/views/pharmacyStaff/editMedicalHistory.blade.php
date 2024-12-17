@extends('layouts.app')

@section('title', 'Edit Medical History')

@section('content')
<div class="container">
    <h2>Edit Medical History for {{ $client->Fname }} {{ $client->Lname }}</h2>
    <form action="{{ route('updateMedicalHistory', $client->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="conditions">Conditions</label>
            <textarea class="form-control" name="conditions">{{ $client->medicalHistory->conditions ?? '' }}</textarea>
        </div>
        <div class="form-group">
            <label for="allergies">Allergies</label>
            <textarea class="form-control" name="allergies">{{ $client->medicalHistory->allergies ?? '' }}</textarea>
        </div>
        <div class="form-group">
            <label for="medications">Medications</label>
            <textarea class="form-control" name="medications">{{ $client->medicalHistory->medications ?? '' }}</textarea>
        </div>
        <button type="submit" class="btn btn-success">Update Medical History</button>
    </form>
</div>
@endsection
