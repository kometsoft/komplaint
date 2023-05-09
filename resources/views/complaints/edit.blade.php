@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row row-cards">
        <div class="col-md-6">
            <form action="{{ route('complaints.update', $complaint) }}" method="post" class="card" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="card-header">
                    <div class="card-title">{{ __('Complaints') }}</div>
                    <div class="card-actions">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-3 row">
                        <label class="col-md-3 col-form-label">ID</label>
                        <div class="col">
                            <div class="form-control-plaintext">{{ $complaint->id }}</div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-3 col-form-label required">Title</label>
                        <div class="col">
                            <input type="text" class="form-control" name="title" value="{{ old('title', $complaint->title) }}">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-3 col-form-label required">Body</label>
                        <div class="col">
                            <textarea rows="5" class="form-control" name="body">{{ old('body', $complaint->body) }}</textarea>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-3 col-form-label required">Attachment</label>
                        <div class="col">
                            <div class="row">
                                @if ($complaint->getMedia()->isNotEmpty())
                                <div class="col-md-6 mb-3">
                                    <div class="btn-list">
                                        @foreach ($complaint->getMedia() as $media)
                                        <a href="{{ $media->getUrl() }}" target="_blank" class="btn">
                                            {{ $media->file_name }}
                                        </a>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                                <div class="col-md-12">
                                    <input type="file" class="form-control" name="attachment">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-3 col-form-label">Created by</label>
                        <div class="col">
                            <div class="form-control-plaintext">{{ $complaint->creator->name }}</div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-3 col-form-label">Updated by</label>
                        <div class="col">
                            <div class="form-control-plaintext">{{ $complaint->updator->name }}</div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-3 col-form-label">Created at</label>
                        <div class="col">
                            <div class="form-control-plaintext">{{ $complaint->created_at?->format('d M Y h:i A') }}
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-3 col-form-label">Updated at</label>
                        <div class="col">
                            <div class="form-control-plaintext">{{ $complaint->updated_at?->format('d M Y h:i A') }}
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="col-md-6">
            <form action="{{ route('actions.store', ['complaint_id' => $complaint->id]) }}" method="post" class="card"
                id="actions-card">
                @csrf
                <div class="card-header">
                    <div class="card-title">{{ __('Actions') }}</div>
                    <div class="card-actions">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
                <div class="card-body border-bottom">
                    <div class="mb-3 row">
                        <label class="col-md-3 col-form-label required">Status</label>
                        <div class="col">
                            <div class="form-selectgroup">
                                @forelse ($action_statuses as $action_status)
                                <label class="form-selectgroup-item">
                                    <input
                                        type="radio"
                                        name="action_status_id"
                                        class="form-selectgroup-input"
                                        value="{{ $action_status->id }}"
                                        @checked($action_status->id == old('action_status_id'))
                                    >
                                    <div class="form-selectgroup-label d-flex align-items-center">
                                        <span class="form-selectgroup-check me-3"></span>
                                        {{ $action_status->name }}
                                    </div>
                                </label>
                                @empty
                                @endforelse
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-3 col-form-label required">Description</label>
                        <div class="col">
                            <textarea rows="5" class="form-control" name="description">{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-vcenter card-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Status</th>
                                <th>Description</th>
                                <th>Created at</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($complaint->actions as $action)
                            <tr>
                                <td>{{ $loop->iteration }}.</td>
                                <td>
                                    <span class="badge {{ $action->action_status->class }}">
                                        {{ $action->action_status->name }}</span>
                                </td>
                                <td>{{ $action->description }}</td>
                                <td>{{ $complaint->created_at?->format('d M Y h:i A') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="100">No records found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection