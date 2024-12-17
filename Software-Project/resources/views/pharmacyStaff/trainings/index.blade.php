@extends('layouts.app')

@section('title', 'Training and Support Management')

@section('content')
    <div class="container">
        <h1>Training and Support Management</h1>

        <a href="{{ route('pharmacyStaff.trainings.create') }}" class="btn btn-primary mb-3">Add New Training</a>

        <div class="list-group">
            @foreach($trainings as $training)
                <div class="list-group-item">
                    <h4>{{ $training->knowledge_base }}</h4>
                    <p>Number of Training Packages: {{ $training->trainingPackages->count() }}</p>
                    <a href="{{ route('pharmacyStaff.trainings.show', $training->id) }}" class="btn btn-info btn-sm">View Details</a>
                    <a href="{{ route('pharmacyStaff.trainings.edit', $training->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('pharmacyStaff.trainings.destroy', $training->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>
@endsection
