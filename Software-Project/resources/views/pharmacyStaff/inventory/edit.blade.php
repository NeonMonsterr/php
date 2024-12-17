@extends('layouts.app')

@section('title', 'Edit Inventory Item')

@section('content')
<div class="container">
    <h1>Edit Inventory Item</h1>
    <form action="{{ route('pharmacyStaff.inventory.update', $inventoryItem->medicine_id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="description">Description</label>
            <input type="text" class="form-control" id="description" name="description" value="{{ $inventoryItem->description }}" required>
        </div>
        <div class="form-group">
            <label for="dosage">Dosage</label>
            <input type="text" class="form-control" id="dosage" name="dosage" value="{{ $inventoryItem->dosage }}" required>
        </div>
        <div class="form-group">
            <label for="unit_price">Unit Price</label>
            <input type="number" class="form-control" id="unit_price" name="unit_price" step="0.01" value="{{ $inventoryItem->unit_price }}" required>
        </div>
        <div class="form-group">
            <label for="stock_level">Stock Level</label>
            <input type="number" class="form-control" id="stock_level" name="stock_level" value="{{ $inventoryItem->stock_level }}" required>
        </div>
        <div class="form-group">
            <label for="reorder_level">Reorder Level</label>
            <input type="number" class="form-control" id="reorder_level" name="reorder_level" value="{{ $inventoryItem->reorder_level }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Item</button>
    </form>
</div>
@endsection
