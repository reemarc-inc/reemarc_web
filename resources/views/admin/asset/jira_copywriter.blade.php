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

            <div class="row">

                <div class="col-lg-6">
                    <h2 class="section-title">Copy Request</h2>
                        @foreach ($asset_list_copy_request as $asset)

                        <?php
                            $start_css = '';
//                            $start_late_css = "style=background-color:#f1d2d2;";

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
                                $start_date =  date('m/d/Y', strtotime($asset->due . ' -6 weekday'));
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

                            <div class="card" {{ $start_css }}>
                                <a href="{{ url('admin/campaign/'. $asset->campaign_id .'/edit#'.$asset->asset_id)}}" style="text-decoration: none;">
                                    <div class="card-body" style="padding-top: 7px; padding-bottom: 0px;">
                                        <div class="media" style="padding-bottom: 0px;">
                                            <div class="form-group" style="width: 100%">
                                                <div class="media-right" >{{$asset->campaign_name}}</div>
                                                <div class="media-title mb-1" style="font-size: 25px;">
                                                    <small>Assigned To :</small>
                                                    <b>{{ App\Http\Controllers\admin\AssetController::get_writers_by_brand($asset->campaign_name) }}</b>
                                                </div>
                                                <div class="text-time">Asset Launch Date : {{ date('m/d/Y', strtotime($asset->due))}}</div>
                                                <div class="media-description text-muted">{{$asset->name}}</div>
                                                <div class="media-links">
                                                    {{ ucwords(str_replace('_', ' ', $asset->asset_type))}} ({{$asset->asset_id}})
                                                    <div class="bullet"></div>
                                                    <figure class="avatar mr-2 avatar-sm text-white" style="background-color: #eacc34" data-initial="{{$asset->campaign_id}}"></figure>
                                                    <div class="bullet"></div>
                                                    Copy Writer Start Day : {{ $start_date }}
                                                    <label style="font-size: 25px;">
                                                        <?php
                                                            if($start_css != '') {
                                                        ?>
                                                            <div class="bullet"></div>
                                                                Past Due Date
                                                        <?php    } ?>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                </div>

                <div class="col-lg-6">
                    <h2 class="section-title">Brands Assigned</h2>
                    @foreach ($brands_assigned_copywriters as $copywriter)
                        <div class="card">
                            <div class="card-body">
                                <div class="media" style="padding-bottom: 0px;">
                                    <div class="form-group" style="width: 100%">
                                        <div class="media-title mb-1">{{$copywriter->first_name}} {{$copywriter->last_name}}</div>
                                        <div class="media-description text-muted">{{$copywriter->user_brand}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>

        <style>
            .blink-bg{
                color: #fff;
                animation: blinkingBackground 2s infinite;
            }
            @keyframes blinkingBackground{
                50%		{ background-color: #dc2431;}
                100%	        { background-color: #efdb1f;}
            }
        </style>


@endsection
