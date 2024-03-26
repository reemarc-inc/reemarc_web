@extends('layouts.dashboard')

@section('content')

    <section class="section">
        <div class="section-header">
            <h1>Patients Status Board</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Patients Status Board</div>
            </div>
        </div>
        <div class="section-body">

            @include('admin.patient.jira_filter')

            <div class="row flex-nowrap" style="overflow-x: scroll; padding-top: 17px;">

                <div class="col-md-3" >
                    <div class="card status_title">
                        <h5 class="status_name">Follow Up</h5>
                    </div>
                    @isset($follow_up_list)
                    @foreach ($follow_up_list as $appointment)
                        <div class="card">
                            <div class="card-header">
                                <li class="media">
                                    <img class="mr-3 rounded-circle" width="50" src="/storage/image/default_profile.png" alt="avatar">
                                    <div class="media-body">
                                        <div class="badge badge-pill badge-success mb-1 float-right">Upcoming</div>
                                        <h6 class="media-title">{{ $appointment->user_last_name }} {{ $appointment->user_first_name }}</h6>
                                        <div class="text-small text-muted">Patient
                                            <?php if( $appointment->booked_date == Carbon\Carbon::now()->format('Y-m-d')) { ?>
                                            <div class="bullet"></div> <span class="text-danger">Today</span>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </li>
                            </div>
                            <div class="card-body" style="display: flex; margin-bottom: -35px;">

                                <div class="col-md-6" style="padding: 0px 0px 0px 0px;">
                                    <div class="form-group">
                                        <div class="input-group info" style="display: block; ">
                                            <div>
                                                <b style="color: #0062FF;">
                                                {{ $appointment->clinic_name }}
                                                </b>
                                            </div>
                                            <div>
                                                <b>
                                                {{ $appointment->clinic_region }}
                                                </b>
                                            </div>
                                            <div>
                                                <b>User ID:</b>
                                                #{{ ucwords($appointment->user_id) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6" style="padding: 0px 0px 0px 0px;">
                                    <div class="form-group">
                                        <div class="input-group info" style="display: block; ">
                                            <div>
                                                <b>Date:</b>
                                                {{ $appointment->booked_date }}
                                            </div>
                                            <div>
                                                <b>Time:</b>
                                                {{ $appointment->booked_time }}
                                            </div>
                                            <div>
                                                <b>Day:</b>
                                                {{ $appointment->booked_day }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="button"
                                        class="btn-sm followup-white-project-btn"
                                        data-toggle="modal"
                                        data-target="#follow-{{$appointment->id}}">Follow Up</button>
                            </div>
                        </div>
                    @endforeach
                    @endisset
                </div>

                <div class="col-md-3" >
                    <div class="card status_title">
                        <h5 class="status_name">Invisalign Order</h5>
                    </div>
                    @isset($package_ready_list)
                        @foreach ($package_ready_list as $row)
                            <div class="card">
                                <div class="card-header">
                                    <li class="media">
                                        <img class="mr-3 rounded-circle" width="50" src="/storage/image/default_profile.png" alt="avatar">
                                        <div class="media-body">
                                            <div class="badge badge-pill badge-info mb-1 float-right">Package Selected</div>
                                            <h6 class="media-title">{{ $row->user_first_name }} {{ $row->user_last_name }}</h6>
                                            <div class="text-small text-muted">
                                                Patient
                                            </div>
                                        </div>
                                    </li>
                                </div>
                                <div class="card-body" style="display: flex; margin-bottom: -35px;">

                                    <div class="col-md-6" style="padding: 0px 0px 0px 0px;">
                                        <div class="form-group">
                                            <div class="input-group info" style="display: block; ">
                                                <div>
                                                    <b style="color: #0062FF;">
                                                        {{ $row->clinic_name }}
                                                    </b>
                                                </div>
                                                <div>
                                                    <b>
                                                    {{ $row->region }}
                                                    </b>
                                                </div>
                                                <div>
                                                    <b>User ID:</b>
                                                    #{{ ucwords($row->user_id) }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6" style="padding: 0px 0px 0px 0px;">
                                        <div class="form-group">
                                            <div class="input-group info" style="display: block; ">
                                                <div>
                                                    <b>Package:</b>
                                                    {{ $row->package_name }}
                                                </div>
                                                <div>
                                                    <b>Num:</b>
                                                    {{ $row->number_of_aligners }}
                                                </div>
                                                <div>
                                                    <b>Period:</b>
                                                    {{ $row->treatment_duration }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <a href="{{ url('admin/treatments/'. $row->treatment_id .'/edit') }}">
                                        <button type="button" class="btn-sm followup-white-project-btn">Order Complete</button>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    @endisset
                </div>

                <div class="col-md-3" >
                    <div class="card status_title">
                        <h5 class="status_name">Delivery Arrival Confirmation</h5>
                    </div>
                    @isset($package_ordered_list)
                        @foreach ($package_ordered_list as $row)
                            <div class="card">
                                <div class="card-header">
                                    <li class="media">
                                        <img class="mr-3 rounded-circle" width="50" src="/storage/image/default_profile.png" alt="avatar">
                                        <div class="media-body">
                                            <div class="badge badge-pill badge-dark mb-1 float-right">Package Ordered</div>
                                            <h6 class="media-title">{{ $row->user_first_name }} {{ $row->user_last_name }}</h6>
                                            <div class="text-small text-muted">
                                                Patient
                                            </div>
                                        </div>
                                    </li>
                                </div>
                                <div class="card-body" style="display: flex; margin-bottom: -35px;">

                                    <div class="col-md-6" style="padding: 0px 0px 0px 0px;">
                                        <div class="form-group">
                                            <div class="input-group info" style="display: block; ">
                                                <div>
                                                    <b style="color: #0062FF;">
                                                        {{ $row->clinic_name }}
                                                    </b>
                                                </div>
                                                <div>
                                                    <b>
                                                    {{ $row->region }}
                                                    </b>
                                                </div>
                                                <div>
                                                    <b>User ID:</b>
                                                    #{{ ucwords($row->user_id) }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6" style="padding: 0px 0px 0px 0px;">
                                        <div class="form-group">
                                            <div class="input-group info" style="display: block; ">
                                                <div>
                                                    <b>Package:</b>
                                                    {{ $row->package_name }}
                                                </div>
                                                <div>
                                                    <b>Num:</b>
                                                    {{ $row->number_of_aligners }}
                                                </div>
                                                <div>
                                                    <b>Period:</b>
                                                    {{ $row->treatment_duration }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <a href="{{ url('admin/treatments/'. $row->treatment_id .'/edit') }}">
                                        <button type="button" class="btn-sm followup-white-project-btn">Package Delivered</button>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    @endisset
                </div>

                <div class="col-md-3" >
                    <div class="card status_title">
                        <h5 class="status_name">Visit Confirm</h5>
                    </div>
                    @isset($visit_confirm_list)
                    @foreach ($visit_confirm_list as $appointment)
                        <div class="card">
                            <div class="card-header">
                                <li class="media">
                                    <img class="mr-3 rounded-circle" width="50" src="/storage/image/default_profile.png" alt="avatar">
                                    <div class="media-body">
                                        <div class="badge badge-pill badge-danger mb-1 float-right">Visit Confirming</div>
                                        <h6 class="media-title">{{ $appointment->user_first_name }} {{ $appointment->user_last_name }}</h6>
                                        <div class="text-small text-muted">Patient
                                            <?php if( $appointment->booked_date == Carbon\Carbon::now()->format('Y-m-d')) { ?>
                                            <div class="bullet"></div> <span class="text-danger">Today</span>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </li>
                            </div>
                            <div class="card-body" style="display: flex; margin-bottom: -35px;">

                                <div class="col-md-6" style="padding: 0px 0px 0px 0px;">
                                    <div class="form-group">
                                        <div class="input-group info" style="display: block; ">
                                            <div>
                                                <b style="color: #0062FF;">
                                                    {{ $appointment->clinic_name }}
                                                </b>
                                            </div>
                                            <div>
                                                <b>
                                                {{ $appointment->clinic_region }}
                                                </b>
                                            </div>
                                            <div>
                                                <b>User ID:</b>
                                                #{{ ucwords($appointment->user_id) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6" style="padding: 0px 0px 0px 0px;">
                                    <div class="form-group">
                                        <div class="input-group info" style="display: block; ">
                                            <div>
                                                <b>Date:</b>
                                                {{ $appointment->booked_date }}
                                            </div>
                                            <div>
                                                <b>Time:</b>
                                                {{ $appointment->booked_time }}
                                            </div>
                                            <div>
                                                <b>Day:</b>
                                                {{ $appointment->booked_day }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="{{ url('admin/treatments/'. $appointment->treatment_id .'/edit') }}">
                                    <button type="button" class="btn-sm followup-white-project-btn">Visit Confirm</button>
                                </a>
                            </div>
                        </div>
                    @endforeach
                    @endisset
                </div>

                <div class="col-md-3" >
                    <div class="card status_title">
                        <h5 class="status_name">Existing Member Pending</h5>
                    </div>
                    @isset($user_pending_list)
                    @foreach ($user_pending_list as $user)
                        <div class="card">
                            <div class="card-header">
                                <li class="media">
                                    <img class="mr-3 rounded-circle" width="50" src="/storage/image/default_profile.png" alt="avatar">
                                    <div class="media-body">
                                        <div class="badge badge-pill badge-warning mb-1 float-right">Member Pending</div>
                                        <h6 class="media-title">{{ $user->first_name }} {{ $user->last_name }} [{{$user->id}}]</h6>
                                        <div class="text-small text-muted">Patient</div>
                                    </div>
                                </li>
                            </div>
                            <div class="card-body" style="display: flex; margin-bottom: -35px;">

{{--                                <div class="col-md-6" style="padding: 0px 0px 0px 0px;">--}}
{{--                                    <div class="form-group">--}}
{{--                                        <div class="input-group info" style="display: block; ">--}}
{{--                                            <div>--}}
{{--                                                <b style="color: #0062FF;">--}}
{{--                                                    {{ $user->id }}--}}
{{--                                                </b>--}}
{{--                                            </div>--}}
{{--                                            <div>--}}
{{--                                                <b>User ID:</b>--}}
{{--                                                #{{ $user->id }}--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="col-md-6" style="padding: 0px 0px 0px 0px;">--}}
{{--                                    <div class="form-group">--}}
{{--                                        <div class="input-group info" style="display: block; ">--}}
{{--                                            <div>--}}
{{--                                                <b>Date:</b>--}}
{{--                                                {{ $user->created_at }}--}}
{{--                                            </div>--}}
{{--                                            <div>--}}
{{--                                                <b>Time:</b>--}}
{{--                                                {{ $user->id }}--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                            </div>
                            <div class="card-footer">
                                <a href="{{ url('admin/users/existing_user_pending/'. $user->id) }}">
                                    <button type="button" class="btn-sm followup-white-project-btn">Review</button>
                                </a>
{{--                                <button type="button"--}}
{{--                                        class="btn-sm followup-white-project-btn"--}}
{{--                                        data-toggle="modal"--}}
{{--                                        data-target="#follow-{{$user->id}}">--}}
{{--                                    Review--}}
{{--                                </button>--}}
                            </div>
                        </div>
                    @endforeach
                    @endisset
                </div>

            </div>
        </div>

        @isset($follow_up_list)
        <div class="row" style="margin-top: 15px;">
            @foreach ($follow_up_list as $appointment)
                <div id="follow-{{$appointment->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="followModalLabel" aria-hidden="true" data-backdrop="false">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <form method="POST" action="{{ route('appointment.follow_up_complete') }}" enctype="multipart/form-data">
                                @csrf

                                <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">

                                <div class="modal-header" style="color: #b91d19;">
                                    <h4 class="modal-title" id="myModalLabel" >Have you completed updating the patient data in Invisalign?</h4><br><br><br>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                </div>
                                <div class="modal-body" style="text-align: center;">

                                    <h3 class="modal-title">{{ $appointment->user_first_name }} {{ $appointment->user_last_name }}</h3>
                                    <br>
                                    <h4>{{ $appointment->booked_date }}, {{ $appointment->booked_day }} {{ $appointment->booked_time }}</h4>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-info" onclick="return confirm('Are you sure?')">Yes. It's Completed</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        @endisset

@endsection



<script type="text/javascript">
    // 420 by 1 col
    function moveScrollLeft(){
        var _scrollX = $('.flex-nowrap').scrollLeft();
        $('.flex-nowrap').animate({
            scrollLeft:_scrollX + 1630}, 500);
    }

    function moveScrollRight(){
        var _scrollX = $('.flex-nowrap').scrollLeft();
        $('.flex-nowrap').animate({
            scrollLeft:_scrollX - 1630}, 500);
    }

</script>

<style type="text/css">

    .left {
        display: inline-block;
        width: 4em;
        height: 4em;
        border-color: #E9E9E9;
        border-radius: 50%;
        margin-right: 1.0em;
        background-color: #EFEFEF;
        border: 1px solid #ebebeb;
    }

    .left:after {
        content: '';
        display: inline-block;
        margin-top: 1.5em;
        margin-left: 1.5em;
        width: 1.0em;
        height: 1.0em;
        border-top: 0.3em solid #848484;
        border-right: 0.3em solid #848484;
        -moz-transform: rotate(-135deg);
        -webkit-transform: rotate(-135deg);
        transform: rotate(-135deg);
    }

    .left:hover {
        background-color: #fdfdfd;
        border-color: #848484;
        border: 1px solid #ebebeb;
    }

    .left:hover:after {
        border-top: 0.3em solid #2f2f2f;
        border-right: 0.3em solid #2f2f2f;
        -moz-transform: rotate(-135deg);
        -webkit-transform: rotate(-135deg);
        transform: rotate(-135deg);
    }

    .right {
        display: inline-block;
        width: 4em;
        height: 4em;
        border-color: #E9E9E9;
        border-radius: 50%;
        margin-left: -0.5em;
        background-color: #EFEFEF;
        border: 1px solid #ebebeb;
    }

    .right:after {
        content: '';
        display: inline-block;
        margin-top: 1.5em;
        margin-left: 1.3em;
        width: 1.0em;
        height: 1.0em;
        border-top: 0.3em solid #848484;
        border-right: 0.3em solid #848484;
        -moz-transform: rotate(45deg);
        -webkit-transform: rotate(45deg);
        transform: rotate(45deg);
    }

    .right:hover {
        background-color: #fdfdfd;
        border-color: #848484;
        border: 1px solid #ebebeb;
    }

    .right:hover:after {
        border-top: 0.3em solid #2f2f2f;
        border-right: 0.3em solid #2f2f2f;
        -moz-transform: rotate(45deg);
        -webkit-transform: rotate(45deg);
        transform: rotate(45deg);
    }

    .follow {
        right: 2%;
        z-index: 1;
    }

</style>
