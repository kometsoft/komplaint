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
                            <input type="text" class="form-control" name="filter[title]" value="{{ request()->filter['title'] ?? null }}">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-3 col-form-label">Status</label>
                        <div class="col">
                            <div class="form-selectgroup">
                                @forelse ($action_statuses as $action_status)
                                <label class="form-selectgroup-item">
                                    <input
                                        type="radio"
                                        name="filter[action_status_id]"
                                        value="{{ $action_status->id }}"
                                        @checked($action_status->id == (request()->filter['action_status_id'] ?? null))
                                        class="form-selectgroup-input"
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
                </div>
                <div class="modal-footer">
                    <a href="{{ url()->current() }}" class="btn btn-ghost-primary">{{ __('Reset') }}</a>
                    <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">{{ __('Find') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>