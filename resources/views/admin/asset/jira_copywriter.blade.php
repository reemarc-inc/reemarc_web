@extends('layouts.dashboard')

@section('content')

    <section class="section">
        <div class="section-header">
            <h1>Status Board (Copywriter)</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Status Board (Digital Ops)</div>
            </div>
        </div>

        <div class="section-body">

            @include('admin.asset.jira_copywriter_filter')
            @include('admin.asset.flash')

            <div class="row" style="margin-top: 15px;">

                <div class="col-md-3" >
                    <div class="card status_title">
                        <h5 class="status_name">COPY REQUESTED</h5>
                    </div>
                    @foreach ($asset_list_copy_request as $asset)

                        <?php
                        $start_css = 'color:#98a6ad;';
                        $start_late_css = "color:#a50018;";
                        if($asset->asset_type == 'email_blast'){
                            $start_date = date('m/d/Y', strtotime($asset->due . ' -23 weekday'));
                            if(strtotime($start_date) <= strtotime(date('m/d/Y')) ){
                                $start_css = $start_late_css;
                            }
                        }else if($asset->asset_type == 'website_banners'){
                            $start_date = date('m/d/Y', strtotime($asset->due . ' -24 weekday'));
                            if(strtotime($start_date) <= strtotime(date('m/d/Y')) ){
                                $start_css = $start_late_css;
                            }
                        }else if($asset->asset_type == 'social_ad'){
                            $start_date = date('m/d/Y', strtotime($asset->due . ' -23 weekday'));
                            if(strtotime($start_date) <= strtotime(date('m/d/Y')) ){
                                $start_css = $start_late_css;
                            }
                        }else if($asset->asset_type == 'landing_page'){
                            $start_date = date('m/d/Y', strtotime($asset->due . ' -37 weekday'));
                            if(strtotime($start_date) <= strtotime(date('m/d/Y')) ){
                                $start_css = $start_late_css;
                            }
                        }else if($asset->asset_type == 'topcategories_copy'){
                            $start_date =  date('m/d/Y', strtotime($asset->due . ' -5 weekday'));
                            if(strtotime($start_date) <= strtotime(date('m/d/Y')) ){
                                $start_css = $start_late_css;
                            }
                        }else if($asset->asset_type == 'a_content'){
                            $start_date = date('m/d/Y', strtotime($asset->due . ' -34 weekday'));
                            if(strtotime($start_date) <= strtotime(date('m/d/Y')) ){
                                $start_css = $start_late_css;
                            }
                        }else if ($asset->asset_type == 'programmatic_banners'){
                            $start_date = date('m/d/Y', strtotime($asset->due . ' -26 weekday'));
                            if(strtotime($start_date) <= strtotime(date('m/d/Y')) ){
                                $start_css = $start_late_css;
                            }
                        }else if($asset->asset_type == 'misc'){
                            $start_date = date('m/d/Y', strtotime($asset->due . ' -22 weekday'));
                            if(strtotime($start_date) <= strtotime(date('m/d/Y')) ){
                                $start_css = $start_late_css;
                            }
                        }else{
                            $start_date = 'N/A';
                        }
                        ?>
                        <div class="card">
                            <a href="{{ url('admin/campaign/'. $asset->campaign_id .'/edit#'.$asset->asset_id)}}" style="text-decoration: none;">
                                <div class="card-body" style="margin: 0px -5px -20px -5px;">
                                    <div class="media" style="padding-bottom: 0px;">
                                        <div class="form-group" style="width: 100%;">

                                            <div style="color: #8b8a8a; font-weight: 600; float:left; font-size: 13px;">
                                                {{$asset->campaign_name}}
                                            </div>
                                            <div style="float: right;">
                                                <figure class="avatar mr-2 avatar-sm text-white" style="background-color: #b6b6b6; font-size: 15px;"
                                                        data-toggle="tooltip" data-placement="top"
                                                        data-original-title="{{ $asset->author_name }}"
                                                        data-initial="{{ substr($asset->author_name, 0, 1) }}">
                                                </figure>
                                            </div>
                                            <div class="media-title" style="clear:both; font-size: large;">
                                                {{ ucwords(str_replace('_', ' ', $asset->asset_type)) }}
                                            </div>
                                            <div class="text-md-left text-muted" style="margin-top: -8px;">
                                                {{ mb_strimwidth($asset->name, 0,50, '...') }}
                                            </div>
                                            <hr style="border-width: 1px 0px 0px 0px;border-style:solid;border-color: #e0e0e0;
                                                            height:1px;margin-top: 15px;margin-bottom: 10px;width:100%">
                                            <?php if($asset->team_to == 'content') {
                                                $bg_type = '#9f76c2';
                                            }else if($asset->team_to == 'web production'){
                                                $bg_type = '#017cc2';
                                            }else{
                                                $bg_type = '#03b06d';
                                            }
                                            ?>
                                            <div class="text-sm-left text-muted" style="float:left; margin-top: -1px;">
                                                <figure class="avatar sm-2 text-white" style="width: 15px; height: 15px; background-color: {{$bg_type}}; font-size: small;" data-initial=""></figure>
                                            </div>
                                            <div class="text-sm-left text-muted" style="float:left; padding-left: 10px;">
                                                {{$asset->asset_id}}
                                            </div>
                                            <div style="float: right;" >
                                                {{ $start_date }}
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                <div class="col-md-3" >
                    <div class="card status_title">
                        <h5 class="status_name">COPY TO DO</h5>
                    </div>
                    @foreach ($asset_list_copy_to_do as $asset)

                        <?php
                        $start_css = 'color:#98a6ad;';
                        $start_late_css = "color:#a50018;";
                        if($asset->asset_type == 'email_blast'){
                            $start_date = date('m/d/Y', strtotime($asset->due . ' -23 weekday'));
                            if(strtotime($start_date) <= strtotime(date('m/d/Y')) ){
                                $start_css = $start_late_css;
                            }
                        }else if($asset->asset_type == 'website_banners'){
                            $start_date = date('m/d/Y', strtotime($asset->due . ' -24 weekday'));
                            if(strtotime($start_date) <= strtotime(date('m/d/Y')) ){
                                $start_css = $start_late_css;
                            }
                        }else if($asset->asset_type == 'social_ad'){
                            $start_date = date('m/d/Y', strtotime($asset->due . ' -23 weekday'));
                            if(strtotime($start_date) <= strtotime(date('m/d/Y')) ){
                                $start_css = $start_late_css;
                            }
                        }else if($asset->asset_type == 'landing_page'){
                            $start_date = date('m/d/Y', strtotime($asset->due . ' -37 weekday'));
                            if(strtotime($start_date) <= strtotime(date('m/d/Y')) ){
                                $start_css = $start_late_css;
                            }
                        }else if($asset->asset_type == 'topcategories_copy'){
                            $start_date =  date('m/d/Y', strtotime($asset->due . ' -5 weekday'));
                            if(strtotime($start_date) <= strtotime(date('m/d/Y')) ){
                                $start_css = $start_late_css;
                            }
                        }else if($asset->asset_type == 'a_content'){
                            $start_date = date('m/d/Y', strtotime($asset->due . ' -34 weekday'));
                            if(strtotime($start_date) <= strtotime(date('m/d/Y')) ){
                                $start_css = $start_late_css;
                            }
                        }else if ($asset->asset_type == 'programmatic_banners'){
                            $start_date = date('m/d/Y', strtotime($asset->due . ' -26 weekday'));
                            if(strtotime($start_date) <= strtotime(date('m/d/Y')) ){
                                $start_css = $start_late_css;
                            }
                        }else if($asset->asset_type == 'misc'){
                            $start_date = date('m/d/Y', strtotime($asset->due . ' -22 weekday'));
                            if(strtotime($start_date) <= strtotime(date('m/d/Y')) ){
                                $start_css = $start_late_css;
                            }
                        }else{
                            $start_date = 'N/A';
                        }
                        ?>
                        <div class="card">
                            <a href="{{ url('admin/campaign/'. $asset->campaign_id .'/edit#'.$asset->asset_id)}}" style="text-decoration: none;">
                                <div class="card-body" style="margin: 0px -5px -20px -5px;">
                                    <div class="media" style="padding-bottom: 0px;">
                                        <div class="form-group" style="width: 100%;">

                                            <div style="color: #8b8a8a; font-weight: 600; float:left; font-size: 13px;">
                                                {{$asset->campaign_name}}
                                            </div>
                                            <div style="float: right;">
                                                <figure class="avatar mr-2 avatar-sm text-white"
                                                        style="background-color: #848484; font-size: 15px; margin-left: -15px; z-index: 1; border: 1px solid white;"
                                                        data-toggle="tooltip" data-placement="top"
                                                        data-original-title="{{ $asset->copy_writer }}"
                                                        data-initial="{{ substr($asset->copy_writer, 0, 1) }}">
                                                </figure>
                                            </div>
                                            <div style="float: right;">
                                                <figure class="avatar mr-2 avatar-sm text-white" style="background-color: #b6b6b6; font-size: 15px;"
                                                        data-toggle="tooltip" data-placement="top"
                                                        data-original-title="{{ $asset->author_name }}"
                                                        data-initial="{{ substr($asset->author_name, 0, 1) }}">
                                                </figure>
                                            </div>
                                            <div class="media-title" style="clear:both; font-size: large;">
                                                {{ ucwords(str_replace('_', ' ', $asset->asset_type)) }}
                                            </div>
                                            <div class="text-md-left text-muted" style="margin-top: -8px;">
                                                {{ mb_strimwidth($asset->name, 0,50, '...') }}
                                            </div>
                                            <hr style="border-width: 1px 0px 0px 0px;border-style:solid;border-color: #e0e0e0;
                                                            height:1px;margin-top: 15px;margin-bottom: 10px;margin-bottom: 5px;width:100%">
                                            <?php if($asset->team_to == 'content') {
                                                $bg_type = '#9f76c2';
                                            }else if($asset->team_to == 'web production'){
                                                $bg_type = '#017cc2';
                                            }else{
                                                $bg_type = '#03b06d';
                                            }
                                            ?>
                                            <div class="text-sm-left text-muted" style="float:left; margin-top: -1px;">
                                                <figure class="avatar sm-2 text-white" style="width: 15px; height: 15px; background-color: {{$bg_type}}; font-size: small;" data-initial=""></figure>
                                            </div>
                                            <div class="text-sm-left text-muted" style="float:left; padding-left: 10px;">
                                                {{$asset->asset_id}}
                                            </div>
                                            <div style="float: right;" >
                                                {{ $start_date }}
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                <div class="col-md-3" >
                    <div class="card status_title">
                        <h5 class="status_name">COPY IN PROGRESS</h5>
                    </div>
                    @foreach ($asset_list_copy_in_progress as $asset)

                        <div class="card">
                            <a href="{{ url('admin/campaign/'. $asset->campaign_id .'/edit#'.$asset->asset_id)}}" style="text-decoration: none;">
                                <div class="card-body" style="margin: 0px -5px -20px -5px;">
                                    <div class="media" style="padding-bottom: 0px;">
                                        <div class="form-group" style="width: 100%;">

                                            <div style="color: #8b8a8a; font-weight: 600; float:left; font-size: 13px;">
                                                {{$asset->campaign_name}}
                                            </div>
                                            <div style="float: right;">
                                                <figure class="avatar mr-2 avatar-sm text-white"
                                                        style="background-color: #848484; font-size: 15px; margin-left: -15px; z-index: 1; border: 1px solid white;"
                                                        data-toggle="tooltip" data-placement="top"
                                                        data-original-title="{{ $asset->copy_writer }}"
                                                        data-initial="{{ substr($asset->copy_writer, 0, 1) }}">
                                                </figure>
                                            </div>
                                            <div style="float: right;">
                                                <figure class="avatar mr-2 avatar-sm text-white" style="background-color: #b6b6b6; font-size: 15px;"
                                                        data-toggle="tooltip" data-placement="top"
                                                        data-original-title="{{ $asset->author_name }}"
                                                        data-initial="{{ substr($asset->author_name, 0, 1) }}">
                                                </figure>
                                            </div>
                                            <div class="media-title" style="clear:both; font-size: large;">
                                                {{ ucwords(str_replace('_', ' ', $asset->asset_type)) }}
                                            </div>
                                            <div class="text-md-left text-muted" style="margin-top: -8px;">
                                                {{ mb_strimwidth($asset->name, 0,50, '...') }}
                                            </div>
                                            <hr style="border-width: 1px 0px 0px 0px;border-style:solid;border-color: #e0e0e0;
                                                            height:1px;margin-top: 15px;margin-bottom: 10px;width:100%">
                                            <?php if($asset->team_to == 'content') {
                                                $bg_type = '#9f76c2';
                                            }else if($asset->team_to == 'web production'){
                                                $bg_type = '#017cc2';
                                            }else{
                                                $bg_type = '#03b06d';
                                            }
                                            ?>
                                            <div class="text-sm-left text-muted" style="float:left; margin-top: -1px;">
                                                <figure class="avatar sm-2 text-white" style="width: 15px; height: 15px; background-color: {{$bg_type}}; font-size: small;" data-initial=""></figure>
                                            </div>
                                            <div class="text-sm-left text-muted" style="float:left; padding-left: 10px;">
                                                {{$asset->asset_id}}
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                <div class="col-md-3" >
                    <div class="card status_title">
                        <h5 class="status_name">COPY REVIEW</h5>
                    </div>
                    @foreach ($asset_list_copy_review as $asset)

                        <?php
                        $start_css = 'color:#98a6ad;';
                        $start_late_css = "color:#a50018;";
                        if($asset->asset_type == 'email_blast'){
                            $start_date = date('m/d/Y', strtotime($asset->due . ' -21 weekday'));
                            if(strtotime($start_date) <= strtotime(date('m/d/Y')) ){
                                $start_css = $start_late_css;
                            }
                        }else if($asset->asset_type == 'website_banners'){
                            $start_date = date('m/d/Y', strtotime($asset->due . ' -22 weekday'));
                            if(strtotime($start_date) <= strtotime(date('m/d/Y')) ){
                                $start_css = $start_late_css;
                            }
                        }else if($asset->asset_type == 'social_ad'){
                            $start_date = date('m/d/Y', strtotime($asset->due . ' -21 weekday'));
                            if(strtotime($start_date) <= strtotime(date('m/d/Y')) ){
                                $start_css = $start_late_css;
                            }
                        }else if($asset->asset_type == 'landing_page'){
                            $start_date = date('m/d/Y', strtotime($asset->due . ' -33 weekday'));
                            if(strtotime($start_date) <= strtotime(date('m/d/Y')) ){
                                $start_css = $start_late_css;
                            }
                        }else if($asset->asset_type == 'topcategories_copy'){
                            $start_date =  date('m/d/Y', strtotime($asset->due . ' -3 weekday'));
                            if(strtotime($start_date) <= strtotime(date('m/d/Y')) ){
                                $start_css = $start_late_css;
                            }
                        }else if($asset->asset_type == 'a_content'){
                            $start_date = date('m/d/Y', strtotime($asset->due . ' -32 weekday'));
                            if(strtotime($start_date) <= strtotime(date('m/d/Y')) ){
                                $start_css = $start_late_css;
                            }
                        }else if($asset->asset_type == 'programmatic_banners'){
                            $start_date = date('m/d/Y', strtotime($asset->due . ' -24 weekday'));
                            if(strtotime($start_date) <= strtotime(date('m/d/Y')) ){
                                $start_css = $start_late_css;
                            }
                        }else if($asset->asset_type == 'misc'){
                            $start_date = date('m/d/Y', strtotime($asset->due . ' -20 weekday'));
                            if(strtotime($start_date) <= strtotime(date('m/d/Y')) ){
                                $start_css = $start_late_css;
                            }
                        }else{
                            $start_date = 'N/A';
                        }
                        ?>

                        <div class="card">
                            <a href="{{ url('admin/campaign/'. $asset->campaign_id .'/edit#'.$asset->asset_id)}}" style="text-decoration: none;">
                                <div class="card-body" style="margin: 0px -5px -20px -5px;">
                                    <div class="media" style="padding-bottom: 0px;">
                                        <div class="form-group" style="width: 100%;">

                                            <div style="color: #8b8a8a; font-weight: 600; float:left; font-size: 13px;">
                                                {{$asset->campaign_name}}
                                            </div>
                                            <div style="float: right;">
                                                <figure class="avatar mr-2 avatar-sm text-white"
                                                        style="background-color: #848484; font-size: 15px; margin-left: -15px; z-index: 1; border: 1px solid white;"
                                                        data-toggle="tooltip" data-placement="top"
                                                        data-original-title="{{ $asset->copy_writer }}"
                                                        data-initial="{{ substr($asset->copy_writer, 0, 1) }}">
                                                </figure>
                                            </div>
                                            <div style="float: right;">
                                                <figure class="avatar mr-2 avatar-sm text-white" style="background-color: #b6b6b6; font-size: 15px;"
                                                        data-toggle="tooltip" data-placement="top"
                                                        data-original-title="{{ $asset->author_name }}"
                                                        data-initial="{{ substr($asset->author_name, 0, 1) }}">
                                                </figure>
                                            </div>
                                            <div class="media-title" style="clear:both; font-size: large;">
                                                {{ ucwords(str_replace('_', ' ', $asset->asset_type)) }}
                                            </div>
                                            <div class="text-md-left text-muted" style="margin-top: -8px;">
                                                {{ mb_strimwidth($asset->name, 0,50, '...') }}
                                            </div>
                                            <hr style="border-width: 1px 0px 0px 0px;border-style:solid;border-color: #e0e0e0;
                                                            height:1px;margin-top: 15px;margin-bottom: 10px;width:100%">
                                            <?php if($asset->team_to == 'content') {
                                                $bg_type = '#9f76c2';
                                            }else if($asset->team_to == 'web production'){
                                                $bg_type = '#017cc2';
                                            }else{
                                                $bg_type = '#03b06d';
                                            }
                                            ?>
                                            <div class="text-sm-left text-muted" style="float:left; margin-top: -1px;">
                                                <figure class="avatar sm-2 text-white" style="width: 15px; height: 15px; background-color: {{$bg_type}}; font-size: small;" data-initial=""></figure>
                                            </div>
                                            <div class="text-sm-left text-muted" style="float:left; padding-left: 10px;">
                                                {{$asset->asset_id}}
                                            </div>
                                            <div style="float: right;" >
                                                {{ $start_date }}
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

@endsection
