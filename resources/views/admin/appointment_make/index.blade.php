@extends('layouts.dashboard')

@section('content')

    <link href="https://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="Stylesheet">
    <script src="https://code.jquery.com/ui/1.10.2/jquery-ui.js" ></script>
    <script src="https://code.jquery.com/jquery-migrate-3.0.0.min.js"></script>


<section class="section">
    <div class="section-header">
        <h1>Clinic List</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active">Appointments</div>
        </div>
    </div>
    <div class="section-body">


        @include('admin.appointment_make.flash')
{{--        @include('admin.appointment_make._filter')--}}

        <div class="row" style="margin-top: 15px;">

            @foreach ($clinics as $clinic)

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>
                                {{ $clinic->name }}
                            </h4>

                        </div>
                        <div class="card-body" style="display: flex;">
                            <div class="col-md-6" style="border-right:1px solid #eee; padding: 0px 0px 0px 0px;">
                                <div class="form-group">
                                    <div class="input-group info" style="display: block; ">
                                        <div>
                                            <b>Region:</b>
                                            {{ $clinic->region }}
                                        </div>
                                        <div>
                                            <b>Address:</b>
                                            # {{ $clinic->address }}
                                        </div>
                                        <div>
                                            <b>Phone:</b>
                                            {{ $clinic->tel }}
                                        </div>
                                    </div>
                                    <div style="padding-top: 15px;">
                                        <button type="button"
                                                class="btn-sm design-white-project-btn"
                                                data-toggle="modal"
                                                data-target="#book-{{$clinic->id}}">Book Online</button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 asset_scroll">

                                <div class="row" style="font-size: 12px;">
                                    <div class="col-sm-12" style="padding: 0px 0px 0px 2px;">
                                        <div style="margin-top:0px;">
                                            <b>Description:</b>
                                        </div>
                                        <div>
                                            {{ $clinic->description }}
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>


                <div id="book-{{$clinic->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="bookModalLabel" aria-hidden="true" data-backdrop="false">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <form method="POST" action="{{ route('asset.asset_owner_change') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-header">
                                    <h4 class="modal-title" id="myModalLabel">{{ ucwords(str_replace('_', ' ', $clinic->name)) }}</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                </div>
                                <div class="modal-body">
                                    {{-- available - light (Gray) / not available - dark (black) --}}
                                    @foreach ($next_week_dates as $date)
                                        <h5 class="modal-title">{{ $date }}</h5>
                                        <div class="form-group">
                                            @foreach($time_spots as $spot)
                                                <button type="button" class="btn btn-light">{{ $spot }}</button>
                                            @endforeach
                                        </div>
                                    @endforeach

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


            @endforeach
        </div>

{{--        {{ $clinic->appends(['q' => !empty($filter['q']) ? $filter['q'] : ''])->links() }}--}}


    </div>


</section>



@endsection

