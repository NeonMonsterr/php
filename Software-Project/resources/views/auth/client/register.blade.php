@extends('layouts.app')

@section('title', 'Client Register')
@section('header', 'Client Register')

@section('content')
<div class="card mx-auto shadow-sm" style="max-width: 400px;">
    <div class="card-body">
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="mb-3">
                <label for="Fname" class="form-label">FName</label>
                <input type="text" name="Fname" class="form-control" id="Fname" required placeholder="Enter your name">
            </div>
            <div class="mb-3">
                <label for="Lname" class="form-label">LName</label>
                <input type="text" name="Lname" class="form-control" id="Lname" required placeholder="Enter your name">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control" id="email" required placeholder="Enter your email">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="password" required placeholder="Enter a password">
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" required placeholder="Confirm your password">
            </div>
            <button type="submit" class="btn btn-success w-100">Register</button>
        </form>
    </div>
</div>
@endsection
