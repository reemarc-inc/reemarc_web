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
                                    <th>Region</th>
                                    <th>Tel</th>
                                    <th>Duration</th>
                                    <th width="15%">Action</th>
                                </thead>
                                <tbody>
                                    @forelse ($clinics as $clinic)
                                        <tr>
                                            <td>{{ $clinic->name}}</td>
                                            <td>{{ $clinic->address}}</td>
                                            <td>{{ $clinic->region}}</td>
                                            <td>{{ $clinic->tel}}</td>
                                            <td>{{ $clinic->duration}}</td>
                                            <td>
                                                <a class="btn btn-sm" href="{{ url('admin/clinic/'. $clinic->id .'/edit')}}"><i class="far fa-edit"></i> @lang('general.btn_edit_label') </a>
                                                <a href="{{ url('admin/clinic/'. $clinic->id) }}" class="btn btn-sm" onclick="
                                                    event.preventDefault();
                                                    if (confirm('Do you want to remove this Clinic?')) {
                                                    document.getElementById('delete-role-{{ $clinic->id }}').submit();
                                                    }">
                                                    <i class="far fa-trash-alt"></i> Delete
                                                </a>
                                                <form id="delete-role-{{ $clinic->id }}" action="{{ url('admin/clinic/'. $clinic->id) }}" method="POST">
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
