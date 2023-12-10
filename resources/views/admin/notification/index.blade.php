@extends('layouts.dashboard')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Notification Management</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item">Notification</div>
        </div>
    </div>

    <div class="section-body">

        @include('admin.notification._filter')
        @include('admin.shared.flash')


        <div class="row" style="margin-top: 15px;">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-md">
                                <thead>
                                    <th>ID</th>
                                    <th>User ID</th>
                                    <th>User Email</th>
                                    <th>Type</th>
                                    <th>Created At</th>
                                    <th>Delete</th>
                                    <th width="15%">Action</th>
                                </thead>
                                <tbody>
                                    @forelse ($notifications as $notification)
                                        <tr>
                                            <td>{{ $notification->id}}</td>
                                            <td>{{ $notification->user_id}}</td>
                                            <td>{{ $notification->user_email}}</td>
                                            <td>{{ $notification->type}}</td>
                                            <td>{{ $notification->created_at}}</td>
                                            <td>{{ $notification->is_read}}</td>
                                            <td>{{ $notification->is_delete}}</td>
                                            <td>
                                                <a class="btn btn-sm" href="{{ url('admin/notification/'. $notification->id .'/edit')}}"><i class="far fa-edit"></i> @lang('general.btn_edit_label') </a>
                                                <a href="{{ url('admin/notification/'. $notification->id) }}" class="btn btn-sm" onclick="
                                                    event.preventDefault();
                                                    if (confirm('Do you want to remove this notification?')) {
                                                    document.getElementById('delete-role-{{ $notification->id }}').submit();
                                                    }">
                                                    <i class="far fa-trash-alt"></i> Delete
                                                </a>
                                                <form id="delete-role-{{ $notification->id }}" action="{{ url('admin/notification/'. $notification->id) }}" method="POST">
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
