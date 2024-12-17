@extends('layouts.app')

@section('title', 'Create Training and Support')

@section('content')
    <div class="container">
        <h1>Create New Training and Support</h1>

        <!-- Display validation errors -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Training and Support creation form -->
        <form action="{{ route('pharmacyStaff.trainings.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="knowledge_base">Knowledge Base</label>
                <input type="text" class="form-control" id="knowledge_base" name="knowledge_base" value="{{ old('knowledge_base') }}" required>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Save</button>
        </form>
    </div>
@endsection
