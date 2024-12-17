@extends('layouts.app')

@section('title', 'Create New Client')

@section('content')
<div class="container">
    <h2>Create New Client</h2>
    <form action="{{ route('storeClient') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="Fname">First Name</label>
            <input type="text" class="form-control" name="Fname" required>
        </div>
        <div class="form-group">
            <label for="Lname">Last Name</label>
            <input type="text" class="form-control" name="Lname" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" name="password" required>
        </div>
        <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" class="form-control" name="password_confirmation" required>
        </div>
        <button type="submit" class="btn btn-primary">Create Client</button>
    </form>
</div>
@endsection
