<form method="GET" action="{{ route('campaign.index') }}">
    <div class="form-row">
        <div class="form-group col-md-4">
        <input type="text" name="q" class="form-control" id="q" placeholder="Search by Project Name" value="{{ !empty($filter['q']) ? $filter['q'] : '' }}">
            <input type="hidden" name="status" id="status" value="active">
        </div>
{{--        <div class="form-group col-md-2">--}}
{{--        </div>--}}
{{--        <div class="form-group col-md-2">--}}
{{--        </div>--}}
        <div class="form-group col-md-2">
            <button class="btn btn-block btn-primary btn-filter"><i class="fas fa-search"></i> {{ __('general.btn_search_label') }}</button>
        </div>
        <div class="form-group col-md-2">
            <a href="{{ url('admin/campaign/create') }}" class="btn btn-block btn-icon icon-left btn-success btn-filter"><i class="fas fa-plus-circle"></i>Create Project</a>
        </div>
    </div>
</form>
