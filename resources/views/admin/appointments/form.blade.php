@extends('layouts.dashboard')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Appointment Management</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ url('admin/appointments') }}">appointments</a></div>
                <div class="breadcrumb-item">Edit appointments</div>
            </div>
        </div>

        @if (empty($appointments ?? '' ?? ''))
            <form method="POST" action="{{ route('appointments_list.store') }}">
        @else
            <form method="POST" action="{{ route('appointments_list.update', $appointments->id) }}">
                <input type="hidden" name="id" value="{{ $appointments->id }}" />
                @method('PUT')
        @endif
            @csrf
                <div class="section-body">
                    <h2 class="section-title">{{ empty($appointments) ? 'New appointments' : 'appointments Update' }}</h2>

                    <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ empty($appointments) ? 'Add New appointments' : 'Update appointments' }}</h4>
                        </div>

                        <div class="card-body">
                            @include('admin.shared.flash')

                            <div class="col">

                                <div class="form-group">
                                    <label>user_first_name</label>
                                    <input type="text" name="user_first_name"
                                           class="form-control @error('user_first_name') is-invalid @enderror @if (!$errors->has('user_first_name') && old('user_first_name')) is-valid @endif"
                                           value="{{ old('user_first_name', !empty($appointments) ? $appointments->user_first_name : null) }}">
                                    @error('user_first_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>user_last_name</label>
                                    <input type="text" name="user_last_name"
                                           class="form-control @error('user_last_name') is-invalid @enderror @if (!$errors->has('user_last_name') && old('user_last_name')) is-valid @endif"
                                           value="{{ old('user_last_name', !empty($appointments) ? $appointments->user_last_name : null) }}">
                                    @error('user_last_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>user_email</label>
                                    <input type="text" name="user_email"
                                           class="form-control @error('user_email') is-invalid @enderror @if (!$errors->has('user_email') && old('user_email')) is-valid @endif"
                                           value="{{ old('user_email', !empty($appointments) ? $appointments->user_email : null) }}">
                                    @error('user_email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>user_phone</label>
                                    <input type="text" name="user_phone"
                                           class="form-control @error('user_phone') is-invalid @enderror @if (!$errors->has('user_phone') && old('user_phone')) is-valid @endif"
                                           value="{{ old('user_phone', !empty($appointments) ? $appointments->user_phone : null) }}">
                                    @error('user_phone')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>clinic_name</label>
                                    <input type="text" name="clinic_name"
                                           class="form-control @error('clinic_name') is-invalid @enderror @if (!$errors->has('clinic_name') && old('clinic_name')) is-valid @endif"
                                           value="{{ old('clinic_name', !empty($appointments) ? $appointments->clinic_name : null) }}">
                                    @error('clinic_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>clinic_phone</label>
                                    <input type="text" name="clinic_phone"
                                           class="form-control @error('clinic_phone') is-invalid @enderror @if (!$errors->has('clinic_phone') && old('clinic_phone')) is-valid @endif"
                                           value="{{ old('clinic_phone', !empty($appointments) ? $appointments->clinic_phone : null) }}">
                                    @error('clinic_phone')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>clinic_address</label>
                                    <input type="text" name="clinic_address"
                                           class="form-control @error('clinic_address') is-invalid @enderror @if (!$errors->has('clinic_address') && old('clinic_address')) is-valid @endif"
                                           value="{{ old('clinic_address', !empty($appointments) ? $appointments->clinic_address : null) }}">
                                    @error('clinic_address')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>clinic_region</label>
                                    <input type="text" name="clinic_region"
                                           class="form-control @error('clinic_region') is-invalid @enderror @if (!$errors->has('clinic_region') && old('clinic_region')) is-valid @endif"
                                           value="{{ old('clinic_region', !empty($appointments) ? $appointments->clinic_region : null) }}">
                                    @error('clinic_region')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>booked_date</label>
                                    <input type="text" name="booked_date"
                                           class="form-control @error('booked_date') is-invalid @enderror @if (!$errors->has('booked_date') && old('booked_date')) is-valid @endif"
                                           value="{{ old('booked_date', !empty($appointments) ? $appointments->booked_date : null) }}">
                                    @error('booked_date')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>booked_day</label>
                                    <input type="text" name="booked_day"
                                           class="form-control @error('booked_day') is-invalid @enderror @if (!$errors->has('booked_day') && old('booked_day')) is-valid @endif"
                                           value="{{ old('booked_day', !empty($appointments) ? $appointments->booked_day : null) }}">
                                    @error('booked_day')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>booked_time</label>
                                    <input type="text" name="booked_time"
                                           class="form-control @error('booked_time') is-invalid @enderror @if (!$errors->has('booked_time') && old('booked_time')) is-valid @endif"
                                           value="{{ old('booked_time', !empty($appointments) ? $appointments->booked_time : null) }}">
                                    @error('booked_time')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

{{--                                <div class="form-group">--}}
{{--                                    <label>status</label>--}}
{{--                                    <input type="text" name="status"--}}
{{--                                           class="form-control @error('status') is-invalid @enderror @if (!$errors->has('status') && old('status')) is-valid @endif"--}}
{{--                                           value="{{ old('status', !empty($appointments) ? $appointments->status : null) }}">--}}
{{--                                    @error('status')--}}
{{--                                    <div class="invalid-feedback">--}}
{{--                                        {{ $message }}--}}
{{--                                    </div>--}}
{{--                                    @enderror--}}
{{--                                </div>--}}

                                <div class="form-group">
                                    <label>status</label>
                                        <select class="form-control" name="status">
                                            <option>Select Region</option>
                                            @foreach ($status_ as $value)
                                                <option value="{{ $value }}" {{ $value == $status ? 'selected' : '' }}>
                                                    {{ $value }}
                                                </option>
                                            @endforeach
                                        </select>
                                </div>

                            </div>

                        </div>

                        <div class="card-footer text-right">
                            <button
                                class="btn btn-primary">{{ empty($appointments) ? __('general.btn_create_label') : __('general.btn_update_label') }}</button>
                        </div>
                    </div>

                </div>
            </div>

                </div>

            </form>

    </section>
@endsection
