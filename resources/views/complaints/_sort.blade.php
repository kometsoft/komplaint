<a href="#" class="btn btn-icon position-relative" data-bs-toggle="modal" data-bs-target="#modal-sort">
    <i class="ti ti-sort-ascending icon"></i>
    @if (collect(request()->query())->except('page')->only(['filter'])->flatten()->filter()->count())
    <span class="badge bg-danger badge-notification"></span>
    @endif
</a>

<div class="modal modal-blur fade" id="modal-sort" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{ route('complaints.index') }}" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Sort') }}</h5>
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
                </div>
                <div class="modal-footer">
                    <a href="{{ url()->current() }}" class="btn btn-ghost-primary">{{ __('Reset') }}</a>
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