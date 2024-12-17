@extends('layouts.app')

@section('title', 'Client Prescriptions')

@section('content')
<div class="card mx-auto shadow-sm" style="max-width: 800px;">
    <div class="card-body">
        <h4>Prescriptions</h4>

        @if($prescription->prescriptions->isEmpty())
            <p>You don't have any prescriptions yet.</p>
        @else
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Prescription Date</th>
                        <th scope="col">Staff Name</th>
                        <th scope="col">Medicines</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($prescription->prescriptions as $pres)
                        <tr>
                            <td>{{ $pres->pres_date }}</td>
                            <td>{{ $pres->staff->name ?? 'Staff not available' }}</td>
                            <td>
                                @foreach ($pres->medicines as $medicine)
                                    <span class="badge bg-primary">{{ $medicine->name }}</span>
                                @endforeach
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection
