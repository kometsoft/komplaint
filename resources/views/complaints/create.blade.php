@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row row-cards justify-content-center">
        @if ($errors->isNotEmpty())
        <div class="col-md-8">
            <div class="alert alert-danger" role="alert">
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
        <div class="col-md-8">
            <div class="alert alert-success" role="alert">
                <h4 class="alert-title">Success!</h4>
                <div>{{ session('success') }}</div>
            </div>
        </div>
        @endif

        <div class="col-md-8">
            <form action="{{ route('complaints.store') }}" method="post" class="card" enctype="multipart/form-data">
                @csrf
                <div class="card-header">
                    <div class="card-title">{{ __('Complaints') }}</div>
                    <div class="card-actions">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
                <div class="card-body">
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