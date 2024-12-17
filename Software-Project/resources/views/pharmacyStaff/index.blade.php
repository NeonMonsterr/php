@extends('layouts.app')

@section('title', 'Manage Clients')

@section('content')
<div class="container">
    <h2>Manage Clients</h2>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($clients as $client)
                <tr>
                    <td>{{ $loop->iteration + ($clients->currentPage() - 1) * $clients->perPage() }}</td>
                    <td>{{ $client->Fname }}</td>
                    <td>{{ $client->Lname }}</td>
                    <td>{{ $client->email }}</td>
                    <td>
                        <a href="{{ route('editClient', $client->id) }}" class="btn btn-sm btn-primary">Edit Client</a>
                        <a href="{{ route('createPrescription', $client->id) }}" class="btn btn-sm btn-info">Add Prescription</a>
                        <a href="{{ route('editContactDetails', $client->id) }}" class="btn btn-sm btn-warning">Edit Contact</a>
                        <a href="{{ route('editPrivateDetails', $client->id) }}" class="btn btn-sm btn-success">Edit Private</a>
                        <a href="{{ route('editMedicalHistory', $client->id) }}" class="btn btn-sm btn-danger">Edit Medical</a>
                        <a href="{{ route('showClient', $client->id) }}" class="btn btn-sm btn-danger">Show Client</a>

                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No clients found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination Links -->
    <div class="d-flex justify-content-center">
        {{ $clients->links() }}
    </div>
</div>
@endsection
