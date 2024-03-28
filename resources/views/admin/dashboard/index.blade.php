@extends('layouts.dashboard')

@section('content')

{{--    <section class="section">--}}
{{--        <div class="section-header">--}}
{{--            <h1>Dashboard</h1>--}}
{{--        </div>--}}

{{--        <div id='calendar'></div>--}}

{{--    </section>--}}


{{--    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js'></script>--}}

{{--    <script>--}}
{{--        document.addEventListener('DOMContentLoaded', function() {--}}
{{--            var calendarEl = document.getElementById('calendar');--}}
{{--            var calendar = new FullCalendar.Calendar(calendarEl, {--}}
{{--                initialView: 'dayGridMonth'--}}
{{--            });--}}
{{--            calendar.render();--}}
{{--        });--}}

{{--    </script>--}}

    <section class="section">
        <div class="section-header">
            <h1>Dashboard</h1>
        </div>
        <div class="section-title">
            <h3>{{ $clinic_name }}</h3>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <a href="{{ url('admin/patient_jira/')}}">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="far fa-user"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Follow Up</h4>
                            </div>
                            <div class="card-body">
                                {{ $num_follow_up }}
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <a href="{{ url('admin/patient_jira/')}}">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-danger">
                            <i class="far fa-newspaper"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Invisalign Order</h4>
                            </div>
                            <div class="card-body">
                                {{ $num_package_ready }}
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <a href="{{ url('admin/patient_jira/')}}">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="far fa-file"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Delivery Arrival Confirmation</h4>
                            </div>
                            <div class="card-body">
                                {{ $num_package_ordered }}
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <a href="{{ url('admin/patient_jira/')}}">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="fas fa-circle"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Visit Confirm</h4>
                            </div>
                            <div class="card-body">
                                {{ $num_visit_confirm }}
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
{{--        <div class="row">--}}
{{--            <div class="col-lg-8 col-md-12 col-12 col-sm-12">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header">--}}
{{--                        <h4>Statistics</h4>--}}
{{--                        <div class="card-header-action">--}}
{{--                            <div class="btn-group">--}}
{{--                                <a href="#" class="btn btn-primary">Week</a>--}}
{{--                                <a href="#" class="btn">Month</a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="card-body"><div class="chartjs-size-monitor" style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>--}}
{{--                        <canvas id="myChart" height="614" width="1013" style="display: block; width: 1013px; height: 614px;" class="chartjs-render-monitor"></canvas>--}}
{{--                        <div class="statistic-details mt-sm-4">--}}
{{--                            <div class="statistic-details-item">--}}
{{--                                <span class="text-muted"><span class="text-primary"><i class="fas fa-caret-up"></i></span> 7%</span>--}}
{{--                                <div class="detail-value">$243</div>--}}
{{--                                <div class="detail-name">Today's Sales</div>--}}
{{--                            </div>--}}
{{--                            <div class="statistic-details-item">--}}
{{--                                <span class="text-muted"><span class="text-danger"><i class="fas fa-caret-down"></i></span> 23%</span>--}}
{{--                                <div class="detail-value">$2,902</div>--}}
{{--                                <div class="detail-name">This Week's Sales</div>--}}
{{--                            </div>--}}
{{--                            <div class="statistic-details-item">--}}
{{--                                <span class="text-muted"><span class="text-primary"><i class="fas fa-caret-up"></i></span>9%</span>--}}
{{--                                <div class="detail-value">$12,821</div>--}}
{{--                                <div class="detail-name">This Month's Sales</div>--}}
{{--                            </div>--}}
{{--                            <div class="statistic-details-item">--}}
{{--                                <span class="text-muted"><span class="text-primary"><i class="fas fa-caret-up"></i></span> 19%</span>--}}
{{--                                <div class="detail-value">$92,142</div>--}}
{{--                                <div class="detail-name">This Year's Sales</div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col-lg-4 col-md-12 col-12 col-sm-12">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header">--}}
{{--                        <h4>Recent Activities</h4>--}}
{{--                    </div>--}}
{{--                    <div class="card-body">--}}
{{--                        <ul class="list-unstyled list-unstyled-border">--}}
{{--                            <li class="media">--}}
{{--                                <img class="mr-3 rounded-circle" width="50" src="/storage/assets/img/avatar/avatar-1.png" alt="avatar">--}}
{{--                                <div class="media-body">--}}
{{--                                    <div class="float-right text-primary">Now</div>--}}
{{--                                    <div class="media-title">Farhan A Mujib</div>--}}
{{--                                    <span class="text-small text-muted">Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin.</span>--}}
{{--                                </div>--}}
{{--                            </li>--}}
{{--                            <li class="media">--}}
{{--                                <img class="mr-3 rounded-circle" width="50" src="/storage/assets/img/avatar/avatar-2.png" alt="avatar">--}}
{{--                                <div class="media-body">--}}
{{--                                    <div class="float-right">12m</div>--}}
{{--                                    <div class="media-title">Ujang Maman</div>--}}
{{--                                    <span class="text-small text-muted">Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin.</span>--}}
{{--                                </div>--}}
{{--                            </li>--}}
{{--                            <li class="media">--}}
{{--                                <img class="mr-3 rounded-circle" width="50" src="/storage/assets/img/avatar/avatar-3.png" alt="avatar">--}}
{{--                                <div class="media-body">--}}
{{--                                    <div class="float-right">17m</div>--}}
{{--                                    <div class="media-title">Rizal Fakhri</div>--}}
{{--                                    <span class="text-small text-muted">Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin.</span>--}}
{{--                                </div>--}}
{{--                            </li>--}}
{{--                            <li class="media">--}}
{{--                                <img class="mr-3 rounded-circle" width="50" src="/storage/assets/img/avatar/avatar-4.png" alt="avatar">--}}
{{--                                <div class="media-body">--}}
{{--                                    <div class="float-right">21m</div>--}}
{{--                                    <div class="media-title">Alfa Zulkarnain</div>--}}
{{--                                    <span class="text-small text-muted">Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin.</span>--}}
{{--                                </div>--}}
{{--                            </li>--}}
{{--                        </ul>--}}
{{--                        <div class="text-center pt-1 pb-1">--}}
{{--                            <a href="#" class="btn btn-primary btn-lg btn-round">--}}
{{--                                View All--}}
{{--                            </a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <div class="row">--}}
{{--            <div class="col-lg-6 col-md-6 col-12">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header">--}}
{{--                        <h4 class="d-inline">Tasks</h4>--}}
{{--                    </div>--}}
{{--                    <div class="card-body">--}}
{{--                        <ul class="list-unstyled list-unstyled-border">--}}
{{--                            <li class="media">--}}
{{--                                <div class="custom-control custom-checkbox">--}}
{{--                                    <input type="checkbox" class="custom-control-input" id="cbx-1">--}}
{{--                                    <label class="custom-control-label" for="cbx-1"></label>--}}
{{--                                </div>--}}
{{--                                <img class="mr-3 rounded-circle" width="50" src="/storage/assets/img/avatar/avatar-4.png" alt="avatar">--}}
{{--                                <div class="media-body">--}}
{{--                                    <div class="badge badge-pill badge-danger mb-1 float-right">Not Finished</div>--}}
{{--                                    <h6 class="media-title"><a href="#">Redesign header</a></h6>--}}
{{--                                    <div class="text-small text-muted">Alfa Zulkarnain <div class="bullet"></div> <span class="text-primary">Now</span></div>--}}
{{--                                </div>--}}
{{--                            </li>--}}
{{--                            <li class="media">--}}
{{--                                <div class="custom-control custom-checkbox">--}}
{{--                                    <input type="checkbox" class="custom-control-input" id="cbx-2" checked="">--}}
{{--                                    <label class="custom-control-label" for="cbx-2"></label>--}}
{{--                                </div>--}}
{{--                                <img class="mr-3 rounded-circle" width="50" src="/storage/assets/img/avatar/avatar-5.png" alt="avatar">--}}
{{--                                <div class="media-body">--}}
{{--                                    <div class="badge badge-pill badge-primary mb-1 float-right">Completed</div>--}}
{{--                                    <h6 class="media-title"><a href="#">Add a new component</a></h6>--}}
{{--                                    <div class="text-small text-muted">Serj Tankian <div class="bullet"></div> 4 Min</div>--}}
{{--                                </div>--}}
{{--                            </li>--}}
{{--                            <li class="media">--}}
{{--                                <div class="custom-control custom-checkbox">--}}
{{--                                    <input type="checkbox" class="custom-control-input" id="cbx-3">--}}
{{--                                    <label class="custom-control-label" for="cbx-3"></label>--}}
{{--                                </div>--}}
{{--                                <img class="mr-3 rounded-circle" width="50" src="/storage/assets/img/avatar/avatar-2.png" alt="avatar">--}}
{{--                                <div class="media-body">--}}
{{--                                    <div class="badge badge-pill badge-warning mb-1 float-right">Progress</div>--}}
{{--                                    <h6 class="media-title"><a href="#">Fix modal window</a></h6>--}}
{{--                                    <div class="text-small text-muted">Ujang Maman <div class="bullet"></div> 8 Min</div>--}}
{{--                                </div>--}}
{{--                            </li>--}}
{{--                            <li class="media">--}}
{{--                                <div class="custom-control custom-checkbox">--}}
{{--                                    <input type="checkbox" class="custom-control-input" id="cbx-4">--}}
{{--                                    <label class="custom-control-label" for="cbx-4"></label>--}}
{{--                                </div>--}}
{{--                                <img class="mr-3 rounded-circle" width="50" src="/storage/assets/img/avatar/avatar-1.png" alt="avatar">--}}
{{--                                <div class="media-body">--}}
{{--                                    <div class="badge badge-pill badge-danger mb-1 float-right">Not Finished</div>--}}
{{--                                    <h6 class="media-title"><a href="#">Remove unwanted classes</a></h6>--}}
{{--                                    <div class="text-small text-muted">Farhan A Mujib <div class="bullet"></div> 21 Min</div>--}}
{{--                                </div>--}}
{{--                            </li>--}}
{{--                        </ul>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col-lg-6 col-md-6 col-12">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header">--}}
{{--                        <h4>Referral URL</h4>--}}
{{--                    </div>--}}
{{--                    <div class="card-body">--}}
{{--                        <div class="mb-4">--}}
{{--                            <div class="text-small float-right font-weight-bold text-muted">2,100</div>--}}
{{--                            <div class="font-weight-bold mb-1">Google</div>--}}
{{--                            <div class="progress" data-height="3" style="height: 3px;">--}}
{{--                                <div class="progress-bar" role="progressbar" data-width="80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%;"></div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="mb-4">--}}
{{--                            <div class="text-small float-right font-weight-bold text-muted">1,880</div>--}}
{{--                            <div class="font-weight-bold mb-1">Facebook</div>--}}
{{--                            <div class="progress" data-height="3" style="height: 3px;">--}}
{{--                                <div class="progress-bar" role="progressbar" data-width="67%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 67%;"></div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="mb-4">--}}
{{--                            <div class="text-small float-right font-weight-bold text-muted">1,521</div>--}}
{{--                            <div class="font-weight-bold mb-1">Bing</div>--}}
{{--                            <div class="progress" data-height="3" style="height: 3px;">--}}
{{--                                <div class="progress-bar" role="progressbar" data-width="58%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 58%;"></div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="mb-4">--}}
{{--                            <div class="text-small float-right font-weight-bold text-muted">884</div>--}}
{{--                            <div class="font-weight-bold mb-1">Yahoo</div>--}}
{{--                            <div class="progress" data-height="3" style="height: 3px;">--}}
{{--                                <div class="progress-bar" role="progressbar" data-width="36%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 36%;"></div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="mb-4">--}}
{{--                            <div class="text-small float-right font-weight-bold text-muted">473</div>--}}
{{--                            <div class="font-weight-bold mb-1">Kodinger</div>--}}
{{--                            <div class="progress" data-height="3" style="height: 3px;">--}}
{{--                                <div class="progress-bar" role="progressbar" data-width="28%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 28%;"></div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="mb-4">--}}
{{--                            <div class="text-small float-right font-weight-bold text-muted">418</div>--}}
{{--                            <div class="font-weight-bold mb-1">Multinity</div>--}}
{{--                            <div class="progress" data-height="3" style="height: 3px;">--}}
{{--                                <div class="progress-bar" role="progressbar" data-width="20%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 20%;"></div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
    </section>

@endsection
