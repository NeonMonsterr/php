@extends('layouts.app')

@section('title', 'Edit Training and Support')

@section('content')
    <div class="container">
        <h1>Edit Training and Support</h1>

        <form action="{{ route('pharmacyStaff.trainings.update', $training->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="knowledge_base">Knowledge Base</label>
                <input type="text" class="form-control" id="knowledge_base" name="knowledge_base" value="{{ $training->knowledge_base }}" required>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Update</button>
        </form>
    </div>
@endsection
