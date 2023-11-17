@extends('layouts.dashboard')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Clinic Management</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ url('admin/clinic') }}">Clinic</a></div>
                <div class="breadcrumb-item">Edit Clinic</div>
            </div>
        </div>

        @if (empty($clinic ?? '' ?? ''))
            <form method="POST" action="{{ route('clinic.store') }}">
        @else
            <form method="POST" action="{{ route('clinic.update', $clinic->id) }}">
                <input type="hidden" name="id" value="{{ $clinic->id }}" />
                @method('PUT')
        @endif
        @csrf
        <div class="section-body">
            <h2 class="section-title">{{ empty($clinic) ? 'New Clinic' : 'Clinic Update' }}</h2>

            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ empty($clinic) ? 'Add New Clinic' : 'Update Clinic' }}</h4>
                        </div>

                        <div class="card-body">
                            @include('admin.shared.flash')

                            <div class="col">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" name="name"
                                           class="form-control @error('name') is-invalid @enderror @if (!$errors->has('name') && old('name')) is-valid @endif"
                                           value="{{ old('name', !empty($clinic) ? $clinic->name : null) }}">
                                    @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Address</label>
                                    <input type="text" name="address"
                                           class="form-control @error('address') is-invalid @enderror @if (!$errors->has('address') && old('address')) is-valid @endif"
                                           value="{{ old('address', !empty($clinic) ? $clinic->address : null) }}">
                                    @error('address')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control" id="description" name="description" style="height: 100px;">{{ old('description', !empty($clinic) ? $clinic->description : null) }}</textarea>
{{--                                    <input type="text" name="description"--}}
{{--                                           class="form-control @error('description') is-invalid @enderror @if (!$errors->has('description') && old('description')) is-valid @endif"--}}
{{--                                           value="{{ old('description', !empty($clinic) ? $clinic->description : null) }}">--}}
                                    @error('description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Latitude</label>
                                    <input type="text" name="latitude"
                                           class="form-control @error('latitude') is-invalid @enderror @if (!$errors->has('latitude') && old('latitude')) is-valid @endif"
                                           value="{{ old('latitude', !empty($clinic) ? $clinic->latitude : null) }}">
                                    @error('latitude')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Longitude</label>
                                    <input type="text" name="longitude"
                                           class="form-control @error('longitude') is-invalid @enderror @if (!$errors->has('longitude') && old('longitude')) is-valid @endif"
                                           value="{{ old('longitude', !empty($clinic) ? $clinic->longitude : null) }}">
                                    @error('longitude')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Region</label>
                                    <select class="form-control" name="region">
                                        <option>Select Region</option>
                                        @foreach ($region_ as $value)
                                            <option value="{{ $value }}" {{ $value == $region ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Tel</label>
                                    <input type="text" name="tel"
                                           class="form-control @error('tel') is-invalid @enderror @if (!$errors->has('tel') && old('tel')) is-valid @endif"
                                           value="{{ old('tel', !empty($clinic) ? $clinic->tel : null) }}">
                                    @error('tel')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Duration</label>
                                    <input type="text" name="duration"
                                           class="form-control @error('duration') is-invalid @enderror @if (!$errors->has('duration') && old('duration')) is-valid @endif"
                                           value="{{ old('duration', !empty($clinic) ? $clinic->duration : null) }}">
                                    @error('duration')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <div class="card-footer text-right">
                            <button
                                class="btn btn-primary">{{ empty($clinic) ? __('general.btn_create_label') : __('general.btn_update_label') }}</button>
                        </div>
                    </div>

                </div>


            </div>
        </div>
        </form>
    </section>
@endsection
