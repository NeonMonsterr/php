@extends('layouts.app')

@section('title', 'Add Medicine')

@section('content')
<div class="container">
    <h1>Add Medicine</h1>

    <form action="{{ route('pharmacyStaff.medicines.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="batch_no">Batch No</label>
            <input type="text" class="form-control" id="batch_no" name="batch_no" required>
        </div>

        <div class="form-group">
            <label for="drug_name">Drug Name</label>
            <input type="text" class="form-control" id="drug_name" name="drug_name" required>
        </div>

        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" class="form-control" id="price" name="price" step="0.01" required>
        </div>

        <div class="form-group">
            <label for="manufacturer">Manufacturer</label>
            <input type="text" class="form-control" id="manufacturer" name="manufacturer" required>
        </div>

        <div class="form-group">
            <label for="stock_qty">Stock Quantity</label>
            <input type="number" class="form-control" id="stock_qty" name="stock_qty" required>
        </div>

        <div class="form-group">
            <label for="expiry_date">Expiry Date</label>
            <input type="date" class="form-control" id="expiry_date" name="expiry_date" required>
        </div>

        <button type="submit" class="btn btn-primary">Add Medicine</button>
    </form>
</div>
@endsection
