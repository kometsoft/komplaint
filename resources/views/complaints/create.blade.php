@extends('layouts.app')

@section('title', 'New Complaint')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <form action="{{ route('complaints.store') }}" method="post" class="card" enctype="multipart/form-data">
                @csrf
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title">{{ __('New Complaints') }}</h5>
                    <div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
                <div class="card-body">
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
                            <input type="file" class="form-control" name="attachment">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection