@extends('layouts.dashboard')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Package Management</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ url('admin/package') }}">Package</a></div>
                <div class="breadcrumb-item">Edit Package</div>
            </div>
        </div>

        @if (empty($package ?? '' ?? ''))
            <form method="POST" action="{{ route('package.store') }}" enctype="multipart/form-data">
        @else
            <form method="POST" action="{{ route('package.update', $package->id) }}" enctype="multipart/form-data">
                <input type="hidden" name="id" value="{{ $package->id }}" />
                @method('PUT')
        @endif
            @csrf
                <div class="section-body">
                    <h2 class="section-title">{{ empty($package) ? 'New Package' : 'Package Update' }}</h2>

                    <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ empty($package) ? 'Add New Package' : 'Update Package' }}</h4>
                        </div>

                        <div class="card-body">
                            @include('admin.shared.flash')

                            <div class="col">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" name="name"
                                           class="form-control @error('name') is-invalid @enderror @if (!$errors->has('name') && old('name')) is-valid @endif"
                                           value="{{ old('name', !empty($package) ? $package->name : null) }}">
                                    @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Number of Aligners</label>
                                    <input type="text" name="number_of_aligners"
                                           class="form-control @error('number_of_aligners') is-invalid @enderror @if (!$errors->has('number_of_aligners') && old('number_of_aligners')) is-valid @endif"
                                           value="{{ old('number_of_aligners', !empty($package) ? $package->number_of_aligners : null) }}">
                                    @error('number_of_aligners')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Treatment Duration</label>
                                    <input type="text" name="treatment_duration"
                                           class="form-control @error('treatment_duration') is-invalid @enderror @if (!$errors->has('treatment_duration') && old('treatment_duration')) is-valid @endif"
                                           value="{{ old('treatment_duration', !empty($package) ? $package->treatment_duration : null) }}">
                                    @error('treatment_duration')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Price in USD</label>
                                    <input type="text" name="us_price"
                                           class="form-control @error('us_price') is-invalid @enderror @if (!$errors->has('us_price') && old('us_price')) is-valid @endif"
                                           value="{{ old('us_price', !empty($package) ? $package->us_price : null) }}">
                                    @error('us_price')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Price in KRW</label>
                                    <input type="text" name="kr_price"
                                           class="form-control @error('kr_price') is-invalid @enderror @if (!$errors->has('kr_price') && old('kr_price')) is-valid @endif"
                                           value="{{ old('kr_price', !empty($package) ? $package->kr_price : null) }}">
                                    @error('kr_price')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Summary</label>
                                    <textarea class="form-control" id="summary" name="summary" style="height: 100px;">{{ old('summary', !empty($package) ? $package->summary : null) }}</textarea>
{{--                                    <input type="text" name="description"--}}
{{--                                           class="form-control @error('description') is-invalid @enderror @if (!$errors->has('description') && old('description')) is-valid @endif"--}}
{{--                                           value="{{ old('description', !empty($package) ? $package->description : null) }}">--}}
                                    @error('summary')
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
                                           value="{{ old('c_attachment', !empty($package) ? $package->secondary_message : null) }}">
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
                                class="btn btn-primary">{{ empty($package) ? __('general.btn_create_label') : __('general.btn_update_label') }}</button>
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
                    url: "<?php echo url('/admin/package/fileRemove'); ?>"+"/"+id,
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
