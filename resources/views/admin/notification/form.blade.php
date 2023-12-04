@extends('layouts.dashboard')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Notification Management</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ url('admin/notification') }}">Notification</a></div>
                <div class="breadcrumb-item">Edit Notification</div>
            </div>
        </div>

        @if (empty($notification ?? '' ?? ''))
            <form method="POST" action="{{ route('notification.store') }}" enctype="multipart/form-data">
        @else
            <form method="POST" action="{{ route('notification.update', $notification->id) }}" enctype="multipart/form-data">
                <input type="hidden" name="id" value="{{ $notification->id }}" />
                @method('PUT')
        @endif
            @csrf
                <div class="section-body">
                    <h2 class="section-title">{{ empty($notification) ? 'New Notification' : 'notification Update' }}</h2>

                    <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ empty($notification) ? 'Add New Notification' : 'Update notification' }}</h4>
                        </div>

                        <div class="card-body">
                            @include('admin.shared.flash')

                            <div class="col">
                                <div class="form-group">
                                    <label>User ID</label>
                                    <input type="text" name="user_id"
                                           class="form-control @error('user_id') is-invalid @enderror @if (!$errors->has('user_id') && old('user_id')) is-valid @endif"
                                           value="{{ old('user_id', !empty($notification) ? $notification->user_id : null) }}">
                                    @error('user_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>User Email</label>
                                    <input type="text" name="user_email"
                                           class="form-control @error('user_email') is-invalid @enderror @if (!$errors->has('user_email') && old('user_email')) is-valid @endif"
                                           value="{{ old('user_email', !empty($notification) ? $notification->user_email : null) }}">
                                    @error('user_email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Appointment ID</label>
                                    <input type="text" name="appointment_id"
                                           class="form-control @error('appointment_id') is-invalid @enderror @if (!$errors->has('appointment_id') && old('appointment_id')) is-valid @endif"
                                           value="{{ old('appointment_id', !empty($notification) ? $notification->appointment_id : null) }}">
                                    @error('appointment_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Treatment ID</label>
                                    <input type="text" name="treatment_id"
                                           class="form-control @error('treatment_id') is-invalid @enderror @if (!$errors->has('treatment_id') && old('treatment_id')) is-valid @endif"
                                           value="{{ old('treatment_id', !empty($notification) ? $notification->treatment_id : null) }}">
                                    @error('treatment_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Type</label>
                                    <input type="text" name="type"
                                           class="form-control @error('type') is-invalid @enderror @if (!$errors->has('type') && old('type')) is-valid @endif"
                                           value="{{ old('type', !empty($notification) ? $notification->type : null) }}">
                                    @error('type')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Note</label>
                                    <textarea class="form-control" id="description" name="description" style="height: 100px;">{{ old('note', !empty($notification) ? $notification->note : null) }}</textarea>
{{--                                    <input type="text" name="description"--}}
{{--                                           class="form-control @error('description') is-invalid @enderror @if (!$errors->has('description') && old('description')) is-valid @endif"--}}
{{--                                           value="{{ old('description', !empty($notification) ? $notification->description : null) }}">--}}
                                    @error('note')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                            </div>

                        </div>

                        <div class="card-footer text-right">
                            <button
                                class="btn btn-primary">{{ empty($notification) ? __('general.btn_create_label') : __('general.btn_update_label') }}</button>
                        </div>
                    </div>

                </div>
            </div>

                </div>

            </form>

    </section>

@endsection
