@extends('layouts.app')

@section('title', 'Complaints')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5>{{ __('Complaints') }}</h5>
                    <div>
                        <a href="{{ route('complaints.create') }}" class="btn btn-primary">
                            Add New
                        </a>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-vcenter card-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Status</th>
                                <th>Created at</th>
                                <th class="w-1"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($complaints as $complaint)
                            <tr>
                                <td>{{ $complaints->firstItem() + $loop->index }}.</td>
                                <td>{{ $complaint->id }}</td>
                                <td>{{ $complaint->title }}</td>
                                <td>
                                    <span class="badge {{ $complaint->action?->action_status->class }}">
                                        {{ $complaint->action?->action_status->name }}</span>
                                </td>
                                <td>{{ $complaint->created_at?->format('d M Y h:i A') }}</td>
                                <td class="d-flex gap-3">
                                    <a href="{{ route('complaints.edit', $complaint) }}">Edit</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="100" class="text-center">No records found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if ($complaints->hasPages())
            <div class="mt-3">
                {{ $complaints->withQueryString()->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection