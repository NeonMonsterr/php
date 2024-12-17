@extends('layouts.app')

@section('title', 'Add Prescription')

@section('content')
<div class="container">
    <h2>Add Prescription for {{ $client->Fname }} {{ $client->Lname }}</h2>
    <form action="{{ route('storePrescription', $client->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="pres_date">Prescription Date</label>
            <input type="date" class="form-control" name="pres_date" required>
        </div>
        {{-- <div class="form-group">
            <label for="staff_id">Issued By (Staff ID)</label>
            <input type="number" class="form-control" name="staff_id" required>
        </div> --}}
        <div class="form-group">
            <label for="medicines">Select Medicines</label>
            <select name="medicines[]" class="form-control" multiple required>
                @foreach($medicines as $medicine)
                    <option value="{{ $medicine->id }}">{{ $medicine->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Add Prescription</button>
    </form>
</div>
@endsection
