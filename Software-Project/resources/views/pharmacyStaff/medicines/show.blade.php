@extends('layouts.app')

@section('title', 'Medicine Details')

@section('content')
<div class="container">
    <h1>Medicine Details</h1>
    <p><strong>Batch No:</strong> {{ $medicine->batch_no }}</p>
    <p><strong>Drug Name:</strong> {{ $medicine->drug_name }}</p>
    <p><strong>Price:</strong> ${{ number_format($medicine->price, 2) }}</p>
    <p><strong>Manufacturer:</strong> {{ $medicine->manufacturer }}</p>
    <p><strong>Stock Quantity:</strong> {{ $medicine->stock_qty }}</p>
    <p><strong>Expiry Date:</strong> {{ $medicine->expiry_date }}</p>
    <a href="{{ route('pharmacyStaff.medicines.index') }}" class="btn btn-secondary">Back to Medicines</a>
</div>
@endsection
