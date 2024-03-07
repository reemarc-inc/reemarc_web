@extends('layouts.dashboard')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>@lang('users.user_management')</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ url('admin/users') }}">Users</a></div>
                <div class="breadcrumb-item">Edit User</div>
            </div>
        </div>
        @if (empty($user ?? '' ?? ''))
            <form method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data">
            @else
                <form method="POST" action="{{ route('users.update', $user->id) }}" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="{{ $user->id }}" />
                    @method('PUT')
        @endif
        @csrf
        <div class="section-body">
            <h2 class="section-title">{{ empty($user) ? __('users.user_add_new') : __('users.user_update') }}</h2>

            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ empty($user) ? __('users.add_card_title') : __('users.update_card_title') }}</h4>
                        </div>

                        <div class="card-body">
                            @include('admin.shared.flash')

                            <div class="col">
                                <div class="form-group">
                                    <label>Role</label>
                                    <div class="selectgroup w-100">
                                        @foreach ($roles_ as $key => $value)
                                            <label class="selectgroup-item">
                                                <input type="radio" name="role" value="{{ $value }}" class="selectgroup-input" {{ strtolower($value) == $role_ ? 'checked=""' : '' }}>
                                                <span class="selectgroup-button">{{ $key }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" name="email"
                                           class="form-control @error('email') is-invalid @enderror @if (!$errors->has('email') && old('email')) is-valid @endif"
                                           value="{{ old('email', !empty($user) ? $user->email : null) }}">
                                    @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>First Name</label>
                                    <input type="text" name="first_name"
                                           class="form-control @error('first_name') is-invalid @enderror @if (!$errors->has('first_name') && old('first_name')) is-valid @endif"
                                           value="{{ old('first_name', !empty($user) ? $user->first_name : null) }}">
                                    @error('first_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input type="text" name="last_name"
                                           class="form-control @error('last_name') is-invalid @enderror @if (!$errors->has('last_name') && old('last_name')) is-valid @endif"
                                           value="{{ old('last_name', !empty($user) ? $user->last_name : null) }}">
                                    @error('last_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Clinic</label>
                                    <select class="form-control" name="clinic_id">
                                        <option>Select Clinic</option>
                                        @foreach ($clinics as $key => $value)
                                            <option value="{{ $key }}" {{ $key == $clinic ? 'selected' : '' }}>
                                                {{ $value['name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Gender</label>
                                    <div class="selectgroup w-100">
                                        @foreach ($genders_ as $key => $value)
                                            <label class="selectgroup-item">
                                                <input type="radio" name="gender" value="{{ $value }}" class="selectgroup-input" {{ $value == $gender ? 'checked=""' : '' }}>
                                                <span class="selectgroup-button">{{ $key }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Year of Birth</label>
                                    <input type="text" name="yob"
                                           class="form-control @error('yob') is-invalid @enderror @if (!$errors->has('yob') && old('yob')) is-valid @endif"
                                           value="{{ old('yob', !empty($user) ? $user->yob : null) }}">
                                    @error('yob')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Device Token</label>
                                    <input type="text" name="device_token"
                                           class="form-control @error('device_token') is-invalid @enderror @if (!$errors->has('device_token') && old('device_token')) is-valid @endif"
                                           value="{{ old('device_token', !empty($user) ? $user->device_token : null) }}">
                                    @error('device_token')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Region</label>
                                    <select class="form-control" name="region">
                                        <option>Select Region</option>

                                        @foreach ($regions as $value)
                                            <option value="{{ $value }}" {{ $value == $region ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Phone</label>
                                    <input type="text" name="phone"
                                           class="form-control @error('phone') is-invalid @enderror @if (!$errors->has('phone') && old('phone')) is-valid @endif"
                                           value="{{ old('phone', !empty($user) ? $user->phone : null) }}">
                                    @error('phone')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" name="password"
                                           class="form-control @error('password') is-invalid @enderror @if (!$errors->has('password') && old('password')) is-valid @endif">
                                    @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Password Confirmation</label>
                                    <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror @if (!$errors->has('password_confirmation') &&
                                    old('password_confirmation')) is-valid @endif">
                                    @error('password_confirmation')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
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
                                           value="{{ old('c_attachment', !empty($user) ? $user->secondary_message : null) }}">
                                    <a href="javascript:void(0);" onclick="another_upload($(this))" class="another_upload">[ Upload Another ]</a>
                                    @error('c_attachment')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

{{--                                <div class="form-group">--}}
{{--                                    <label style="color: #b91d19;">Location</label>--}}
{{--                                    <div class="row">--}}
{{--                                        <?php if (isset($brands)): ?>--}}
{{--                                            @foreach($brands as $brand)--}}
{{--                                            <?php $checkbox_fields = explode(', ', $user_brand); ?>--}}
{{--                                                <div class="col-sm-6">--}}
{{--                                                    <div class="form-check">--}}
{{--                                                        <input  <?php if (in_array($brand['campaign_name'], $checkbox_fields)) echo "checked" ?>--}}
{{--                                                                type="checkbox"--}}
{{--                                                                name="user_brand[]"--}}
{{--                                                                value="{{ $brand['campaign_name'] }}"--}}
{{--                                                        >--}}
{{--                                                        <label class="form-check-label " for="{{ $brand['campaign_name'] }}">--}}
{{--                                                        {{ $brand['campaign_name'] }}--}}
{{--                                                        </label>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            @endforeach--}}
{{--                                        <?php endif; ?>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

                            </div>

                        </div>

                        <div class="card-footer text-right">
                            <button
                                class="btn btn-primary">{{ empty($user) ? __('general.btn_create_label') : __('general.btn_update_label') }}</button>
                        </div>
                    </div>

                </div>

{{--                <div class="col">--}}
{{--                    <div class="card">--}}
{{--                        <div class="card-header">--}}
{{--                            Brand--}}
{{--                        </div>--}}
{{--                        <div class="card-body">--}}


{{--                            --}}

{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                <div class="col">--}}
{{--                    <div class="card">--}}
{{--                        <div class="card-header">--}}
{{--                            <h4>{{ __('users.set_user_permissions_label') }}</h4>--}}
{{--                        </div>--}}
{{--                        <div class="card-body">--}}
{{--                            @include('admin.roles._permissions')--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}

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
                    url: "<?php echo url('/admin/users/fileRemove'); ?>"+"/"+id,
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
