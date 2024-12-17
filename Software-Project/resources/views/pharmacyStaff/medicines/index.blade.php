@extends('layouts.app')

@section('title', 'Medicine List')

@section('content')
<div class="container">
    <h1>Medicines</h1>
    <a href="{{ route('pharmacyStaff.medicines.create') }}" class="btn btn-success mb-3">Add Medicine</a>

    @if($medicines->isEmpty())
        <p>No medicines available.</p>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Batch No</th>
                    <th>Drug Name</th>
                    <th>Price</th>
                    <th>Manufacturer</th>
                    <th>Stock Qty</th>
                    <th>Expiry Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($medicines as $medicine)
                    <tr>
                        <td>{{ $medicine->batch_no }}</td>
                        <td>{{ $medicine->drug_name }}</td>
                        <td>${{ number_format($medicine->price, 2) }}</td>
                        <td>{{ $medicine->manufacturer }}</td>
                        <td>{{ $medicine->stock_qty }}</td>
                        <td>{{ $medicine->expiry_date }}</td>
                        <td>
                            <a href="{{ route('pharmacyStaff.medicines.show', $medicine->id) }}" class="btn btn-info btn-sm">View</a>
                            <form action="{{ route('pharmacyStaff.medicines.destroy', $medicine->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $medicines->links() }}
    @endif
</div>
@endsection
