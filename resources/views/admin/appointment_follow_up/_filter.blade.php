<form method="GET" action="{{ route('appointment.follow_up') }}">
    <div class="form-row" style="background-color: white; margin: -16px 0px 0px 0px; padding: 0px 0px 0px 12px;">
        <hr width="99%" />
        <div class="form-group col-md-3">
            <?php
            if(auth()->user()->role == 'doctor'){
                $condition = 'disabled';
            }else{
                $condition = '';
            }
            ?>
            <select class="design-select" name="clinic" {{ $condition }}>
                <option value="">Select Clinic</option>
                @foreach ($clinics as $key => $value)
                    <option value="{{ $value->id }}" @if( $value->id == $clinic) selected="selected" @endif >
                        {{$value->name}}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-3">
            <select class="design-select" name="status">
                <option value="">Select Status</option>
                @foreach ($statuss_ as $value)
                    <option value="{{ $value }}" @if( $value == $status) selected="selected" @endif >
                        {{$value}}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-2">
            <button class="design-btn"> Apply </button>
        </div>
{{--        <div class="form-group col-md-2">--}}
{{--            <a href="{{ url('admin/campaign/create') }}">--}}
{{--                <button type="button" class="design-white-btn"><i class="fas fa-plus"></i> Create</button>--}}
{{--            </a>--}}
{{--        </div>--}}
    </div>
</form>
