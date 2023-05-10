<a href="#" class="btn btn-icon position-relative" data-bs-toggle="modal" data-bs-target="#modal-filter">
    <i class="ti ti-filter icon"></i>
    @if (collect(request()->query())->except('page')->only(['filter'])->flatten()->filter()->count())
    <span class="badge bg-danger badge-notification"></span>
    @endif
</a>

<div class="modal modal-blur fade" id="modal-filter" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{ route('complaints.index') }}" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Filters') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 row">
                        <label class="col-md-3 col-form-label">Title</label>
                        <div class="col">
                            <input type="text" class="form-control" name="filter[title]"
                                value="{{ request()->filter['title'] ?? null }}">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-3 col-form-label">Status</label>
                        <div class="col">
                            <div class="form-group">
                                <select name="filter[action_status_id]" id="action_status_id" class="form-select">
                                    <option value=""></option>
                                    @forelse($action_statuses as $action_status)
                                    <option value="{{ $action_status->id }}" @selected($action_status->id ==
                                        (request()->filter['action_status_id'] ?? null))
                                        >
                                        {{ $action_status->name }}
                                    </option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-3 col-form-label">Created At</label>
                        <div class="col">
                            <div class="input-icon">
                                <input class="form-control" id="datepicker" name="filter[created_at]"
                                    value="{{ request()->filter['created_at'] ?? null }}" />
                                <span class="input-icon-addon">
                                    <i class=" ti ti-calendar"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-3 col-form-label">Deleted</label>
                        <div class="col">
                            <div class="form-group">
                                <select name="filter[deleted]" name="deleted" class="form-select">
                                    <option value="">Without deleted records</option>
                                    <option value="with" @selected(request()->input('filter.deleted') === 'with')>With deleted records</option>
                                    <option value="only" @selected(request()->input('filter.deleted') === 'only')>Only deleted records</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="{{ url()->current() }}" class="btn btn-ghost-danger">{{ __('Reset') }}</a>
                    <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">{{ __('Find') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
    	new Litepicker({
    		element: document.getElementById('datepicker'),
    		buttonText: {
    			previousMonth: '<i class="ti ti-chevron-left"></i>',
    			nextMonth: '<i class="ti ti-chevron-right"></i>',
    		},
            format: 'DD/MM/YYYY',
    	})
    });
</script>