@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">{{ __('Complaints') }}</div>
                    <div class="card-actions">
                        <div class="btn-list">
                            @include('complaints._filter')
                            <a href="{{ route('complaints.create') }}" class="btn btn-primary">
                                Add New
                            </a>
                        </div>
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
                                <td>{{ $loop->iteration }}.</td>
                                <td>{{ $complaint->id }}</td>
                                <td>{{ $complaint->title }}</td>
                                <td>
                                    <span
                                        class="badge {{ $complaint->action->action_status->class }}">
                                        {{ $complaint->action->action_status->name }}</span>
                                </td>
                                <td>{{ $complaint->created_at?->format('d M Y h:i A') }}</td>
                                <td class="d-flex gap-3">
                                    <a href="{{ route('complaints.edit', $complaint) }}">Edit</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="100">No records found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="card-footer pb-0">
                    {{ $complaints->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection