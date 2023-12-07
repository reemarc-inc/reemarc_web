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
{{--        @include('admin.appointment_follow_up._filter')--}}

        <div class="row" style="margin-top: 15px;">

            @foreach ($appointments as $appointment)

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">

                            <li class="media">
                                <img class="mr-3 rounded-circle" width="50" src="/storage/image/default_profile.png" alt="avatar">
                                <div class="media-body">

                                        <?php if($appointment->status == 'Cancel'){ ?>
                                        <div class="badge badge-pill badge-danger mb-1 float-right">Canceled</div>
                                        <?php } else if($appointment->status == 'Upcoming') { ?>
                                        <div class="badge badge-pill badge-warning mb-1 float-right">Progress</div>
                                        <?php } else if($appointment->status == 'Complete') { ?>
                                        <div class="badge badge-pill badge-primary mb-1 float-right">Completed</div>
                                        <?php } ?>

                                    <h6 class="media-title">{{ $appointment->user_last_name }} {{ $appointment->user_first_name }}</h6>
                                    <div class="text-small text-muted">Patient <div class="bullet"></div> <span class="text-primary">Today</span></div>
                                </div>
                            </li>

                        </div>
                        <div class="card-body" style="display: flex; margin-bottom: -35px;">

                            <div class="col-md-6" style="padding: 0px 0px 0px 0px;">
                                <div class="form-group">
                                    <div class="input-group info" style="display: block; ">
                                        <div>
                                            <b>Clinic:</b>
                                            {{ $appointment->clinic_name }}
                                        </div>
                                        <div>
                                            <b>Region:</b>
                                            {{ $appointment->clinic_region }}
                                        </div>
                                        <div>
                                            <b>Appointment ID:</b>
                                            # {{ $appointment->id }}
                                        </div>
                                        <div>
                                            <b>Status:</b>
                                            {{ ucwords($appointment->status) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6" style="padding: 0px 0px 0px 0px;">
                                <div class="form-group">
                                    <div class="input-group info" style="display: block; ">
                                        <div>
                                            <b>Booked Date:</b>
                                            {{ $appointment->booked_date }}
                                        </div>
                                        <div>
                                            <b>Booked Time:</b>
                                            {{ $appointment->booked_time }}
                                        </div>
                                        <div>
                                            <b>Booked Day:</b>
                                            {{ $appointment->booked_day }}
                                        </div>
                                        <div>
                                            <?php if($appointment->status == 'Complete'){ ?>
                                            <b>Completed Date:</b>
                                            {{ $appointment->updated_at }}
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <?php if($appointment->status != 'Complete'){ ?>
                            <button type="button" class="btn-sm followup-white-project-btn">Follow Up</button>
                            <?php } ?>
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
