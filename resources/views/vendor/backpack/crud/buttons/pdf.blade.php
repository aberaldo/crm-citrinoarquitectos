@if ($crud->hasAccess('create'))
	@if ($entry->status != "closed")
		<a href="{{ url($crud->route.'/'.$entry->getKey().'/generatepdf') }}" route="{{ url($crud->route.'/'.$entry->getKey().'/generatepdf') }}" class="btn btn-sm btn-link" data-button-type="close"><i class="las la-file-download"></i> {{ trans('crud.budget.download') }}</a>
	@endif
@endif
