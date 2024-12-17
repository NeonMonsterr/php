@extends('layouts.app')

@section('title', 'Edit Private Details')

@section('content')
<div class="container">
    <h2>Edit Private Details for {{ $client->Fname }} {{ $client->Lname }}</h2>
    <form action="{{ route('updatePrivateDetails', $client->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="ssn">SSN</label>
            <input type="text" class="form-control" name="ssn" value="{{ $client->privateDetails->ssn ?? '' }}">
        </div>
        <div class="form-group">
            <label for="date_of_birth">Date of Birth</label>
            <input type="date" class="form-control" name="date_of_birth" value="{{ $client->privateDetails->date_of_birth ?? '' }}">
        </div>
        <button type="submit" class="btn btn-success">Update Private Details</button>
    </form>
</div>
@endsection
