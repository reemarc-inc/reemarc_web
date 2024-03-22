<form method="GET" action="{{ route('patient.jira') }}">
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
        <div class="form-group col-md-2">
            <button class="design-white-btn">Apply</button>
        </div>
        <div class="form-group col-md-5">
        </div>
{{--        <div class="form-group col-md-2">--}}
{{--            <div class="follow" style="float:right; margin-top: -5px; padding-right: 15px;">--}}
{{--                <i class="left" onclick="moveScrollRight()" ></i>--}}
{{--                <i class="right" onclick="moveScrollLeft()" ></i>--}}
{{--            </div>--}}
{{--        </div>--}}
    </div>
</form>
