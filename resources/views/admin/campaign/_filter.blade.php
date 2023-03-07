<form method="GET" action="{{ route('campaign.index') }}">
    <div class="form-row" style="background-color: white; margin: -16px 0px 0px 0px; padding: 0px 0px 0px 12px;">
        <hr width="99%" />
        <div class="form-group col-md-4">
        <input type="text" name="q" class="design-field" id="q" placeholder="Search by Project Name" value="{{ !empty($filter['q']) ? $filter['q'] : '' }}">
            <input type="hidden" name="status" id="status" value="active">
        </div>
{{--        <div class="form-group col-md-2">--}}
{{--        </div>--}}
{{--        <div class="form-group col-md-2">--}}
{{--        </div>--}}
        <div class="form-group col-md-2">
            <button class="design-btn"> Apply </button>
        </div>
        <div class="form-group col-md-2">
            <a href="{{ url('admin/campaign/create') }}" class="btn btn-block btn-icon icon-left btn-primary btn-filter" style="border-radius: 2.25em;"><i class="fas fa-plus-circle"></i>Create Project</a>
        </div>
    </div>
</form>
