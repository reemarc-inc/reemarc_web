@extends('layouts.dashboard')

@section('content')

    <?php
    if (!empty($campaign)){
        if($campaign->status == 'archived'){
            $status = 'archived';
            $second = 'Project Archives';
            $third = 'Show Project';
        }else{
            $status = 'active';
            $second = 'Project Manage';
            $third = 'Update Project';
        }
    }else{
        $status = 'active';
        $second = 'Project Manage';
        $third = 'Create Project';
    }
    ?>

    <section class="section">
        <div class="section-header">
            <h1>Create Campaign</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ url('admin/campaign') }}">{{ $second }}</a></div>
                <div class="breadcrumb-item active">{{ $third }}</div>
            </div>
        </div>

        <div class="section-body">
            <h2 class="section-title">{{ $third }}</h2>

            <div class="row">
                <div class="col-lg-6">
                    @if (empty($campaign))
                        <form method="POST" action="{{ route('campaign.store') }}" enctype="multipart/form-data">
                    @else
                        <form method="POST" action="{{ route('campaign.update', $campaign->id) }}" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="{{ $campaign->id }}" />
                            @method('PUT')
                    @endif
                    @csrf
                            <div class="card">
                                <div class="card-header">
                                    <h4>{{ $third }}</h4>
                                </div>
                                <div class="card-body">
                                    @include('admin.shared.flash')
                                    <div class="col">
                                        <div class="form-group">
                                            <label>Brands</label>
                                            <select class="form-control @error('campaign_brand') is-invalid @enderror @if (!$errors->has('campaign_brand') && old('campaign_brand')) is-valid @endif"
                                                    name="campaign_brand">
                                                <option value="">Select</option>
                                                @foreach ($brands as $key => $value)
                                                    <option value="{{ $key }}" {{ $key == $campaign_brand ? 'selected' : '' }}>
                                                        {{ $value }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('campaign_brand')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Promotion</label>
                                            <select class="form-control @error('promotion') is-invalid @enderror @if (!$errors->has('promotion') && old('promotion')) is-valid @endif"
                                                    name="promotion">
                                                <option value="">Select</option>
                                                @foreach ($promotions as $value)
                                                    <option value="{{ $value }}" {{ $value == $promotion ? 'selected' : '' }}>
                                                        {{ $value }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('$promotion')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Project Name: </label>
                                            <input type="text" name="name"
                                                   class="form-control @error('name') is-invalid @enderror @if (!$errors->has('name') && old('name')) is-valid @endif"
                                                   value="{{ old('name', !empty($campaign) ? $campaign->name : null) }}">
                                            @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Run From: </label>
                                                    <input type="text" name="date_from" id="date_from" placeholder="Start date"
                                                           class="form-control datepicker @error('date_from') is-invalid @enderror @if (!$errors->has('date_from') && old('date_from')) is-valid @endif"
                                                           value="{{ old('date_from', !empty($campaign) ? $campaign->date_from : null) }}">
                                                    @error('date_from')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Run To: </label>
                                                    <input type="text" name="date_to" id="date_to" placeholder="End date"
                                                           class="form-control datepicker @error('date_to') is-invalid @enderror @if (!$errors->has('date_to') && old('date_to')) is-valid @endif"
                                                           value="{{ old('date_to', !empty($campaign) ? $campaign->date_to : null) }}">
                                                    @error('date_to')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Primary Message: </label>
                                            <input type="text" name="primary_message"
                                                   class="form-control @error('primary_message') is-invalid @enderror @if (!$errors->has('primary_message') && old('primary_message')) is-valid @endif"
                                                   value="{{ old('primary_message', !empty($campaign) ? $campaign->primary_message : null) }}">
                                            @error('primary_message')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Products Featured: </label>
                                            <input type="text" name="products_featured"
                                                   class="form-control @error('products_featured') is-invalid @enderror @if (!$errors->has('products_featured') && old('products_featured')) is-valid @endif"
                                                   value="{{ old('products_featured', !empty($campaign) ? $campaign->products_featured : null) }}">
                                            @error('products_featured')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Secondary Message: </label>
                                            <input type="text" name="secondary_message"
                                                   class="form-control @error('secondary_message') is-invalid @enderror @if (!$errors->has('secondary_message') && old('secondary_message')) is-valid @endif"
                                                   value="{{ old('secondary_message', !empty($campaign) ? $campaign->secondary_message : null) }}">
                                            @error('secondary_message')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Note / Description: </label>
                                            {!! Form::textarea('campaign_notes', !empty($campaign) ? $campaign->campaign_notes : null, ['class' => 'form-control summernote']) !!}
                                            @error('campaign_notes')
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
                                            <label>Upload Visual References: </label>
                                            <input type="file" id="c_attachment[]" name="c_attachment[]"
                                                   data-asset="default" multiple="multiple"
                                                   class="form-control c_attachment last_upload @error('c_attachment') is-invalid @enderror @if (!$errors->has('c_attachment') && old('c_attachment')) is-valid @endif"
                                                   value="{{ old('c_attachment', !empty($campaign) ? $campaign->secondary_message : null) }}">
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
                                    <?php if ($status == 'active') { ?>
                                        <button class="btn btn-primary">{{ empty($campaign) ? __('Create') : __('Save Changes') }}</button>
                                    <?php } ?>
                                </div>
                            </div>
                        </form>

                    @if(!empty($assets))
                    <div class="card assets_existing">
                        <?php foreach ($assets as $asset): ?>
                                <div class="clearfix" id="{{$asset->a_id}}">
                                    <div class="card box asset box-primary">
                                        <div class="card-header">
                                            <div class="ecommerce_new">
                                                <h5>{{ ucwords(str_replace('_', ' ', $asset->a_type)) }}
                                                    <span style="color:#933434">#{{ $asset->a_id }}</span>
                                                    <span style="color:#636363; font-size: medium;">({{ ucwords(str_replace('_', ' ', $asset->status)) }})</span>
{{--                                                    <span style="color:#636363; font-size: medium;">({{ ucwords(str_replace('_', ' ', $asset->decline_creative)) }})</span>--}}
                                                    <span style="color:#999; font-size: medium;">{{ date('m/d/Y', strtotime($asset->due)) }}</span>
                                                    <span class="float-right">
                                                        <i class="dropdown fa fa-angle-down" onclick="click_arrow(this, {{$asset->a_id}})"></i>
                                                        <a  href="javascript:void(0);"
                                                            class="close"
                                                            data-id=""
                                                            data-asset-id="{{ $asset->a_id }}"
                                                            data-asset-type="{{ $asset->a_type }}"
                                                            onclick="delete_asset($(this));">
                                                            <i class="fa fa-times"></i>
                                                        </a>
                                                    </span>
                                                </h5>
                                            </div>

                                            <div id="asset-id-{{$asset->a_id}}" class="box-body form_creator" data-asset-id="{{ $asset->a_id }}" style="display: none">
                                                <section>
                                                    <div class="inner_box">
                                                        <?php $data = [$asset->detail, $asset->files, $asset->status, $asset->decline_creative, $asset->decline_kec, $asset->decline_copy]; ?>
                                                        @include('admin.campaign.asset.'.$asset->a_type, $data)
                                                    </div>
                                                </section>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                        <?php endforeach; ?>
                    </div>
                    @endif

                    @if(!empty($campaign))

                        <div class="clearfix" id="asset_selector" style="display: block">
                        <div class="card box asset box-primary">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-6" id="add_asset_btn" style="display: block">
                                        <a class="btn btn-light add-row" onclick="click_asset_add_btn()">Add asset needed</a>
                                    </div>
                                </div>

                                <div id="asset_new" class="box-body form_creator" data-asset-id="" style="display: none">
                                    <section>
                                        <div class="inner_box">
                                            <div class="form-group">
                                                <label style="color: #a50018; font-size: 1.2rem;">Asset Type: </label>
                                                <span id="asset_type_name" class="asset_type_name"></span>
                                                <span class="float-right">
                                                    <a href="{{ url('admin/campaign/'. $campaign->id .'/edit') }}">
                                                        <i class="fa fa-times" style="font-size: 1.5rem;"></i>
                                                    </a>
                                                </span>

                                                <select name="add_asset_type" id="add_asset_type" class="form-control" onchange="change_asset_type()">
                                                    <option value="">Select</option>
                                                    <option value="email_blast">Email Blast</option>
                                                    <option value="social_ad">Social Ad</option>
                                                    <option value="website_banners">Website Banners</option>
                                                    <option value="website_changes">Website Changes</option>
                                                    <option value="landing_page">Landing Page</option>
                                                    <option value="misc">Misc</option>
                                                    <option value="topcategories_copy">Top Categories Copy</option>
                                                    <option value="programmatic_banners">Programmatic Banners</option>
                                                    <option value="image_request">Image Request</option>
                                                    <option value="roll_over">Roll Over</option>
                                                    <option value="store_front">Store Front</option>
                                                    <option value="a_content">A+ Content</option>
                                                </select>
                                            </div>

                                            <div id="new_email_blast" style="display: none;">
                                                @include('admin.campaign.asset.new.email_blast')
                                            </div>
                                            <div id="new_landing_page" style="display: none;">
                                                @include('admin.campaign.asset.new.landing_page')
                                            </div>
                                            <div id="new_misc" style="display: none;">
                                                @include('admin.campaign.asset.new.misc')
                                            </div>
                                            <div id="new_social_ad" style="display: none;">
                                                @include('admin.campaign.asset.new.social_ad')
                                            </div>
                                            <div id="new_website_banners" style="display: none;">
                                                @include('admin.campaign.asset.new.website_banners')
                                            </div>
                                            <div id="new_website_changes" style="display: none;">
                                                @include('admin.campaign.asset.new.website_changes')
                                            </div>
                                            <div id="new_topcategories_copy" style="display: none;">
                                                @include('admin.campaign.asset.new.topcategories_copy')
                                            </div>
                                            <div id="new_programmatic_banners" style="display: none;">
                                                @include('admin.campaign.asset.new.programmatic_banners')
                                            </div>
                                            <div id="new_image_request" style="display: none;">
                                                @include('admin.campaign.asset.new.image_request')
                                            </div>
                                            <div id="new_roll_over" style="display: none;">
                                                @include('admin.campaign.asset.new.roll_over')
                                            </div>
                                            <div id="new_store_front" style="display: none;">
                                                @include('admin.campaign.asset.new.store_front')
                                            </div>
                                            <div id="new_a_content" style="display: none;">
                                                @include('admin.campaign.asset.new.a_content')
                                            </div>

                                        </div>
                                    </section>
                                </div>

                            </div>
                        </div>
                    </div>
                    @endif

                </div>

                @if(!empty($campaign))
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>CORRESPONDENCE</h4>
                        </div>
                        <div class="card-body">
                            <div class="col">
                                <div class="form-group">
                                    @foreach ($correspondences as $correspondence)
                                        <?php $color_role = strtolower(add_underscores($correspondence->users->role)); ?>
                                        <div class="note">
                                            <ul class="list-unstyled list-unstyled-border list-unstyled-noborder">
                                                <li class="media">
                                                    <div class="media-body">
                                                        <div class="media-title-note {{$color_role}}" >
                                                            <div class="media-right"><div class="text-time">{{ date('m/d/y g:i A', strtotime($correspondence->date_created)) }}</div></div>
                                                            <div class="media-title mb-1">{{ $correspondence->users->first_name }}</div>
                                                            <div class="text-time">{{ $correspondence->users->team }} | {{ $correspondence->users->role }}</div>
                                                        </div>
                                                        <div class="media-description text-muted" style="padding: 15px;">
                                                            {!! $correspondence->note !!}
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>

                                    @endforeach

                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                @endif

            </div>
        </div>

    </section>

    <?php if (!empty($attach_files)): ?>
        <?php foreach ($attach_files as $attachment): ?>
            <div class="modal fade"
                 id="exampleModal_<?php echo $attachment['attachment_id']; ?>"
                 tabindex="-1"
                 role="dialog"
                 aria-labelledby="exampleModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog"
                     role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button"
                                    class="close"
                                    data-dismiss="modal"
                                    aria-label="Close">
                                    <span aria-hidden="true">
                                      ×
                                  </span>
                            </button>
                        </div>
                        <!--Modal body with image-->
                        <?php $name = explode('/', $attachment['attachment']); ?>
                        <?php $name = $name[count($name)-1]; ?>
                        <div class="modal-title text-lg-center">{{ $name }}</div>
                        <div class="modal-body">
                            <img class="img-fluid" src=<?php echo '/storage' . $attachment['attachment']; ?> />
                        </div>
                        <div class="modal-footer">
                            <button type="button"
                                    class="btn btn-primary"
                                    data-dismiss="modal"
                                    onclick="open_download('<?php echo '/storage' . $attachment['attachment']; ?>')"
                            >
                                Download
                            </button>
                            <button type="button"
                                    class="btn btn-danger"
                                    data-dismiss="modal">
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>


    <script>
        function click_asset_add_btn(){

            $("#add_asset_btn").hide();
            $("#asset_new").show();

        }

        function change_asset_type(){

            add_asset_type = $('#add_asset_type option:selected').val();

            if(add_asset_type == 'email_blast'){
                $("#asset_type_name").text('Email Blast');
                $("#new_email_blast").show();
                $("#new_landing_page").hide();
                $("#new_misc").hide();
                $("#new_social_ad").hide();
                $("#new_website_banners").hide();
                $("#new_website_changes").hide();
                $("#new_topcategories_copy").hide();
                $("#new_programmatic_banners").hide();
                $("#new_image_request").hide();
                $("#new_roll_over").hide();
                $("#new_store_front").hide();
                $("#new_a_content").hide();
            }
            if(add_asset_type == 'landing_page'){
                $("#asset_type_name").text('Landing Page');
                $("#new_email_blast").hide();
                $("#new_landing_page").show();
                $("#new_misc").hide();
                $("#new_social_ad").hide();
                $("#new_website_banners").hide();
                $("#new_website_changes").hide();
                $("#new_topcategories_copy").hide();
                $("#new_programmatic_banners").hide();
                $("#new_image_request").hide();
                $("#new_roll_over").hide();
                $("#new_store_front").hide();
                $("#new_a_content").hide();
            }
            if(add_asset_type == 'misc'){
                $("#asset_type_name").text('Misc');
                $("#new_email_blast").hide();
                $("#new_landing_page").hide();
                $("#new_misc").show();
                $("#new_social_ad").hide();
                $("#new_website_banners").hide();
                $("#new_website_changes").hide();
                $("#new_topcategories_copy").hide();
                $("#new_programmatic_banners").hide();
                $("#new_image_request").hide();
                $("#new_roll_over").hide();
                $("#new_store_front").hide();
                $("#new_a_content").hide();
            }
            if(add_asset_type == 'social_ad'){
                $("#asset_type_name").text('Social Ad');
                $("#new_email_blast").hide();
                $("#new_landing_page").hide();
                $("#new_misc").hide();
                $("#new_social_ad").show();
                $("#new_website_banners").hide();
                $("#new_website_changes").hide();
                $("#new_topcategories_copy").hide();
                $("#new_programmatic_banners").hide();
                $("#new_image_request").hide();
                $("#new_roll_over").hide();
                $("#new_store_front").hide();
                $("#new_a_content").hide();
            }
            if(add_asset_type == 'website_banners'){
                $("#asset_type_name").text('Website Banners');
                $("#new_email_blast").hide();
                $("#new_landing_page").hide();
                $("#new_misc").hide();
                $("#new_social_ad").hide();
                $("#new_website_banners").show();
                $("#new_website_changes").hide();
                $("#new_topcategories_copy").hide();
                $("#new_programmatic_banners").hide();
                $("#new_image_request").hide();
                $("#new_roll_over").hide();
                $("#new_store_front").hide();
                $("#new_a_content").hide();
            }
            if(add_asset_type == 'website_changes'){
                $("#asset_type_name").text('Website Changes');
                $("#new_email_blast").hide();
                $("#new_landing_page").hide();
                $("#new_misc").hide();
                $("#new_social_ad").hide();
                $("#new_website_banners").hide();
                $("#new_website_changes").show();
                $("#new_topcategories_copy").hide();
                $("#new_programmatic_banners").hide();
                $("#new_image_request").hide();
                $("#new_roll_over").hide();
                $("#new_store_front").hide();
                $("#new_a_content").hide();
            }
            if(add_asset_type == 'topcategories_copy'){
                $("#asset_type_name").text('TopCategories Copy');
                $("#new_email_blast").hide();
                $("#new_landing_page").hide();
                $("#new_misc").hide();
                $("#new_social_ad").hide();
                $("#new_website_banners").hide();
                $("#new_website_changes").hide();
                $("#new_topcategories_copy").show();
                $("#new_programmatic_banners").hide();
                $("#new_image_request").hide();
                $("#new_roll_over").hide();
                $("#new_store_front").hide();
                $("#new_a_content").hide();
            }
            if(add_asset_type == 'programmatic_banners'){
                $("#asset_type_name").text('Programmatic Banners');
                $("#new_email_blast").hide();
                $("#new_landing_page").hide();
                $("#new_misc").hide();
                $("#new_social_ad").hide();
                $("#new_website_banners").hide();
                $("#new_website_changes").hide();
                $("#new_topcategories_copy").hide();
                $("#new_programmatic_banners").show();
                $("#new_image_request").hide();
                $("#new_roll_over").hide();
                $("#new_store_front").hide();
                $("#new_a_content").hide();
            }
            if(add_asset_type == 'image_request'){
                $("#asset_type_name").text('Image Request');
                $("#new_email_blast").hide();
                $("#new_landing_page").hide();
                $("#new_misc").hide();
                $("#new_social_ad").hide();
                $("#new_website_banners").hide();
                $("#new_website_changes").hide();
                $("#new_topcategories_copy").hide();
                $("#new_programmatic_banners").hide();
                $("#new_image_request").show();
                $("#new_roll_over").hide();
                $("#new_store_front").hide();
                $("#new_a_content").hide();
            }
            if(add_asset_type == 'roll_over'){
                $("#asset_type_name").text('Roll Over');
                $("#new_email_blast").hide();
                $("#new_landing_page").hide();
                $("#new_misc").hide();
                $("#new_social_ad").hide();
                $("#new_website_banners").hide();
                $("#new_website_changes").hide();
                $("#new_topcategories_copy").hide();
                $("#new_programmatic_banners").hide();
                $("#new_image_request").hide();
                $("#new_roll_over").show();
                $("#new_store_front").hide();
                $("#new_a_content").hide();
            }
            if(add_asset_type == 'store_front'){
                $("#asset_type_name").text('Store Front');
                $("#new_email_blast").hide();
                $("#new_landing_page").hide();
                $("#new_misc").hide();
                $("#new_social_ad").hide();
                $("#new_website_banners").hide();
                $("#new_website_changes").hide();
                $("#new_topcategories_copy").hide();
                $("#new_programmatic_banners").hide();
                $("#new_image_request").hide();
                $("#new_roll_over").hide();
                $("#new_store_front").show();
                $("#new_a_content").hide();
            }
            if(add_asset_type == 'a_content'){
                $("#asset_type_name").text('A+ Content');
                $("#new_email_blast").hide();
                $("#new_landing_page").hide();
                $("#new_misc").hide();
                $("#new_social_ad").hide();
                $("#new_website_banners").hide();
                $("#new_website_changes").hide();
                $("#new_topcategories_copy").hide();
                $("#new_programmatic_banners").hide();
                $("#new_image_request").hide();
                $("#new_roll_over").hide();
                $("#new_store_front").hide();
                $("#new_a_content").show();
            }

        }

        function click_arrow(el, asset_id){
            // alert("hi");
            if($(el).hasClass('fa-angle-up')){
                $(el).toggleClass('with-border');
                $(el).removeClass('fa-angle-up');
                $(el).addClass('fa-angle-down');
                $('#asset-id-'+asset_id).hide();
            }else{
                $(el).removeClass('fa-angle-down');
                $(el).addClass('fa-angle-up');
                $('#asset-id-'+asset_id).show();
            }
        }

        function delete_asset(el) {
            if (confirm("Are you sure to Delete?") == true) {
                let id = $(el).attr('data-asset-id');
                let type = $(el).attr('data-asset-type');
                $.ajax({
                    url: "<?php echo url('/admin/campaign/assetRemove'); ?>"+"/"+id+"/"+type,
                    type: "GET",
                    datatype: "json",
                    success: function(response) {
                        if(response == 'fail'){
                            alert('Failed');
                        }else{
                            $(el).parent().parent().parent().parent().parent().parent().fadeOut( "slow", function() {
                                $(el).parent().parent().parent().parent().parent().parent().remove();
                            });
                            window.location.reload(response);
                        }
                    },
                })
            }
        }


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
                    url: "<?php echo url('/admin/campaign/fileRemove'); ?>"+"/"+id,
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

        function open_download(link) {
            let click_link = document.createElement('a');
            click_link.href = link;
            image_arr = link.split('/');
            link = image_arr[image_arr.length-1];
            click_link.download = link;
            document.body.appendChild(click_link);
            click_link.click();
        }

        function copy_requested_toggle(el) {
            box = $(el).prev();
            if ($(el).prop('checked') == true) {
                if(box.is("div")){ // for editor
                    box.children('.note-editing-area').children('.note-editable').text('Requested');
                    box.prev().val('Requested');
                }
                if(box.is("input")){
                    box.attr('readonly', 'readonly');
                    box.attr('value', 'Requested');
                    box.val('Requested');
                }
                if(box.is("textarea")){
                    box.val('Requested');
                    box.attr('readonly', 'readonly');
                }
            } else {
                if(box.is("div")){ // for editor
                    box.children('.note-editing-area').children('.note-editable').text('');
                    box.prev().val('');
                }
                if(box.is("input")){ // for input, textarea
                    box.removeAttr('readonly');
                    box.attr('value', '');
                    box.val('');
                }
                if(box.is("textarea")){
                    box.removeAttr('readonly');
                    box.val('');
                }
            }
        }

        function change_to_copy_review(el){

            if (confirm("Are you sure to Copy Review?") == true) {
                let id = $(el).attr('data-asset-id');
                $.ajax({
                    url: "<?php echo url('/admin/asset/copyReview'); ?>"+"/"+id,
                    type: "GET",
                    datatype: "json",
                    success: function(response) {
                        if(response != 'fail'){
                            alert('Success!');
                            window.location.reload(response);
                            $(el).remove();
                        }else{
                            alert('Error!');
                        }
                    },
                })
            }
        }

        function change_to_copy_complete(el){

            if (confirm("Are you sure to Copy Completed?") == true) {
                let id = $(el).attr('data-asset-id');
                $.ajax({
                    url: "<?php echo url('/admin/asset/copyComplete'); ?>"+"/"+id,
                    type: "GET",
                    datatype: "json",
                    success: function(response) {
                        if(response != 'fail'){
                            alert('Success!');
                            window.location.reload(response);
                            $(el).remove();
                        }else{
                            alert('Error!');
                        }
                    },
                })
            }
        }

        function work_start(el){

            if (confirm("Are you sure to In Progress?") == true) {
                let id = $(el).attr('data-asset-id');
                $.ajax({
                    url: "<?php echo url('/admin/asset/inProgress'); ?>"+"/"+id,
                    type: "GET",
                    datatype: "json",
                    success: function(response) {
                        if(response != 'fail'){
                            alert('Success!');
                            window.location.reload(response);
                            $(el).remove();
                        }else{
                            alert('Error!');
                        }
                    },
                })
            }
        }

        function work_done(el){

            if (confirm("Are you sure to Done?") == true) {
                let id = $(el).attr('data-asset-id');
                $.ajax({
                    url: "<?php echo url('/admin/asset/done'); ?>"+"/"+id,
                    type: "GET",
                    datatype: "json",
                    success: function(response) {
                        if(response != 'fail'){
                            alert('Success!');
                            window.location.reload(response);
                            $(el).remove();
                        }else{
                            alert('Error!');
                        }
                    },
                })
            }
        }

        function final_approval(el){

            if (confirm("Are you sure to Final Approval?") == true) {
                let id = $(el).attr('data-asset-id');
                $.ajax({
                    url: "<?php echo url('/admin/asset/finalApproval'); ?>"+"/"+id,
                    type: "GET",
                    datatype: "json",
                    success: function(response) {
                        if(response != 'fail'){
                            alert('Success!');
                            window.location.reload(response);
                            $(el).remove();
                        }else{
                            alert('Error!');
                        }
                    },
                })
            }
        }

    </script>

@endsection
