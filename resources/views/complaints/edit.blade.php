@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row row-cards justify-content-center">
        <div class="col-md-8">
            @if ($errors->isNotEmpty())
            <div class="alert alert-danger" role="alert">
                <h4 class="alert-title">An error occured!</h4>
                <ul class="">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
        </div>

        <div class="col-md-8">
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
                            <select class="form-select">
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

        <div class="col-md-8">
            <form action="{{ route('complaints.update', $complaint) }}" method="post" class="card">
                @csrf
                @method('put')
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
                            <select class="form-select">
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
                        <label class="col-md-3 col-form-label required">Notes</label>
                        <div class="col">
                            <textarea rows="5" class="form-control" name="body">{{ $complaint->body }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-vcenter card-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th class="w-1"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>223</td>
                                <td>Name</td>
                                <td>Complete</td>
                                <td>
                                    <a href="#">Edit</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection