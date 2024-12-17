@extends('layouts.app')

@section('title', 'Edit Client')

@section('content')
<div class="container">
    <h2>Edit Client</h2>
    <form action="{{ route('updateClient', $client->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="Fname">First Name</label>
            <input type="text" class="form-control" name="Fname" value="{{ $client->Fname }}" required>
        </div>
        <div class="form-group">
            <label for="Lname">Last Name</label>
            <input type="text" class="form-control" name="Lname" value="{{ $client->Lname }}" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" name="email" value="{{ $client->email }}" required>
        </div>
        <button type="submit" class="btn btn-success">Update Client</button>
    </form>
</div>
@endsection
