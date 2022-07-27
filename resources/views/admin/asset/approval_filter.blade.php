<form method="GET" action="{{ route('asset.approval') }}">
    <div class="form-row">
        <div class="form-group col-md-2">
            <input type="text" name="q" class="form-control" id="q" placeholder="Search by Project Name" value="{{ !empty($filter['q']) ? $filter['q'] : '' }}">
        </div>
        <div class="form-group col-md-2">
            <input type="text" name="asset_id" class="form-control" id="q" placeholder="Search by Asset ID" value="{{ !empty($filter['asset_id']) ? $filter['asset_id'] : '' }}">
        </div>
        <div class="form-group col-md-2">
            <input type="text" name="campaign_id" class="form-control" id="q" placeholder="Search by Project ID" value="{{ !empty($filter['campaign_id']) ? $filter['campaign_id'] : '' }}">
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
