@extends('layouts.dashboard')

@section('content')

    <section class="section">
        <div class="section-header">
            <h1>Package Status Board</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Package Status Board</div>
            </div>
        </div>
        <div class="section-body">

            @include('admin.treatments.jira_filter')

            <div class="row flex-nowrap" style="overflow-x: scroll; padding-top: 17px;">

                <div class="col-md-3" >
                    <div class="card status_title">
                        <h5 class="status_name">FOLLOW UP COMPLETED</h5>
                    </div>

                    @foreach ($follow_up_completed_list as $obj)
                    <div class="card">
                        <a href="{{ url('admin/treatments/'. $obj->treatment_id .'/edit')}}" style="text-decoration: none;">
                            <div class="card-body" style="padding-left: 10px; padding-right: 10px; margin-bottom: -25px;">
                                <div class="media" style="padding-bottom: 0px;">
                                    <div class="form-group" style="width: 100%; padding: 0 8 0 8;" >

                                        <div style="color: #8b8a8a; font-weight: 600; float:left; font-size: 13px;">
                                            {{ $obj->clinic_name }}
                                        </div>
{{--                                        <div style="float: right;">--}}
{{--                                            <figure class="avatar mr-2 avatar-sm text-white" style="background-color: #b6b6b6; font-size: 15px;"--}}
{{--                                                    data-toggle="tooltip" data-placement="top"--}}
{{--                                                    data-original-title="{{  }}"--}}
{{--                                                    data-initial="{{ substr('Sunny', 0, 1) }}">--}}
{{--                                            </figure>--}}
{{--                                        </div>--}}
                                        <div class="media-title" style="clear:both; font-size: large;">
                                            {{ $obj->user_first_name }} {{ $obj->user_last_name }}
                                        </div>
                                        <div class="text-md-left text-muted" style="margin-top: -8px;">
                                            {{ $obj->booked_day }},  {{ $obj->booked_date }}
                                        </div>
                                        <hr style="border-width: 1px 0px 0px 0px;border-style:solid;border-color: #e0e0e0;
                                                            height:1px;margin-top: 15px;margin-bottom: 10px;width:100%">

                                        <div class="text-sm-left text-muted" style="float:left; padding-top: 3px;">
                                            <figure class="avatar sm-2 text-white" style="width: 15px; height: 15px; font-size: small;" data-initial=""></figure>
                                        </div>
                                        <div class="text-sm-left text-muted" style="float:left; padding-left: 10px;">
                                            {{ $obj->clinic_region }}
                                        </div>
                                        <div style="float: right;" >
                                            {{ $obj->booked_time }}
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>

                <div class="col-md-3" >
                    <div class="card status_title">
                        <h5 class="status_name">PACKAGE READY</h5>
                    </div>
                    @foreach ($package_ready_list as $obj)
                        <div class="card">
                            <a href="{{ url('admin/treatments/'. $obj->treatment_id .'/edit')}}" style="text-decoration: none;">
                                <div class="card-body" style="padding-left: 10px; padding-right: 10px; margin-bottom: -25px;">
                                    <div class="media" style="padding-bottom: 0px;">
                                        <div class="form-group" style="width: 100%; padding: 0 8 0 8;" >

                                            <div style="color: #8b8a8a; font-weight: 600; float:left; font-size: 13px;">
                                                {{ $obj->clinic_name }}
                                            </div>
                                            {{--                                        <div style="float: right;">--}}
                                            {{--                                            <figure class="avatar mr-2 avatar-sm text-white" style="background-color: #b6b6b6; font-size: 15px;"--}}
                                            {{--                                                    data-toggle="tooltip" data-placement="top"--}}
                                            {{--                                                    data-original-title="{{  }}"--}}
                                            {{--                                                    data-initial="{{ substr('Sunny', 0, 1) }}">--}}
                                            {{--                                            </figure>--}}
                                            {{--                                        </div>--}}
                                            <div class="media-title" style="clear:both; font-size: large;">
                                                {{ $obj->user_first_name }} {{ $obj->user_last_name }}
                                            </div>
                                            <div class="text-md-left text-muted" style="margin-top: -8px;">
                                                {{ $obj->booked_day }},  {{ $obj->booked_date }}
                                            </div>
                                            <hr style="border-width: 1px 0px 0px 0px;border-style:solid;border-color: #e0e0e0;
                                                            height:1px;margin-top: 15px;margin-bottom: 10px;width:100%">

                                            <div class="text-sm-left text-muted" style="float:left; padding-top: 3px;">
                                                <figure class="avatar sm-2 text-white" style="width: 15px; height: 15px; font-size: small;" data-initial=""></figure>
                                            </div>
                                            <div class="text-sm-left text-muted" style="float:left; padding-left: 10px;">
                                                {{ $obj->clinic_region }}
                                            </div>
                                            <div style="float: right;" >
                                                {{ $obj->booked_time }}
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                <div class="col-md-3" >
                    <div class="card status_title">
                        <h5 class="status_name">PACKAGE ORDERED</h5>
                    </div>
                    @foreach ($package_ordered_list as $obj)
                        <div class="card">
                            <a href="{{ url('admin/treatments/'. $obj->treatment_id .'/edit')}}" style="text-decoration: none;">
                                <div class="card-body" style="padding-left: 10px; padding-right: 10px; margin-bottom: -25px;">
                                    <div class="media" style="padding-bottom: 0px;">
                                        <div class="form-group" style="width: 100%; padding: 0 8 0 8;" >

                                            <div style="color: #8b8a8a; font-weight: 600; float:left; font-size: 13px;">
                                                {{ $obj->clinic_name }}
                                            </div>
                                            {{--                                        <div style="float: right;">--}}
                                            {{--                                            <figure class="avatar mr-2 avatar-sm text-white" style="background-color: #b6b6b6; font-size: 15px;"--}}
                                            {{--                                                    data-toggle="tooltip" data-placement="top"--}}
                                            {{--                                                    data-original-title="{{  }}"--}}
                                            {{--                                                    data-initial="{{ substr('Sunny', 0, 1) }}">--}}
                                            {{--                                            </figure>--}}
                                            {{--                                        </div>--}}
                                            <div class="media-title" style="clear:both; font-size: large;">
                                                {{ $obj->user_first_name }} {{ $obj->user_last_name }}
                                            </div>
                                            <div class="text-md-left text-muted" style="margin-top: -8px;">
                                                {{ $obj->booked_day }},  {{ $obj->booked_date }}
                                            </div>
                                            <hr style="border-width: 1px 0px 0px 0px;border-style:solid;border-color: #e0e0e0;
                                                            height:1px;margin-top: 15px;margin-bottom: 10px;width:100%">

                                            <div class="text-sm-left text-muted" style="float:left; padding-top: 3px;">
                                                <figure class="avatar sm-2 text-white" style="width: 15px; height: 15px; font-size: small;" data-initial=""></figure>
                                            </div>
                                            <div class="text-sm-left text-muted" style="float:left; padding-left: 10px;">
                                                {{ $obj->clinic_region }}
                                            </div>
                                            <div style="float: right;" >
                                                {{ $obj->booked_time }}
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                <div class="col-md-3" >
                    <div class="card status_title">
                        <h5 class="status_name">LOCATION SENT</h5>
                    </div>
                    @foreach ($location_sent_list as $obj)
                        <div class="card">
                            <a href="{{ url('admin/treatments/'. $obj->treatment_id .'/edit')}}" style="text-decoration: none;">
                                <div class="card-body" style="padding-left: 10px; padding-right: 10px; margin-bottom: -25px;">
                                    <div class="media" style="padding-bottom: 0px;">
                                        <div class="form-group" style="width: 100%; padding: 0 8 0 8;" >

                                            <div style="color: #8b8a8a; font-weight: 600; float:left; font-size: 13px;">
                                                {{ $obj->clinic_name }}
                                            </div>
                                            {{--                                        <div style="float: right;">--}}
                                            {{--                                            <figure class="avatar mr-2 avatar-sm text-white" style="background-color: #b6b6b6; font-size: 15px;"--}}
                                            {{--                                                    data-toggle="tooltip" data-placement="top"--}}
                                            {{--                                                    data-original-title="{{  }}"--}}
                                            {{--                                                    data-initial="{{ substr('Sunny', 0, 1) }}">--}}
                                            {{--                                            </figure>--}}
                                            {{--                                        </div>--}}
                                            <div class="media-title" style="clear:both; font-size: large;">
                                                {{ $obj->user_first_name }} {{ $obj->user_last_name }}
                                            </div>
                                            <div class="text-md-left text-muted" style="margin-top: -8px;">
                                                {{ $obj->booked_day }},  {{ $obj->booked_date }}
                                            </div>
                                            <hr style="border-width: 1px 0px 0px 0px;border-style:solid;border-color: #e0e0e0;
                                                            height:1px;margin-top: 15px;margin-bottom: 10px;width:100%">

                                            <div class="text-sm-left text-muted" style="float:left; padding-top: 3px;">
                                                <figure class="avatar sm-2 text-white" style="width: 15px; height: 15px; font-size: small;" data-initial=""></figure>
                                            </div>
                                            <div class="text-sm-left text-muted" style="float:left; padding-left: 10px;">
                                                {{ $obj->clinic_region }}
                                            </div>
                                            <div style="float: right;" >
                                                {{ $obj->booked_time }}
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                <div class="col-md-3" >
                    <div class="card status_title">
                        <h5 class="status_name">LOCATION CONFIRMED</h5>
                    </div>
                    @foreach ($location_confirmed_list as $obj)
                        <div class="card">
                            <a href="{{ url('admin/treatments/'. $obj->treatment_id .'/edit')}}" style="text-decoration: none;">
                                <div class="card-body" style="padding-left: 10px; padding-right: 10px; margin-bottom: -25px;">
                                    <div class="media" style="padding-bottom: 0px;">
                                        <div class="form-group" style="width: 100%; padding: 0 8 0 8;" >

                                            <div style="color: #8b8a8a; font-weight: 600; float:left; font-size: 13px;">
                                                {{ $obj->clinic_name }}
                                            </div>
                                            {{--                                        <div style="float: right;">--}}
                                            {{--                                            <figure class="avatar mr-2 avatar-sm text-white" style="background-color: #b6b6b6; font-size: 15px;"--}}
                                            {{--                                                    data-toggle="tooltip" data-placement="top"--}}
                                            {{--                                                    data-original-title="{{  }}"--}}
                                            {{--                                                    data-initial="{{ substr('Sunny', 0, 1) }}">--}}
                                            {{--                                            </figure>--}}
                                            {{--                                        </div>--}}
                                            <div class="media-title" style="clear:both; font-size: large;">
                                                {{ $obj->user_first_name }} {{ $obj->user_last_name }}
                                            </div>
                                            <div class="text-md-left text-muted" style="margin-top: -8px;">
                                                {{ $obj->booked_day }},  {{ $obj->booked_date }}
                                            </div>
                                            <hr style="border-width: 1px 0px 0px 0px;border-style:solid;border-color: #e0e0e0;
                                                            height:1px;margin-top: 15px;margin-bottom: 10px;width:100%">

                                            <div class="text-sm-left text-muted" style="float:left; padding-top: 3px;">
                                                <figure class="avatar sm-2 text-white" style="width: 15px; height: 15px; font-size: small;" data-initial=""></figure>
                                            </div>
                                            <div class="text-sm-left text-muted" style="float:left; padding-left: 10px;">
                                                {{ $obj->clinic_region }}
                                            </div>
                                            <div style="float: right;" >
                                                {{ $obj->booked_time }}
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                <div class="col-md-3" >
                    <div class="card status_title">
                        <h5 class="status_name">PACKAGE SHIPPED</h5>
                    </div>
                    @foreach ($package_shipped_list as $obj)
                        <div class="card">
                            <a href="{{ url('admin/treatments/'. $obj->treatment_id .'/edit')}}" style="text-decoration: none;">
                                <div class="card-body" style="padding-left: 10px; padding-right: 10px; margin-bottom: -25px;">
                                    <div class="media" style="padding-bottom: 0px;">
                                        <div class="form-group" style="width: 100%; padding: 0 8 0 8;" >

                                            <div style="color: #8b8a8a; font-weight: 600; float:left; font-size: 13px;">
                                                {{ $obj->clinic_name }}
                                            </div>
                                            <div class="media-title" style="clear:both; font-size: large;">
                                                {{ $obj->user_first_name }} {{ $obj->user_last_name }}
                                            </div>
                                            <div class="text-md-left text-muted" style="margin-top: -8px;">
                                                {{ $obj->booked_day }},  {{ $obj->booked_date }}
                                            </div>
                                            <hr style="border-width: 1px 0px 0px 0px;border-style:solid;border-color: #e0e0e0;
                                                            height:1px;margin-top: 15px;margin-bottom: 10px;width:100%">

                                            <div class="text-sm-left text-muted" style="float:left; padding-top: 3px;">
                                                <figure class="avatar sm-2 text-white" style="width: 15px; height: 15px; font-size: small;" data-initial=""></figure>
                                            </div>
                                            <div class="text-sm-left text-muted" style="float:left; padding-left: 10px;">
                                                {{ $obj->clinic_region }}
                                            </div>
                                            <div style="float: right;" >
                                                {{ $obj->booked_time }}
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                <div class="col-md-3" >
                    <div class="card status_title">
                        <h5 class="status_name">PACKAGE DELIVERED</h5>
                    </div>
                    @foreach ($package_delivered_list as $obj)
                        <div class="card">
                            <a href="{{ url('admin/treatments/'. $obj->treatment_id .'/edit')}}" style="text-decoration: none;">
                                <div class="card-body" style="padding-left: 10px; padding-right: 10px; margin-bottom: -25px;">
                                    <div class="media" style="padding-bottom: 0px;">
                                        <div class="form-group" style="width: 100%; padding: 0 8 0 8;" >

                                            <div style="color: #8b8a8a; font-weight: 600; float:left; font-size: 13px;">
                                                {{ $obj->clinic_name }}
                                            </div>
                                            <div class="media-title" style="clear:both; font-size: large;">
                                                {{ $obj->user_first_name }} {{ $obj->user_last_name }}
                                            </div>
                                            <div class="text-md-left text-muted" style="margin-top: -8px;">
                                                {{ $obj->booked_day }},  {{ $obj->booked_date }}
                                            </div>
                                            <hr style="border-width: 1px 0px 0px 0px;border-style:solid;border-color: #e0e0e0;
                                                            height:1px;margin-top: 15px;margin-bottom: 10px;width:100%">

                                            <div class="text-sm-left text-muted" style="float:left; padding-top: 3px;">
                                                <figure class="avatar sm-2 text-white" style="width: 15px; height: 15px; font-size: small;" data-initial=""></figure>
                                            </div>
                                            <div class="text-sm-left text-muted" style="float:left; padding-left: 10px;">
                                                {{ $obj->clinic_region }}
                                            </div>
                                            <div style="float: right;" >
                                                {{ $obj->booked_time }}
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

{{--                <div class="col-md-3" >--}}
{{--                    <div class="card status_title">--}}
{{--                        <h5 class="status_name">TREATMENT UPCOMING</h5>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                <div class="col-md-3" >--}}
{{--                    <div class="card status_title">--}}
{{--                        <h5 class="status_name">TREATMENT COMPLETED</h5>--}}
{{--                    </div>--}}
{{--                </div>--}}

            </div>
        </div>



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
