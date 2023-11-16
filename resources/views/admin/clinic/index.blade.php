@extends('layouts.dashboard')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Clinic Management</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item">Clinic</div>
        </div>
    </div>

    <div class="section-body">

        @include('admin.clinic._filter')
        @include('admin.shared.flash')


        <div class="row" style="margin-top: 15px;">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-md">
                                <thead>
                                    <th>Name</th>
                                    <th>Address</th>
                                    <th>Description</th>
                                    <th>Latitude</th>
                                    <th>Longitude</th>
                                    <th>Region</th>
                                    <th>Tel</th>
                                    <th>Duration</th>
                                </thead>
                                <tbody>
                                    @forelse ($clinics as $clinic)
                                        <tr>
                                            <td>{{ $clinic->name}}</td>
                                            <td>{{ $clinic->address}}</td>
                                            <td>{{ $clinic->description}}</td>
                                            <td>{{ $clinic->latitude}}</td>
                                            <td>{{ $clinic->longitude}}</td>
                                            <td>{{ $clinic->region}}</td>
                                            <td>{{ $clinic->tel}}</td>
                                            <td>{{ $clinic->duration}}</td>
                                        </tr>
                                    @empty

                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
