@extends('layouts.dashboard')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Appointments Management</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item">Appointments</div>
        </div>
    </div>

    <div class="section-body">

        @include('admin.appointments._filter')
        @include('admin.shared.flash')


        <div class="row" style="margin-top: 15px;">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-md">
                                <thead>
                                    <th>ID</th>
                                    <th>User Name</th>
                                    <th>Email</th>
                                    <th>Region</th>
                                    <th>Clinic Name</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Status</th>
                                    <th>Create At</th>
                                    <th width="15%">Action</th>
                                </thead>
                                <tbody>
                                    @forelse ($appointments as $appointment)
                                        <tr>
                                            <td>{{ $appointment->id}}</td>
                                            <td>{{ $appointment->user_first_name}}</td>
                                            <td>{{ $appointment->user_email }}</td>
                                            <td>{{ $appointment->clinic_region}}</td>
                                            <td>{{ $appointment->clinic_name}}</td>
                                            <td>{{ date('Y-m-d g:i a', strtotime($appointment->booked_start))}}</td>
                                            <td>{{ date('Y-m-d g:i a', strtotime($appointment->booked_end))}}</td>
                                            <td>{{ $appointment->status}}</td>
                                            <td>{{ $appointment->created_at}}</td>
                                            <td>
                                                <a class="btn btn-sm" href="{{ url('admin/appointments_list/'. $appointment->id .'/edit')}}"><i class="far fa-edit"></i> @lang('general.btn_edit_label') </a>
                                                <a href="{{ url('admin/appointments_list/'. $appointment->id) }}" class="btn btn-sm" onclick="
                                                    event.preventDefault();
                                                    if (confirm('Do you want to remove this appointments?')) {
                                                    document.getElementById('delete-role-{{ $appointment->id }}').submit();
                                                    }">
                                                    <i class="far fa-trash-alt"></i> Delete
                                                </a>
                                                <form id="delete-role-{{ $appointment->id }}" action="{{ url('admin/appointments_list/'. $appointment->id) }}" method="POST">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    @csrf
                                                </form>
                                            </td>
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
