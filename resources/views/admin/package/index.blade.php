@extends('layouts.dashboard')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Package Management</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item">package</div>
        </div>
    </div>

    <div class="section-body">

        @include('admin.package._filter')
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
                                    @forelse ($packages as $package)
                                    <tr>
                                        <td>{{ $package->name}}</td>
                                        <td>{{ $package->address}}</td>
                                        <td>{{ $package->region}}</td>
                                        <td>{{ $package->phone}}</td>
                                        <td>{{ $package->duration}}</td>
                                        <td>
                                            <a class="btn btn-sm" href="{{ url('admin/package/'. $package->id .'/edit')}}"><i class="far fa-edit"></i> @lang('general.btn_edit_label') </a>
                                            <a href="{{ url('admin/package/'. $package->id) }}" class="btn btn-sm" onclick="
                                                event.preventDefault();
                                                if (confirm('Do you want to remove this package?')) {
                                                document.getElementById('delete-role-{{ $package->id }}').submit();
                                                }">
                                                <i class="far fa-trash-alt"></i> Delete
                                            </a>
                                            <form id="delete-role-{{ $package->id }}" action="{{ url('admin/package/'. $package->id) }}" method="POST">
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
