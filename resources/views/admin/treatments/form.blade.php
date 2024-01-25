@extends('layouts.dashboard')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Treatment Management </h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ url('admin/treatments') }}">Treatments</a></div>
                <div class="breadcrumb-item">Edit treatments</div>
            </div>
        </div>

        <br>
        @if (empty($treatment ?? '' ?? ''))
        <form method="POST" action="{{ route('treatments.store') }}">
        @else
        <form method="POST" action="{{ route('treatments.update', $treatment->id) }}">
            <input type="hidden" name="id" value="{{ $treatment->id }}" />
        @endif
            @csrf
            <div class="section-body">
                <div class="row">
                    <div class="col-lg-8">

{{--                        <?php if($treatment->status == 'package_delivered' || $treatment->status == 'treatment_started'){ ?>--}}

{{--                            <div class="card">--}}
{{--                                <div class="card-header">--}}
{{--                                    <h4>Treatment Schedule : {{ $sessions[$treatment->session] }} Months / {{ $treatment->session }} Sessions</h4>--}}
{{--                                </div>--}}
{{--                                <div class="card-body">--}}

{{--                                </div>--}}
{{--                                <div class="card-footer text-right">--}}

{{--                                </div>--}}
{{--                            </div>--}}

{{--                        <?php } ?>--}}

                        <?php if($treatment->status == 'treatment_started'){ ?>
                        <div class="card">
                            <input type="hidden" name="t_id" value="{{ $treatment->id }}">
                            <div class="card-header">
                                <h4>Treatment Schedule : {{ $treatment->session }} Sessions  / {{ $sessions[$treatment->session] }} Sessions</h4>
                            </div>

                            <div class="card-body">

                                <?php for($i=1; $i<=$treatment->session; $i++) { ?>
                                <?php $x = 100/$treatment->session; ?>
                                <?php if(count($current_session) >= $i) {
                                    $bg_css = "bg-secondary"; $font_css = "color: #1a1a1a;";
                                }else{
                                    $bg_css = "bg-primary"; $font_css = "color: #fff;";
                                }
                                ?>
                                <div class="progress mb-3" style="height: 30px; border-radius: 0.75rem;">
                                    <div class="progress-bar {{ $bg_css }}" role="progressbar" data-width="{{$i*$x}}%" aria-valuenow="50" aria-valuemin="0" aria-valuemin="100" style="width: 10%; font-size: 1rem; {{$font_css}}">Session {{ $i }}  {{ !empty($current_session[$i-1]) ? "   [ ".date("m/d/y g A", strtotime($current_session[$i-1]->booked_start))." ]" : ''}} </div>
                                </div>
                                <?php } ?>
                            </div>

                            <div class="card-footer text-right">
                                    <?php if(isset($last_session_status) && ($last_session_status->status == 'Treatment_Upcoming')){ ?>
                                    <button type="button" id="btn_send_notification" class="btn btn-icon icon-left btn-danger" style="font-size: medium;" onclick="visit_confirm({{$treatment->id}})"><i class="fa fa-paper-plane"> </i> Visit Confirm Send</button>
                                    <?php }else{ ?>
                                    <span class="badge badge-dark" style="font-size: large;"><i class="fa fa-check-circle"> </i> This package has been successfully delivered</span>
                                    <?php } ?>
                            </div>
                        </div>
                        <?php } ?>

                        <div class="card">
                            <div class="card-header" style="position: relative;">
                                <h4>Patient</h4>
                                <nav style="position: absolute; top: 0; right: 0; padding: 20px;">
                                    <ul>
                                        <span class="badge badge-primary">{{ $treatment->status }}</span>
                                    </ul>
                                </nav>
                            </div>
                            <div class="card-body">
                                @include('admin.shared.flash')
                                <div class="row">
                                    <div class="form-group col-md-4" >
                                        <label>First Name</label>
                                        <input type="text" name="user_first_name"
                                           class="form-control @error('user_first_name') is-invalid @enderror @if (!$errors->has('user_first_name') && old('user_first_name')) is-valid @endif"
                                           value="{{ old('user_first_name', !empty($user) ? $user->first_name : null) }}">
                                        @error('user_first_name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Last Name</label>
                                            <input type="text" name="user_last_name"
                                               class="form-control @error('user_last_name') is-invalid @enderror @if (!$errors->has('user_last_name') && old('user_last_name')) is-valid @endif"
                                               value="{{ old('user_last_name', !empty($user) ? $user->last_name : null) }}">
                                        @error('user_last_name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Year of Birth</label>
                                        <input type="text" name="user_yob"
                                               class="form-control @error('user_yob') is-invalid @enderror @if (!$errors->has('user_yob') && old('user_yob')) is-valid @endif"
                                               value="{{ old('user_yob', !empty($user) ? $user->yob : null) }}">
                                        @error('user_last_name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Email</label>
                                        <input type="text" name="user_email"
                                               class="form-control @error('user_email') is-invalid @enderror @if (!$errors->has('user_email') && old('user_email')) is-valid @endif"
                                               value="{{ old('user_email', !empty($user) ? $user->email : null) }}">
                                        @error('user_email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-8">
                                        <label>Gender</label>
                                        <div class="selectgroup w-100">
                                            @foreach ($genders_ as $key => $value)
                                                <label class="selectgroup-item">
                                                    <input type="radio" name="user_gender" value="{{ $value }}" class="selectgroup-input" {{ $value == $gender ? 'checked=""' : '' }}>
                                                    <span class="selectgroup-button">{{ $key }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h4>Clinic</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>Name</label>
                                        <input type="text"
                                               class="form-control"
                                               value="{{ $clinic->name }}" disabled>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>Region</label>
                                        <input type="text"
                                               class="form-control"
                                               value="{{ $clinic->region }}" disabled>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label>Address</label>
                                        <input type="text"
                                               class="form-control"
                                               value="{{ $clinic->address }}" disabled>
                                    </div>

{{--                                    <div class="form-group col-md-12">--}}
{{--                                        <label>Ship to Office</label>--}}
{{--                                        <textarea class="form-control" id="ship_to_office" name="ship_to_office" style="height: 50px;">{{ old('description', !empty($treatment) ? $treatment->ship_to_office : null) }}</textarea>--}}
{{--                                        @error('ship_to_office')--}}
{{--                                        <div class="invalid-feedback">--}}
{{--                                            {{ $message }}--}}
{{--                                        </div>--}}
{{--                                        @enderror--}}
{{--                                    </div>--}}

                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h4>Package Order</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label>Invisalign</label>
                                        <div class="selectgroup w-100">
                                            @foreach ($packages as $value)
                                                <label class="selectgroup-item">
                                                    <input type="radio" name="package" value="{{ $value->id }}" class="selectgroup-input" {{ $value->id == $package ? 'checked=""' : '' }}>
                                                    <span class="selectgroup-button">{{ $value->name }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label>Sessions</label>
                                        <div class="selectgroup w-100">
                                        @foreach ($sessions as $key=>$value)
                                            <label class="selectgroup-item">
                                                <input type="radio" name="session" value="{{ $key }}-{{ $value }}" class="selectgroup-input" {{ $key == $session ? 'checked=""' : '' }}>
                                                <span class="selectgroup-button">{{ $value}} Month ({{$key}})</span>
                                            </label>
                                        @endforeach
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <?php if($treatment->status == 'follow_up_completed' ){ ?>
                                <button class="btn btn-primary">{{ empty($treatment) ? __('general.btn_create_label') : __('general.btn_update_label') }}</button>
                                <?php } ?>
                            </div>
                            <div class="card-footer text-right">
                                <?php if($treatment->status == 'package_ready' ){ ?>
                                <button type="button" id="btn_send_notification" class="btn btn-icon icon-left btn-danger" style="font-size: medium;" onclick="package_order({{$treatment->id}})"><i class="fa fa-paper-plane"> </i> Order Complete</button>
                                <?php }elseif ($treatment->status == 'package_ordered'
                                    || $treatment->status == 'location_sent'
                                    || $treatment->status == 'location_confirmed'
                                    || $treatment->status == 'package_shipped'
                                    || $treatment->status == 'package_delivered'
                                    || $treatment->status == 'treatment_started') { ?>
                                    <span class="badge badge-dark" style="font-size: large;"><i class="fa fa-check-circle"> </i> The package order has been successfully completed.</span>
                                <?php } ?>
                            </div>


                        </div>


                        <?php if($treatment->status == 'package_ordered'
                        || $treatment->status == 'location_sent'
                        || $treatment->status == 'location_confirmed'
                        || $treatment->status == 'package_shipped'
                        || $treatment->status == 'package_delivered'
                            || $treatment->status == 'treatment_started'){ ?>
                        <div class="card">
                            <input type="hidden" name="t_id" value="{{ $treatment->id }}">
                            <div class="card-header">
                                <h4>Location Send</h4>
                            </div>
                            <div class="card-footer text-right">
                                <?php if($treatment->status == 'package_ordered') { ?>
                                <button type="button" id="btn_send_notification" class="btn btn-icon icon-left btn-danger" style="font-size: medium;" onclick="location_send({{$treatment->id}})"><i class="fa fa-paper-plane"> </i> Send Location Confirm Notification</button>
                                <?php }else if($treatment->status == 'location_sent'
                                    || $treatment->status == 'location_confirmed'
                                    || $treatment->status == 'package_shipped'
                                    || $treatment->status == 'package_delivered'
                                    || $treatment->status == 'treatment_started') { ?>
                                    <span class="badge badge-dark" style="font-size: large;"><i class="fa fa-check-circle"> </i> The notification has been successfully sent.</span>
                                <?php } ?>
                            </div>
                        </div>
                        <?php } ?>

                        <?php if($treatment->status == 'location_sent'
                        || $treatment->status == 'location_confirmed'
                        || $treatment->status == 'package_shipped'
                        || $treatment->status == 'package_delivered'
                            || $treatment->status == 'treatment_started'){ ?>
                        <div class="card">
                            <input type="hidden" name="t_id" value="{{ $treatment->id }}">
                            <div class="card-header">
                                <h4>Location Confirm</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label>Ship to address</label>
                                        <input type="text"
                                               class="form-control"
                                               value="{{ $treatment->ship_to_office }}" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <?php if($treatment->status == 'location_sent') { ?>
                                <span class="badge badge-danger" style="font-size: large;"><i class="fa fa-paper-plane"> </i> Waiting for location confirmation</span>
                                <?php }else if($treatment->status == 'location_confirmed'
                                    || $treatment->status == 'package_shipped'
                                    || $treatment->status == 'package_delivered'
                                    || $treatment->status == 'treatment_started') { ?>
                                <span class="badge badge-dark" style="font-size: large;"><i class="fa fa-check-circle"> </i> The Location was confirmed</span>
                                <?php } ?>
                            </div>
                        </div>
                        <?php } ?>

                        <?php if($treatment->status == 'location_confirmed'
                        || $treatment->status == 'package_shipped'
                        || $treatment->status == 'package_delivered'
                            || $treatment->status == 'treatment_started'){ ?>
                        <div class="card">
                            <input type="hidden" name="t_id" value="{{ $treatment->id }}">
                            <div class="card-header">
                                <h4>Package Ship</h4>
                            </div>
                            <div class="card-footer text-right">
                                <?php if($treatment->status == 'location_confirmed') { ?>
                                <button type="button" id="btn_send_notification" class="btn btn-icon icon-left btn-danger" style="font-size: medium;" onclick="package_ship({{$treatment->id}})"><i class="fa fa-paper-plane"> </i> Package Shipped</button>
                                <?php }else if($treatment->status == 'package_shipped'
                                                || $treatment->status == 'package_delivered'
                                    || $treatment->status == 'treatment_started') { ?>
                                <span class="badge badge-dark" style="font-size: large;"><i class="fa fa-check-circle"> </i> The package has been successfully shipped</span>
                                <?php } ?>
                            </div>
                        </div>
                        <?php } ?>

                        <?php if($treatment->status == 'package_shipped'
                        || $treatment->status == 'package_delivered'
                            || $treatment->status == 'treatment_started'){ ?>
                        <div class="card">
                            <input type="hidden" name="t_id" value="{{ $treatment->id }}">
                            <div class="card-header">
                                <h4>Package Delivery</h4>
                            </div>
                            <div class="card-footer text-right">
                                <?php if($treatment->status == 'package_shipped') { ?>
                                <button type="button" id="btn_send_notification" class="btn btn-icon icon-left btn-danger" style="font-size: medium;" onclick="package_delivery({{$treatment->id}})"><i class="fa fa-paper-plane"> </i> Package Delivered</button>
                                <?php }else if($treatment->status == 'package_delivered' || $treatment->status == 'treatment_started') { ?>
                                <span class="badge badge-dark" style="font-size: large;"><i class="fa fa-check-circle"> </i> This package has been successfully delivered</span>
                                <?php } ?>
                            </div>
                        </div>
                        <?php } ?>



                    </div>

                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header" style="position: relative;">
                                <h4>History</h4>
                            </div>
                            <div class="card-body">
                                <div class="col">
                                    <div class="form-group">
                                        @foreach ($record as $r)
                                        <div class="note">
                                            <ul class="list-unstyled list-unstyled-border list-unstyled-noborder">
                                                <li class="media">
                                                    <div class="media-body" style="border: 1px solid #ddd; background-color: #f9f9f9; border-radius: 5px;">
                                                        <div class="media-title-note admin" >
                                                            <div class="media-right"><div class="text-time">{{ date('m/d/y g:i A', strtotime($r->created_at)) }}</div></div>
                                                            <div class="media-title mb-1">{{ ucwords(str_replace('_', ' ', $r->type)) }}</div>
{{--                                                            <div class="text-time"></div>--}}
                                                        </div>
                                                        <div class="media-description text-muted" style="padding: 15px;">
                                                            {!! $r->note !!}
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>

            </div>
        </form>
    </section>


    <script>

        function session_option(objButton){
            if(objButton.value == 1){
                $('#session_option_1').css('display', '')
                $('#session_option_2').css('display', 'none')
                $('#session_option_3').css('display', 'none')
            }else if(objButton.value == 2){
                $('#session_option_1').css('display', 'none')
                $('#session_option_2').css('display', '')
                $('#session_option_3').css('display', 'none')
            }else if(objButton.value == 3){
                $('#session_option_1').css('display', 'none')
                $('#session_option_2').css('display', 'none')
                $('#session_option_3').css('display', '')
            }
        }

        function package_order(treatment_id){
            if (confirm("Have you completed the package order?") == true) {
                $.ajax({
                    url: "<?php echo url('/admin/treatment/package_order'); ?>",
                    type: "POST",
                    datatype: "json",
                    data: {
                        _token : "{{ csrf_token() }}",
                        id : treatment_id
                    },
                    success: function(response) {
                        rs = JSON.parse(response);
                        if(response == 'Device token not found') {
                            alert(response);
                        }else if(response == 'Internal Server Error'){
                            alert(response);
                        }else if(rs.code == "messaging/registration-token-not-registered"){
                            alert(rs.message);
                        }else{
                            alert("System update completed.");
                            window.location.reload('/admin/treatments/'+treatment_id+'/edit');
                        }
                    },
                })
            }
        }

        function location_send(treatment_id){
            if (confirm("Are you sure to send Location Confirm Notification?") == true) {
                $.ajax({
                    url: "<?php echo url('/admin/treatment/location_send'); ?>",
                    type: "POST",
                    datatype: "json",
                    data: {
                        _token : "{{ csrf_token() }}",
                        id : treatment_id
                    },
                    success: function(response) {
                        rs = JSON.parse(response);
                        if(response == 'Device token not found') {
                            alert(response);
                        }else if(response == 'Internal Server Error'){
                            alert(response);
                        }else if(rs.code == "messaging/registration-token-not-registered"){
                            alert(rs.message);
                        }else{
                            alert("The notification has been successfully sent.");
                            window.location.reload('/admin/treatments/'+treatment_id+'/edit');
                        }
                    },
                })
            }
        }

        function package_ship(treatment_id){
            if (confirm("Have you successfully shipped the package?") == true) {
                $.ajax({
                    url: "<?php echo url('/admin/treatment/package_ship'); ?>",
                    type: "POST",
                    datatype: "json",
                    data: {
                        _token : "{{ csrf_token() }}",
                        id : treatment_id
                    },
                    success: function(response) {
                        if(response == 'success') {
                            alert("System update completed.");
                            window.location.reload('/admin/treatments/' + treatment_id + '/edit');
                        }else{
                            alert('Error!');
                        }
                    },
                })
            }
        }

        function package_delivery(treatment_id){
            if (confirm("Have you confirmed that the package has been delivered?") == true) {
                $.ajax({
                    url: "<?php echo url('/admin/treatment/package_delivery'); ?>",
                    type: "POST",
                    datatype: "json",
                    data: {
                        _token : "{{ csrf_token() }}",
                        id : treatment_id
                    },
                    success: function(response) {
                        rs = JSON.parse(response);
                        if(response == 'Device token not found') {
                            alert(response);
                        }else if(response == 'Internal Server Error'){
                            alert(response);
                        }else if(rs.code == "messaging/registration-token-not-registered"){
                            alert(rs.message);
                        }else{
                            alert("System update completed.");
                            window.location.reload('/admin/treatments/'+treatment_id+'/edit');
                        }
                    },
                })
            }
        }

        function visit_confirm(treatment_id){
            if (confirm("Are you sure to send Visit Confirm Notification?") == true) {
                $.ajax({
                    url: "<?php echo url('/admin/treatment/visit_confirm'); ?>",
                    type: "POST",
                    datatype: "json",
                    data: {
                        _token : "{{ csrf_token() }}",
                        id : treatment_id
                    },
                    success: function(response) {
                        rs = JSON.parse(response);
                        if(response == 'Device token not found') {
                            alert(response);
                        }else if(response == 'Internal Server Error'){
                            alert(response);
                        }else if(rs.code == "messaging/registration-token-not-registered"){
                            alert(rs.message);
                        }else{
                            alert("The notification has been successfully sent.");
                            window.location.reload('/admin/treatments/'+treatment_id+'/edit');
                        }
                    },
                })
            }
        }
    </script>

@endsection
