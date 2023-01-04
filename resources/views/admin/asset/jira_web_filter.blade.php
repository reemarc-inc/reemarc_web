<form method="GET" action="{{ route('asset.jira_web') }}">
    <div class="form-row">
        <div class="form-group col-md-2">
            <select class="form-control" name="web_production" id="web_production">
                <option value="">Select Web Production</option>
                @foreach ($web_productions as $value)
                    <option value="{{ $value['first_name'] }}" @if( $value['first_name'] == $web_production) selected="selected" @endif >
                        {{$value['first_name']}}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-md-2">
            <select class="form-control" name="brand">
                <option value="">Select Brand</option>
                @foreach ($brands as $key => $value)
                    <option value="{{ $key }}" @if( $key == $brand) selected="selected" @endif >
                        {{$value}}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-md-2">
            <input type="text" name="asset_id" class="form-control" id="asset_id" placeholder="Asset ID" value="{{ !empty($filter['asset_id']) ? $filter['asset_id'] : '' }}">
        </div>

        <div class="form-group col-md-2">
            <button class="btn btn-block btn-primary btn-filter"><i class="fas fa-search"></i> {{ __('general.btn_search_label') }}</button>
        </div>
    </div>
</form>
