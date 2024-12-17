@extends('layouts.app')

@section('title', 'Training and Support Details')

@section('content')
    <div class="container">
        <h1>{{ $training->knowledge_base }}</h1>

        <h3>Training Packages</h3>
        <ul>
            @foreach ($training->trainingPackages as $package)
                <li>{{ $package->name }}</li>
            @endforeach
        </ul>

        <a href="{{ route('pharmacyStaff.trainings.index') }}" class="btn btn-secondary mt-3">Back to List</a>
    </div>
@endsection
