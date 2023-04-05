@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row row-cards justify-content-center">
        @if ($errors->isNotEmpty())
        <div class="col-md-10">
            <div class="alert alert-danger mb-0" role="alert">
                <h4 class="alert-title">An error occured!</h4>
                <ul class="">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif

        @if (session('success'))
        <div class="col-md-10">
            <div class="alert alert-success mb-0" role="alert">
                <h4 class="alert-title">Success!</h4>
                <div>{{ session('success') }}</div>
            </div>
        </div>
        @endif

        <div class="col-md-10">
            <form action="{{ route('complaints.update', $complaint) }}" method="post" class="card">
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
                            <input type="text" class="form-control" name="title" value="{{ $complaint->title }}">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-3 col-form-label required">Body</label>
                        <div class="col">
                            <textarea rows="5" class="form-control" name="body">{{ $complaint->body }}</textarea>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-3 col-form-label required">Complaint Types</label>
                        <div class="col">
                            <select class="form-select" name="complaint_type_id">
                                <option></option>
                                @forelse ($complaint_types as $complaint_type)
                                <option value="{{ $complaint_type->id }}" @selected($complaint_type->id ===
                                    $complaint->complaint_type_id)>{{ $complaint_type->name }}</option>
                                @empty
                                @endforelse
                            </select>
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
                    {{-- <div class="row">
                        <label class="col-3 col-form-label pt-0">I certify that the information entered is
                            accurate.</label>
                        <div class="col">
                            <label class="form-check">
                                <input class="form-check-input" type="checkbox" checked="">
                                <span class="form-check-label">Option 1</span>
                            </label>
                        </div>
                    </div> --}}
                </div>
            </form>
        </div>

        <div class="col-md-10">
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
                            <select class="form-select" name="action_status_id">
                                <option></option>
                                @forelse ($action_statuses as $action_status)
                                <option value="{{ $action_status->id }}">{{ $action_status->name }}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-3 col-form-label required">Description</label>
                        <div class="col">
                            <textarea rows="5" class="form-control" name="description"></textarea>
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