<form method="GET" action="{{ route('archives.index') }}">
    <div class="form-row">
        <div class="form-group col-md-4">
        <input type="text" name="q" class="form-control" id="q" placeholder="Search by Project Name, Created By" value="{{ !empty($filter['q']) ? $filter['q'] : '' }}">
            <input type="hidden" name="status" id="status" value="archived">
        </div>
{{--        <div class="form-group col-md-2">--}}
{{--        </div>--}}
{{--        <div class="form-group col-md-2">--}}
{{--        </div>--}}
        <div class="form-group col-md-2">
            <button class="btn btn-block btn-primary btn-filter"><i class="fas fa-search"></i> {{ __('general.btn_search_label') }}</button>
        </div>
    </div>
</form>
