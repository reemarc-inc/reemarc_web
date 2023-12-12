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
                                            <b>Completed At:</b>
                                            {{ $appointment->updated_at }}
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <?php if($appointment->status == 'Upcoming'){ ?>
                            <button type="button"
                                    class="btn-sm followup-white-project-btn"
                                    data-toggle="modal"
                                    data-target="#follow-{{$appointment->id}}">Follow Up</button>
                            <?php } ?>

                        </div>
                    </div>
                </div>


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
