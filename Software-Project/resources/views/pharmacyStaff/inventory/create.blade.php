@extends('layouts.app')

@section('title', 'Add Inventory Item')

@section('content')
<div class="container">
    <h1>Add Inventory Item</h1>
    <form action="{{ route('pharmacyStaff.inventory.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="description">Description</label>
            <input type="text" class="form-control" id="description" name="description" required>
        </div>
        <div class="form-group">
            <label for="dosage">Dosage</label>
            <input type="text" class="form-control" id="dosage" name="dosage" required>
        </div>
        <div class="form-group">
            <label for="unit_price">Unit Price</label>
            <input type="number" class="form-control" id="unit_price" name="unit_price" step="0.01" required>
        </div>
        <div class="form-group">
            <label for="stock_level">Stock Level</label>
            <input type="number" class="form-control" id="stock_level" name="stock_level" required>
        </div>
        <div class="form-group">
            <label for="reorder_level">Reorder Level</label>
            <input type="number" class="form-control" id="reorder_level" name="reorder_level" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Item</button>
    </form>
</div>
@endsection
