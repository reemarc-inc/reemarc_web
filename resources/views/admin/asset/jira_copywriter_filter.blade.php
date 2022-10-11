<form method="GET" action="{{ route('asset.jira_copywriter') }}">
    <div class="form-row">
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
            <button class="btn btn-block btn-primary btn-filter"><i class="fas fa-search"></i> {{ __('general.btn_search_label') }}</button>
        </div>
    </div>
</form>
