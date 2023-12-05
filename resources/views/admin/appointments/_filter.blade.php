<form method="GET" action="{{ route('appointments_list.index') }}">
    <div class="form-row" style="background-color: white; margin: -16px 0px 0px 0px; padding: 0px 0px 0px 12px;">
        <hr width="99%" />
        <div class="form-group col-md-4">
        <input type="text" name="q" class="design-field" id="q" placeholder="Type name or email.." value="{{ !empty($filter['q']) ? $filter['q'] : old('q') }}">
        </div>
        <div class="form-group col-md-2">
            <select class="design-select" name="region">
                <option value="">Select Region</option>
                @foreach ($teams_ as $value)
                    <option value="{{ $value }}" @if( $value == $region_) selected="selected" @endif >
                        {{$value}}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-2">
            <select class="design-select" name="status">
                <option value="">Select Status</option>
                @foreach ($statuss_ as $value)
                    <option value="{{ $value }}" @if( $value == $status_) selected="selected" @endif >
                        {{$value}}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-2">
            <button class="design-white-btn">Apply</button>
        </div>
{{--        <div class="form-group col-md-2">--}}
{{--            <a href="{{ url('admin/appointment/create') }}">--}}
{{--                <button type="button" class="design-white-btn"><i class="fas fa-plus"></i> Create</button>--}}
{{--            </a>--}}
{{--        </div>--}}
    </div>
</form>
