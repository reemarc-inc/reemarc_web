@extends('layouts.dashboard')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Treatments Management</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item">Treatments</div>
        </div>
    </div>

    <div class="section-body">

        @include('admin.treatments._filter')
        @include('admin.shared.flash')


        <div class="row" style="margin-top: 15px;">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-md">
                                <thead>
                                    <th>ID</th>
                                    <th>Appointment ID</th>
                                    <th>User ID</th>
                                    <th>Clinic ID</th>
                                    <th>Package ID</th>
                                    <th>Status</th>
                                    <th>Create At</th>
                                    <th width="15%">Action</th>
                                </thead>
                                <tbody>
                                    @forelse ($treatments as $treatment)
                                        <tr>
                                            <td>{{ $treatment->id}}</td>
                                            <td>{{ $treatment->appointment_id}}</td>
                                            <td>{{ $treatment->user_id }}</td>
                                            <td>{{ $treatment->clinic_id}}</td>
                                            <td>{{ $treatment->package_id}}</td>
                                            <td>{{ $treatment->status}}</td>
                                            <td>{{ $treatment->created_at}}</td>
                                            <td>
                                                <a class="btn btn-sm" href="{{ url('admin/treatments/'. $treatment->id .'/edit')}}"><i class="far fa-edit"></i> @lang('general.btn_edit_label') </a>
                                                <a href="{{ url('admin/treatments/'. $treatment->id) }}" class="btn btn-sm" onclick="
                                                    event.preventDefault();
                                                    if (confirm('Do you want to remove this treatments?')) {
                                                    document.getElementById('delete-role-{{ $treatment->id }}').submit();
                                                    }">
                                                    <i class="far fa-trash-alt"></i> Delete
                                                </a>
                                                <form id="delete-role-{{ $treatment->id }}" action="{{ url('admin/treatments/'. $treatment->id) }}" method="POST">
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
