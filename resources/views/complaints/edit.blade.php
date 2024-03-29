@extends('layouts.app')

@section('title', $complaint->title)

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5>{{ __('Complaints') }}</h5>
                    <div class="d-flex align-items-center">
                        <form action="{{ route('complaints.destroy', $complaint) }}" method="POST">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger me-2" onclick="return confirm('Are you sure you want to delete this complaint?')">Delete</button>
                        </form>
                        <button type="submit" form="form-complaint" class="btn btn-primary">Save</button>
                    </div>
                </div>
                <div class="card-body">
                    <form id="form-complaint" action="{{ route('complaints.update', $complaint) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('put')
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
                                            <a href="{{ $media->getUrl() }}" target="_blank" class="btn btn-outline-primary">
                                                {{ $media->file_name }}
                                            </a>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endif
                                    <div class="col-md-10">
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
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-10 mt-4">
            <div class="card" id="actions">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5>{{ __('Actions') }}</h5>
                    <div>
                        <button type="submit" form="form-action" class="btn btn-primary">Save</button>
                    </div>
                </div>
                <div class="card-body border-bottom">
                    <form id="form-action" action="{{ route('actions.store', ['complaint_id' => $complaint->id]) }}" method="post">
                        @csrf
                        <div class="mb-3 row">
                            <label class="col-md-3 col-form-label required">Status</label>
                            <div class="col">
                                <div class="form-selectgroup">
                                    @forelse ($action_statuses as $action_status)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="action_status_id" id="action_status_{{ $action_status->id }}" value="{{ $action_status->id }}" @checked($action_status->id == old('action_status_id'))>
                                        <label class="form-check-label" for="action_status_{{ $action_status->id }}">
                                            {{ $action_status->name }}
                                        </label>
                                    </div>
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
                    </form>
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
            </div>
        </div>
    </div>
</div>
@endsection