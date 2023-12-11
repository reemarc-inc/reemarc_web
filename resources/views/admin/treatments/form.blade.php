@extends('layouts.dashboard')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Treatment Management</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ url('admin/treatments') }}">Treatments</a></div>
                <div class="breadcrumb-item">Edit treatments</div>
            </div>
        </div>

        @if (empty($treatment ?? '' ?? ''))
            <form method="POST" action="{{ route('treatments_list.store') }}">
        @else
            <form method="POST" action="{{ route('treatments_list.update', $treatment->id) }}">
                <input type="hidden" name="id" value="{{ $treatment->id }}" />
                @method('PUT')
        @endif
            @csrf
                <div class="section-body">
                    <h2 class="section-title">{{ empty($treatment) ? 'New treatments' : 'treatments Update' }}</h2>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Patient</h4>
                                </div>
                                <div class="card-body">
                                    @include('admin.shared.flash')
                                    <div class="row">
                                        <div class="form-group col-md-6" >
                                            <label>First Name</label>
                                            <input type="text" name="user_first_name"
                                               class="form-control @error('user_first_name') is-invalid @enderror @if (!$errors->has('user_first_name') && old('user_first_name')) is-valid @endif"
                                               value="{{ old('user_first_name', !empty($user) ? $user->first_name : null) }}">
                                            @error('user_first_name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Last Name</label>
                                                <input type="text" name="user_last_name"
                                                   class="form-control @error('user_last_name') is-invalid @enderror @if (!$errors->has('user_last_name') && old('user_last_name')) is-valid @endif"
                                                   value="{{ old('user_last_name', !empty($user) ? $user->last_name : null) }}">
                                            @error('user_last_name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>Gender</label>
                                            <div class="selectgroup w-100">
                                                @foreach ($genders_ as $key => $value)
                                                    <label class="selectgroup-item">
                                                        <input type="radio" name="user_gender" value="{{ $value }}" class="selectgroup-input" {{ $value == $gender ? 'checked=""' : '' }}>
                                                        <span class="selectgroup-button">{{ $key }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>Year of Birth</label>
                                            <input type="text" name="user_yob"
                                                   class="form-control @error('user_yob') is-invalid @enderror @if (!$errors->has('user_yob') && old('user_yob')) is-valid @endif"
                                                   value="{{ old('user_yob', !empty($user) ? $user->yob : null) }}">
                                            @error('user_last_name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>Email</label>
                                            <input type="text" name="user_email"
                                                   class="form-control @error('user_email') is-invalid @enderror @if (!$errors->has('user_email') && old('user_email')) is-valid @endif"
                                                   value="{{ old('user_email', !empty($user) ? $user->email : null) }}">
                                            @error('user_email')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Clinic</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label>Name</label>
                                            <input type="text" name="clinic_name"
                                                   class="form-control @error('clinic_name') is-invalid @enderror @if (!$errors->has('clinic_name') && old('clinic_name')) is-valid @endif"
                                                   value="{{ old('clinic_name', !empty($treatment) ? $treatment->clinic_name : null) }}">
                                            @error('clinic_name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>Phone</label>
                                            <input type="text" name="clinic_phone"
                                                   class="form-control @error('clinic_phone') is-invalid @enderror @if (!$errors->has('clinic_phone') && old('clinic_phone')) is-valid @endif"
                                                   value="{{ old('clinic_phone', !empty($treatment) ? $treatment->clinic_phone : null) }}">
                                            @error('clinic_phone')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>Ship to Office</label>
                                            <input type="text" name="user_last_name"
                                                   class="form-control @error('user_last_name') is-invalid @enderror @if (!$errors->has('user_last_name') && old('user_last_name')) is-valid @endif"
                                                   value="{{ old('user_last_name', !empty($user) ? $user->last_name : null) }}">
                                            @error('user_last_name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>Address</label>
                                            <input type="text" name="clinic_address"
                                                   class="form-control @error('clinic_address') is-invalid @enderror @if (!$errors->has('clinic_address') && old('clinic_address')) is-valid @endif"
                                                   value="{{ old('clinic_address', !empty($treatment) ? $treatment->clinic_address : null) }}">
                                            @error('clinic_address')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>Region</label>
                                            <input type="text" name="clinic_region"
                                                   class="form-control @error('clinic_region') is-invalid @enderror @if (!$errors->has('clinic_region') && old('clinic_region')) is-valid @endif"
                                                   value="{{ old('clinic_region', !empty($treatment) ? $treatment->clinic_region : null) }}">
                                            @error('clinic_region')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

{{--                                <div class="card-footer text-right">--}}
{{--                                    <button--}}
{{--                                        class="btn btn-primary">{{ empty($treatment) ? __('general.btn_create_label') : __('general.btn_update_label') }}</button>--}}
{{--                                </div>--}}
                            </div>

                        </div>

                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Treatment</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">

                                        <div class="form-group col-md-6">
                                            <label>booked_date</label>
                                            <input type="text" name="booked_date"
                                                   class="form-control @error('booked_date') is-invalid @enderror @if (!$errors->has('booked_date') && old('booked_date')) is-valid @endif"
                                                   value="{{ old('booked_date', !empty($treatment) ? $treatment->booked_date : null) }}">
                                            @error('booked_date')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>booked_day</label>
                                            <input type="text" name="booked_day"
                                                   class="form-control @error('booked_day') is-invalid @enderror @if (!$errors->has('booked_day') && old('booked_day')) is-valid @endif"
                                                   value="{{ old('booked_day', !empty($treatment) ? $treatment->booked_day : null) }}">
                                            @error('booked_day')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>booked_time</label>
                                            <input type="text" name="booked_time"
                                                   class="form-control @error('booked_time') is-invalid @enderror @if (!$errors->has('booked_time') && old('booked_time')) is-valid @endif"
                                                   value="{{ old('booked_time', !empty($treatment) ? $treatment->booked_time : null) }}">
                                            @error('booked_time')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>status</label>
                                            <input type="text" name="status"
                                                   class="form-control @error('status') is-invalid @enderror @if (!$errors->has('status') && old('status')) is-valid @endif"
                                                   value="{{ old('status', !empty($treatment) ? $treatment->status : null) }}">
                                            @error('status')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>


                                    </div>

                                </div>

                                <div class="card-footer text-right">
                                    <button
                                        class="btn btn-primary">{{ empty($treatment) ? __('general.btn_create_label') : __('general.btn_update_label') }}</button>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

            </form>

    </section>
@endsection
