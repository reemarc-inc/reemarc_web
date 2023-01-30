<form method="GET" action="{{ route('asset.jira_kec') }}">
    <div class="form-row">

        <div class="form-group col-md-2" style="max-width: 12.666%;">
            <div class="text-small font-600-bold" style="color: #a50018;"><i class="fas fa-circle"></i> Creative</div>
            <div class="text-small font-600-bold" style="color: #018d1d;"><i class="fas fa-circle"></i> Content</div>
            <div class="text-small font-600-bold" style="color: #230084;"><i class="fas fa-circle"></i> Web Production</div>
        </div>

        <div class="form-group col-md-2">
            <select class="form-control" name="team">
                <option value="">Select Team</option>
                @foreach ($teams as $key => $value)
                    <option value="{{ $value }}" @if( $value == $team_) selected="selected" @endif >
                        {{ucfirst($value)}}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-md-2">
            <input type="text" name="q" class="form-control" id="q" placeholder="Search by Author Name" value="{{ !empty($filter['q']) ? $filter['q'] : '' }}">
        </div>

        <div class="form-group col-md-2">
            <select class="form-control" name="brand">
                <option value="">Select Brand</option>
                @foreach ($brands as $key => $value)
                    <option value="{{ $key }}" @if( $key == $brand_) selected="selected" @endif >
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
