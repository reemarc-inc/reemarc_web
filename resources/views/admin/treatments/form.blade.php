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
            <form method="POST" action="{{ route('treatments.store') }}">
        @else
            <form method="POST" action="{{ route('treatments.update', $treatment->id) }}">
                <input type="hidden" name="id" value="{{ $treatment->id }}" />
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
                                            <input type="text"
                                                   class="form-control"
                                                   value="{{ $clinic->name }}" disabled>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>Region</label>
                                            <input type="text"
                                                   class="form-control"
                                                   value="{{ $clinic->region }}" disabled>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label>Address</label>
                                            <input type="text"
                                                   class="form-control"
                                                   value="{{ $clinic->address }}" disabled>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label>Ship to Office</label>
                                            <textarea class="form-control" id="ship_to_office" name="ship_to_office" style="height: 50px;">{{ old('description', !empty($treatment) ? $treatment->ship_to_office : null) }}</textarea>
                                            @error('ship_to_office')
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

                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Treatment</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label>Package</label>
                                            <div class="selectgroup w-100">
                                                @foreach ($packages as $value)
                                                    <label class="selectgroup-item">
                                                        <input type="radio" name="package" value="{{ $value->id }}" class="selectgroup-input" {{ $value->id == $package ? 'checked=""' : '' }}>
                                                        <span class="selectgroup-button">{{ $value->name }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button class="btn btn-primary">{{ empty($treatment) ? __('general.btn_create_label') : __('general.btn_update_label') }}</button>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Notification</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label>Treatment Summary</label>
                                            <textarea class="form-control" id="ship_to_office" name="ship_to_office" style="height: 50px;">{{ old('description', !empty($treatment) ? $treatment->ship_to_office : null) }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <a href="#" class="btn btn-icon icon-left btn-primary"><i class="fa fa-paper-plane"> </i> Send Notification</a>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>

            </form>

    </section>
@endsection
