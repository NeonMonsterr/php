@extends('layouts.app')

@section('title', 'Inventory Management')

@section('content')
<div class="container">
    <h1>Inventory Management</h1>
    <a href="{{ route('pharmacyStaff.inventory.create') }}" class="btn btn-success mb-3">Add New Item</a>

    @if($inventoryItems->isEmpty())
        <p>No items in inventory.</p>
    @else
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Dosage</th>
                    <th>Unit Price</th>
                    <th>Stock Level</th>
                    <th>Reorder Level</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($inventoryItems as $item)
                    <tr>
                        <td>{{ $item->description }}</td>
                        <td>{{ $item->dosage }}</td>
                        <td>${{ number_format($item->unit_price, 2) }}</td>
                        <td>{{ $item->stock_level }}</td>
                        <td>{{ $item->reorder_level }}</td>
                        <td>
                            <!-- Ensure the ID is passed to the edit route -->
                            <a href="{{ route('pharmacyStaff.inventory.edit', $item->medicine_id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('pharmacyStaff.inventory.destroy', $item->medicine_id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $inventoryItems->links() }}
    @endif
</div>
@endsection
