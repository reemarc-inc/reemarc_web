@extends('layouts.dashboard')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>REEMARC Follow Up Page</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active">REEMARC Manager</div>
        </div>
    </div>
    <div class="section-body">

        @include('admin.appointment_follow_up.flash')
        @include('admin.appointment_follow_up._filter')

        <div class="row" style="margin-top: 15px;">

            @foreach ($appointments as $appointment)

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ $appointment->user_last_name }} {{ $appointment->user_first_name }}
                                <span class="float-right">
                                <a  href="javascript:void(0);"
                                    class="close"
                                    data-id=""
                                    data-campaign-id="{{ $appointment->id }}"
                                    onclick="delete_campaign($(this));">
                                <i class="fa fa-times"></i>
                                </a>
                            </span>
                            </h4>

                        </div>
                        <div class="card-body" style="display: flex;">
                            <div class="col-md-6" style="border-right:1px solid #eee; padding: 0px 0px 0px 0px;">
                                <div class="form-group">
                                    <div class="input-group info" style="display: block; ">
                                        <div>
                                            <b>Booked_date:</b>
                                            {{ $appointment->booked_date }}
                                        </div>
                                        <div>
                                            <b>Day:</b>
                                            # {{ $appointment->id }}
                                        </div>
                                        <div>
                                            <b>Time:</b>
                                            {{ $appointment->booked_time }}
                                        </div>
                                        <div>
                                            <b>Status:</b>
                                            {{ ucwords($appointment->status) }}
                                        </div>
                                    </div>
{{--                                    <div style="padding-top: 15px;">--}}
{{--                                        <a href="{{ url('admin/campaign/'. $appointment->id .'/edit') }}">--}}
{{--                                            <button type="button" class="btn-sm design-white-project-btn">Finish</button>--}}
{{--                                        </a>--}}
{{--                                        <a href="{{ url('admin/campaign/'. $appointment->id .'/edit')}}" class="btn btn-block btn-light">--}}
{{--                                            Open--}}
{{--                                        </a>--}}
{{--                                    </div>--}}
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
{{--        {{ $appointments->appends(['q' => !empty($filter['q']) ? $filter['q'] : ''])->links() }}--}}
    </div>
</section>

    <script>
        function delete_campaign(el) {
            if (confirm("Are you sure to DELETE this project?") == true) {
                let c_id = $(el).attr('data-campaign-id');
                $.ajax({
                    url: "<?php echo url('/admin/campaign/campaignRemove'); ?>"+"/"+c_id,
                    type: "GET",
                    datatype: "json",
                    success: function(response) {
                        if(response == 'success'){
                            $(el).parent().parent().parent().parent().parent().fadeOut( "slow", function() {
                                $(el).parent().parent().parent().parent().parent().remove();
                            });
                        }else{
                            alert(response);
                        }
                    },
                })
            }
        }
    </script>

@endsection
