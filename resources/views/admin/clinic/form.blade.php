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
            <form method="POST" action="{{ route('clinic.store') }}" enctype="multipart/form-data">
        @else
            <form method="POST" action="{{ route('clinic.update', $clinic->id) }}" enctype="multipart/form-data">
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
                                    <label>Name_KR</label>
                                    <input type="text" name="name_kr"
                                           class="form-control @error('name_kr') is-invalid @enderror @if (!$errors->has('name_kr') && old('name_kr')) is-valid @endif"
                                           value="{{ old('name_kr', !empty($clinic) ? $clinic->name_kr : null) }}">
                                    @error('name_kr')
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
                                    <label>Address_KR</label>
                                    <input type="text" name="address_kr"
                                           class="form-control @error('address_kr') is-invalid @enderror @if (!$errors->has('address_kr') && old('address_kr')) is-valid @endif"
                                           value="{{ old('address_kr', !empty($clinic) ? $clinic->address_kr : null) }}">
                                    @error('address_kr')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control" id="description" name="description" style="height: 100px;">{{ old('description', !empty($clinic) ? $clinic->description : null) }}</textarea>
                                    @error('description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Description_KR</label>
                                    <textarea class="form-control" id="description_kr" name="description_kr" style="height: 100px;">{{ old('description_kr', !empty($clinic) ? $clinic->description_kr : null) }}</textarea>
                                    @error('description_kr')
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
                                    <label>Country Code</label>
                                    <input type="text" name="country_code"
                                           class="form-control @error('country_code') is-invalid @enderror @if (!$errors->has('country_code') && old('country_code')) is-valid @endif"
                                           value="{{ old('country_code', !empty($clinic) ? $clinic->country_code : null) }}">
                                    @error('country_code')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Time Zone</label>
                                    <input type="text" name="time_zone"
                                           class="form-control @error('time_zone') is-invalid @enderror @if (!$errors->has('time_zone') && old('time_zone')) is-valid @endif"
                                           value="{{ old('time_zone', !empty($clinic) ? $clinic->time_zone : null) }}">
                                    @error('time_zone')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Phone</label>
                                    <input type="text" name="phone"
                                           class="form-control @error('phone') is-invalid @enderror @if (!$errors->has('phone') && old('phone')) is-valid @endif"
                                           value="{{ old('phone', !empty($clinic) ? $clinic->phone : null) }}">
                                    @error('phone')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Web URL</label>
                                    <input type="text" name="web_url"
                                           class="form-control @error('web_url') is-invalid @enderror @if (!$errors->has('web_url') && old('web_url')) is-valid @endif"
                                           value="{{ old('web_url', !empty($clinic) ? $clinic->web_url : null) }}">
                                    @error('web_url')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Booking Start: </label>
                                    <input type="text" name="booking_start" id="booking_start" placeholder="Booking Start"
                                           class="form-control datetimepicker @error('booking_start') is-invalid @enderror @if (!$errors->has('booking_start') && old('booking_start')) is-valid @endif"
                                           value="{{ old('booking_start', !empty($clinic) ? $clinic->booking_start : null) }}">
                                    @error('booking_start')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Booking End: </label>
                                    <input type="text" name="booking_end" id="booking_end" placeholder="Booking End"
                                           class="form-control datetimepicker @error('booking_end') is-invalid @enderror @if (!$errors->has('booking_end') && old('booking_end')) is-valid @endif"
                                           value="{{ old('booking_end', !empty($clinic) ? $clinic->booking_end : null) }}">
                                    @error('booking_end')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Dentist Name</label>
                                    <input type="text" name="dentist_name"
                                           class="form-control @error('dentist_name') is-invalid @enderror @if (!$errors->has('dentist_name') && old('dentist_name')) is-valid @endif"
                                           value="{{ old('dentist_name', !empty($clinic) ? $clinic->dentist_name : null) }}">
                                    @error('dentist_name')
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

                                <div class="form-group">
                                    <label>Disabled Days</label>
                                    <div class="row">

                                        @foreach($disabled_days_ as $key => $disabled_day)
                                        <?php $checkbox_fields = explode(',', $disabled_days); ?>
                                            <div class="col-sm-6">
                                                <div class="form-check">
                                                    <input  <?php if (in_array($disabled_day, $checkbox_fields)) echo "checked" ?>
                                                            type="checkbox"
                                                            name="disabled_days[]"
                                                            value="{{ $disabled_day }}"
                                                    >
                                                    <label class="form-check-label " for="{{ $key }}">
                                                        {{ $key }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>

                                <?php if (!empty($attach_files)): ?>
                                <label>Attachments: </label>
                                <br/>
                                <?php foreach ($attach_files as $attachment): ?>
                                <?php
                                $file_ext = $attachment['file_ext'];
                                if(strpos($file_ext, ".") !== false){
                                    $file_ext = substr($file_ext, 1);
                                }
                                $not_image = ['pdf','doc','docx','pptx','ppt','mp4','xls','xlsx','csv','zip'];
                                $file_icon = '/storage/'.$file_ext.'.png';
                                $attachment_link = '/storage' . $attachment['attachment'];
                                $open_link = 'open_download';
                                ?>
                                <div class="attachment_wrapper">
                                    <?php $name = explode('/', $attachment['attachment']); ?>
                                    <?php $name = $name[count($name)-1]; ?>
                                    <?php $date = date('m/d/Y g:ia', strtotime($attachment['date_created'])); ?>
                                    <div class="attachement">{{ $name }}</div>
                                    <a onclick="remove_file($(this))"
                                       class="delete attachement close"
                                       title="Delete"
                                       data-file-name="<?php echo $name; ?>"
                                       data-attachment-id="<?php echo $attachment['attachment_id']; ?>">
                                        <i class="fa fa-times"></i>
                                    </a>
                                    <img title="<?php echo $name . ' (' . date('m/d/Y g:ia', strtotime($date)) . ')'; ?>"
                                         data-file-date="<?php echo $date; ?>"
                                         <?php
                                         if (!in_array($file_ext, $not_image)) {
                                         $file_icon = $attachment_link;
                                         $open_link = 'open_image';
                                         ?>
                                         data-toggle="modal"
                                         data-target="#exampleModal_<?php echo $attachment['attachment_id']; ?>"
                                         <?php
                                         }
                                         ?>
                                         onclick="<?php echo $open_link; ?>('<?php echo $attachment_link; ?>')"
                                         src="<?php echo $file_icon; ?>"
                                         class="thumbnail"/>
                                </div>
                                <?php endforeach; ?>
                                <?php endif; ?>

                                <div class="form-group">
                                    <label>Upload Visual References: <b style="color: #b91d19">(20MB Max)</b></label>
                                    <input type="file" id="c_attachment[]" name="c_attachment[]"
                                           data-asset="default" multiple="multiple"
                                           class="form-control c_attachment last_upload @error('c_attachment') is-invalid @enderror @if (!$errors->has('c_attachment') && old('c_attachment')) is-valid @endif"
                                           value="{{ old('c_attachment', !empty($clinic) ? $clinic->secondary_message : null) }}">
                                    <a href="javascript:void(0);" onclick="another_upload($(this))" class="another_upload">[ Upload Another ]</a>
                                    @error('c_attachment')
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

    <script>
        function another_upload(el) {
            upload_box = $('.c_attachment').prop('outerHTML');
            upload_name = $(el).prev().attr('name');
            upload_id = $(el).prev().attr('data-asset');
            $('.c_attachment').removeClass('last_upload');
            $(el).before(upload_box);
            $(el).prev().attr('name', upload_name);
        }

        function remove_file(el) {
            if (confirm("Are you sure to Delete File?") == true) {
                let id = $(el).attr('data-attachment-id');
                $.ajax({
                    url: "<?php echo url('/admin/clinic/fileRemove'); ?>"+"/"+id,
                    type: "GET",
                    datatype: "json",
                    success: function(response) {
                        if(response == 'success'){
                            $(el).parent().remove();
                        }else{
                            alert(response);
                        }
                    },
                })
            }
        }
    </script>

@endsection
