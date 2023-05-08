<a href="#" class="btn btn-icon position-relative" data-bs-toggle="modal" data-bs-target="#modal-team">
    <i class="ti ti-filter icon"></i>
    @if (collect(request()->query())->except('page')->count())
    <span class="badge bg-danger badge-notification"></span>
    @endif
</a>

<div class="modal modal-blur fade" id="modal-team" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{ route('complaints.index') }}">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Filters') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 row">
                        <label class="col-md-3 col-form-label">Title</label>
                        <div class="col">
                            <input type="text" class="form-control" name="title" value="{{ request()->title }}">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-3 col-form-label">Status</label>
                        <div class="col">
                            <select class="form-select">
                                <option></option>
                                <option>Pending</option>
                                <option>In Progress</option>
                                <option>Completed</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="{{ url()->current() }}" class="btn btn-ghost-primary">{{ __('Reset') }}</a>
                    <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">{{ __('Find') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>