@extends('layouts.dashboard')

@section('content')

    <section class="section">
        <div class="section-header">
            <h1>Status Board (Digital Ops)</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Status Board (Digital Ops)</div>
            </div>
        </div>

        <div class="section-body">

            @include('admin.asset.jira_kec_filter')
            @include('admin.asset.flash')

            <div class="row" style="margin-right: -100px;">

                <div class="col-lg-2" style="flex: 0 0 13.555%; max-width: 13.555%;">
                    <h2 class="section-title">Copy Request</h2>
                        @foreach ($asset_list_copy_request as $asset)

                        <?php
                            $start_css = '';
                            $start_late_css = "style=background-color:#f1d2d2;";
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
                            <div class="card" {{ $start_css }}>
                                <a href="{{ url('admin/campaign/'. $asset->campaign_id .'/edit#'.$asset->asset_id)}}" style="text-decoration: none;">
                                    <div class="card-body" style="padding-left: 10px; padding-right: 10px; margin-bottom: -25px;">
                                        <div class="media" style="padding-bottom: 0px;">
                                            <div class="form-group" style="width: 100%">
                                                <div class="text-lg-center media-title" style="margin-top: -30px;">
                                                    <span style="color:#ffffff; font-size: small;background-color: #933434;border-radius: 8px;">
                                                       &nbsp {{ $asset->author_name }} &nbsp
                                                    </span>
                                                </div>
                                                <div class="text-lg-center" style="color: #a50018; font-weight: 600; font-size: 16px; align-items: center;">
                                                    {{$asset->campaign_name}}
                                                </div>
                                                <div class="text-lg-center" style="font-size: 13px; color: #1a1a1a; font-weight: 700;">
                                                    {{ $start_date }}
                                                </div>
                                                <div class="media-description">{{ mb_strimwidth($asset->name, 0,50, '...') }}</div>
                                                <div class="media-links">
                                                    <figure class="avatar mr-2 avatar-sm text-white" style="width: 35px;background-color: #eacc34; font-size: small;" data-initial="{{$asset->asset_id}}">
                                                        <?php if($asset->team_to == 'content') {
                                                            $bg_type = '#018d1d';
                                                        }else if($asset->team_to == 'web production'){
                                                            $bg_type = '#013d9e';
                                                        }else{
                                                            $bg_type = '#a50018';
                                                        }
                                                            ?>
                                                        <i class="avatar-presence" style="background: {{$bg_type}}"></i>
                                                    </figure>
                                                    {{ ucwords(str_replace('_', ' ', $asset->asset_type))}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                </div>

                <div class="col-lg-2" style="flex: 0 0 13.555%; max-width: 13.555%;">
                    <h2 class="section-title">Copy Review</h2>
                    @foreach ($asset_list_copy_review as $asset)

                        <?php
                        $start_css = '';
                        $start_late_css = "style=background-color:#f1d2d2;";
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

                        <div class="card" {{ $start_css }}>
                            <a href="{{ url('admin/campaign/'. $asset->campaign_id .'/edit#'.$asset->asset_id)}}" style="text-decoration: none;">
                                <div class="card-body" style="padding-left: 10px; padding-right: 10px; margin-bottom: -25px;">
                                    <div class="media" style="padding-bottom: 0px;">
                                        <div class="form-group" style="width: 100%">
                                            <div class="text-lg-center media-title" style="margin-top: -30px;">
                                                    <span style="color:#ffffff; font-size: small;background-color: #933434;border-radius: 8px;">
                                                       &nbsp {{ $asset->author_name }} &nbsp
                                                    </span>
                                            </div>
                                            <div class="text-lg-center" style="color: #a50018; font-weight: 600; font-size: 16px; align-items: center;">{{$asset->campaign_name}}</div>
                                            <div class="text-lg-center" style="font-size: 13px; color: #1a1a1a; font-weight: 700;">{{ $start_date }}</div>
                                            <div class="media-description">{{ mb_strimwidth($asset->name, 0,50, '...') }}</div>
                                            <div class="media-links">
                                                <figure class="avatar mr-2 avatar-sm text-white" style="width: 35px;background-color: lightsalmon; font-size: small;" data-initial="{{$asset->asset_id}}">
                                                    <?php if($asset->team_to == 'content') {
                                                        $bg_type = '#018d1d';
                                                    }else if($asset->team_to == 'web production'){
                                                        $bg_type = '#013d9e';
                                                    }else{
                                                        $bg_type = '#a50018';
                                                    }
                                                    ?>
                                                    <i class="avatar-presence" style="background: {{$bg_type}}"></i>
                                                </figure>
                                                {{ ucwords(str_replace('_', ' ', $asset->asset_type))}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                <div class="col-lg-2" style="flex: 0 0 13.555%; max-width: 13.555%;">
                    <h2 class="section-title">Creative Assign</h2>
                    @foreach ($asset_list_copy_complete as $asset)
                        <?php
                        $start_css = '';
                        $start_late_css = "style=background-color:#f1d2d2;";
                        if($asset->asset_type == 'email_blast'){
                            $start_date = date('m/d/Y', strtotime($asset->due . ' -19 weekday'));
                            if(strtotime($start_date) <= strtotime(date('m/d/Y')) ){
                                $start_css = $start_late_css;
                            }
                        }else if($asset->asset_type == 'website_banners'){
                            $start_date = date('m/d/Y', strtotime($asset->due . ' -20 weekday'));
                            if(strtotime($start_date) <= strtotime(date('m/d/Y')) ){
                                $start_css = $start_late_css;
                            }
                        }else if($asset->asset_type == 'social_ad'){
                            $start_date = date('m/d/Y', strtotime($asset->due . ' -19 weekday'));
                            if(strtotime($start_date) <= strtotime(date('m/d/Y')) ){
                                $start_css = $start_late_css;
                            }
                        }else if($asset->asset_type == 'landing_page'){
                            $start_date = date('m/d/Y', strtotime($asset->due . ' -30 weekday'));
                            if(strtotime($start_date) <= strtotime(date('m/d/Y')) ){
                                $start_css = $start_late_css;
                            }
                        }else if($asset->asset_type == 'topcategories_copy'){
                            $start_date =  date('m/d/Y', strtotime($asset->due . ' -1 weekday'));
                            if(strtotime($start_date) <= strtotime(date('m/d/Y')) ){
                                $start_css = $start_late_css;
                            }
                        }else if($asset->asset_type == 'a_content'){
                            $start_date = date('m/d/Y', strtotime($asset->due . ' -30 weekday'));
                            if(strtotime($start_date) <= strtotime(date('m/d/Y')) ){
                                $start_css = $start_late_css;
                            }
                        }else if($asset->asset_type == 'programmatic_banners'){
                            $start_date = date('m/d/Y', strtotime($asset->due . ' -22 weekday'));
                            if(strtotime($start_date) <= strtotime(date('m/d/Y')) ){
                                $start_css = $start_late_css;
                            }
                        }else if($asset->asset_type == 'misc'){
                            $start_date = date('m/d/Y', strtotime($asset->due . ' -18 weekday'));
                            if(strtotime($start_date) <= strtotime(date('m/d/Y')) ){
                                $start_css = $start_late_css;
                            }
                        }else if($asset->asset_type == 'image_request'){
                            $start_date = date('m/d/Y', strtotime($asset->due . ' -11 weekday'));
                            if(strtotime($start_date) <= strtotime(date('m/d/Y')) ){
                                $start_css = $start_late_css;
                            }
                        }else if($asset->asset_type == 'roll_over'){
                            $start_date = date('m/d/Y', strtotime($asset->due . ' -12 weekday'));
                            if(strtotime($start_date) <= strtotime(date('m/d/Y')) ){
                                $start_css = $start_late_css;
                            }
                        }else if($asset->asset_type == 'store_front'){
                            $start_date = date('m/d/Y', strtotime($asset->due . ' -30 weekday'));
                            if(strtotime($start_date) <= strtotime(date('m/d/Y')) ){
                                $start_css = $start_late_css;
                            }
                        }else{
                            $start_date = 'N/A';
                        }
                        ?>
                        <div class="card" {{ $start_css }}>
                            <a href="{{ url('admin/campaign/'. $asset->campaign_id .'/edit#'.$asset->asset_id)}}" style="text-decoration: none;">
                                <div class="card-body" style="padding-left: 10px; padding-right: 10px; margin-bottom: -25px;">
                                    <div class="media" style="padding-bottom: 0px;">
                                        <div class="form-group" style="width: 100%">
                                            <div class="text-lg-center media-title" style="margin-top: -30px;">
                                                    <span style="color:#ffffff; font-size: small;background-color: #933434;border-radius: 8px;">
                                                       &nbsp {{ $asset->author_name }} &nbsp
                                                    </span>
                                            </div>
                                            <div class="text-lg-center" style="color: #a50018; font-weight: 600; font-size: 16px; align-items: center;">{{$asset->campaign_name}}</div>
                                            <div class="text-lg-center" style="font-size: 13px; color: #1a1a1a; font-weight: 700;">{{ $start_date }}</div>
                                            <div class="media-description">{{ mb_strimwidth($asset->name, 0,50, '...') }}</div>
                                            <div class="media-links">
                                                <figure class="avatar mr-2 avatar-sm text-white" style="width: 35px;background-color: #ea3c75; font-size: small;" data-initial="{{$asset->asset_id}}">
                                                    <?php if($asset->team_to == 'content') {
                                                        $bg_type = '#018d1d';
                                                    }else if($asset->team_to == 'web production'){
                                                        $bg_type = '#013d9e';
                                                    }else{
                                                        $bg_type = '#a50018';
                                                    }
                                                    ?>
                                                    <i class="avatar-presence" style="background: {{$bg_type}}"></i>
                                                </figure>
                                                {{ ucwords(str_replace('_', ' ', $asset->asset_type))}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                <div class="col-lg-2" style="flex: 0 0 13.555%; max-width: 13.555%;">
                    <h2 class="section-title">To Do</h2>
                    @foreach ($asset_list_to_do as $asset)
                        <?php
                        $start_css = '';
                        $start_late_css = "style=background-color:#f1d2d2;";
                        if($asset->asset_type == 'email_blast'){
                            $start_date = date('m/d/Y', strtotime($asset->due . ' -17 weekday'));
                            if(strtotime($start_date) <= strtotime(date('m/d/Y')) ){
                                $start_css = $start_late_css;
                            }
                        }else if($asset->asset_type == 'website_banners'){
                            $start_date = date('m/d/Y', strtotime($asset->due . ' -18 weekday'));
                            if(strtotime($start_date) <= strtotime(date('m/d/Y')) ){
                                $start_css = $start_late_css;
                            }
                        }else if($asset->asset_type == 'social_ad'){
                            $start_date = date('m/d/Y', strtotime($asset->due . ' -17 weekday'));
                            if(strtotime($start_date) <= strtotime(date('m/d/Y')) ){
                                $start_css = $start_late_css;
                            }
                        }else if($asset->asset_type == 'landing_page'){
                            $start_date = date('m/d/Y', strtotime($asset->due . ' -28 weekday'));
                            if(strtotime($start_date) <= strtotime(date('m/d/Y')) ){
                                $start_css = $start_late_css;
                            }
                        }else if($asset->asset_type == 'a_content'){
                            $start_date = date('m/d/Y', strtotime($asset->due . ' -28 weekday'));
                            if(strtotime($start_date) <= strtotime(date('m/d/Y')) ){
                                $start_css = $start_late_css;
                            }
                        }else if($asset->asset_type == 'programmatic_banners'){
                            $start_date = date('m/d/Y', strtotime($asset->due . ' -20 weekday'));
                            if(strtotime($start_date) <= strtotime(date('m/d/Y')) ){
                                $start_css = $start_late_css;
                            }
                        }else if($asset->asset_type == 'misc'){
                            $start_date = date('m/d/Y', strtotime($asset->due . ' -16 weekday'));
                            if(strtotime($start_date) <= strtotime(date('m/d/Y')) ){
                                $start_css = $start_late_css;
                            }
                        }else if($asset->asset_type == 'image_request'){
                            $start_date = date('m/d/Y', strtotime($asset->due . ' -9 weekday'));
                            if(strtotime($start_date) <= strtotime(date('m/d/Y')) ){
                                $start_css = $start_late_css;
                            }
                        }else if($asset->asset_type == 'roll_over'){
                            $start_date = date('m/d/Y', strtotime($asset->due . ' -10 weekday'));
                            if(strtotime($start_date) <= strtotime(date('m/d/Y')) ){
                                $start_css = $start_late_css;
                            }
                        }else if($asset->asset_type == 'store_front'){
                            $start_date = date('m/d/Y', strtotime($asset->due . ' -28 weekday'));
                            if(strtotime($start_date) <= strtotime(date('m/d/Y')) ){
                                $start_css = $start_late_css;
                            }
                        }else{
                            $start_date = 'N/A';
                        }
                        ?>
                        <div class="card" {{ $start_css }}>
                            <a href="{{ url('admin/campaign/'. $asset->campaign_id .'/edit#'.$asset->asset_id)}}" style="text-decoration: none;">
                                <div class="card-body" style="padding-left: 10px; padding-right: 10px; margin-bottom: -25px;">
                                    <div class="media" style="padding-bottom: 0px;">
                                        <div class="form-group" style="width: 100%">
                                            <div class="text-lg-center media-title" style="margin-top: -30px;">
                                                    <span style="color:#ffffff; font-size: small; background-color: #933434;border-radius: 8px;">
                                                       &nbsp {{ $asset->author_name }} &nbsp
                                                    </span>
                                            </div>
                                            <div class="text-lg-center" style="color: #a50018; font-weight: 600; font-size: 16px; align-items: center;">{{$asset->campaign_name}}</div>
                                            <div class="text-lg-center" style="font-size: 13px; color: #1a1a1a; font-weight: 700;">{{ $start_date }}</div>
                                            <div class="media-description">{{ mb_strimwidth($asset->name, 0,50, '...') }}</div>
                                            <div class="media-links">
                                                <figure class="avatar mr-2 avatar-sm text-white" style="width: 35px;background-color: #a50018; font-size: small;" data-initial="{{$asset->asset_id}}">
                                                    <?php if($asset->team_to == 'content') {
                                                        $bg_type = '#018d1d';
                                                    }else if($asset->team_to == 'web production'){
                                                        $bg_type = '#013d9e';
                                                    }else{
                                                        $bg_type = '#a50018';
                                                    }
                                                    ?>
                                                    <i class="avatar-presence" style="background: {{$bg_type}}"></i>
                                                </figure>
                                                {{ ucwords(str_replace('_', ' ', $asset->asset_type))}}
                                            </div>
                                            <div class="text-lg-center">
                                                <span style="color:#ffffff; font-size: small; background-color: #314190FF;border-radius: 8px;">
                                                   &nbsp {{ $asset->assignee }} &nbsp
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                <div class="col-lg-2" style="flex: 0 0 13.555%; max-width: 13.555%;">
                    <h2 class="section-title">In Progress</h2>
                    @foreach ($asset_list_in_progress as $asset)

                        <div class="card">
                            <a href="{{ url('admin/campaign/'. $asset->campaign_id .'/edit#'.$asset->asset_id)}}" style="text-decoration: none;">
                                <div class="card-body" style="padding-left: 10px; padding-right: 10px; margin-bottom: -25px;">
                                    <div class="media" style="padding-bottom: 0px;">
                                        <div class="form-group" style="width: 100%">

                                            <div class="text-lg-center media-title" style="margin-top: -30px;">
                                                    <span style="color:#ffffff; font-size: small; background-color: #933434;border-radius: 8px;">
                                                       &nbsp {{ $asset->author_name }} &nbsp
                                                    </span>
                                            </div>
                                            <div class="text-lg-center" style="color: #a50018; font-weight: 600; font-size: 16px; align-items: center;">{{$asset->campaign_name}}</div>
                                            <div class="media-description">{{ mb_strimwidth($asset->name, 0,50, '...') }}</div>
                                            <div class="media-links">
                                                <figure class="avatar mr-2 avatar-sm text-white" style="width: 35px;background-color: #66874e; font-size: small;" data-initial="{{$asset->asset_id}}">
                                                    <?php if($asset->team_to == 'content') {
                                                        $bg_type = '#018d1d';
                                                    }else if($asset->team_to == 'web production'){
                                                        $bg_type = '#013d9e';
                                                    }else{
                                                        $bg_type = '#a50018';
                                                    }
                                                    ?>
                                                    <i class="avatar-presence" style="background: {{$bg_type}}"></i>
                                                </figure>
                                                {{ ucwords(str_replace('_', ' ', $asset->asset_type))}}
                                            </div>
                                            <div class="text-lg-center">
                                                <span style="color:#ffffff; font-size: small; background-color: #314190FF;border-radius: 8px;">
                                                   &nbsp {{ $asset->assignee }} &nbsp
                                                </span>
                                            </div>

{{--                                            <div>{{$asset->campaign_name}}</div>--}}
{{--                                            <div class="media-title mb-1"></div>--}}
{{--                                            <div class="text-time">{{$asset->author_name}}--}}
{{--                                                <span style="color:#ffffff; font-size: small;background-color: #314190FF;border-radius: 8px; float: right;">--}}
{{--                                                   &nbsp {{ $asset->assignee }} &nbsp--}}
{{--                                                </span>--}}
{{--                                            </div>--}}
{{--                                            <div class="media-description text-muted">{{ mb_strimwidth($asset->name, 0,50, '...') }}</div>--}}
{{--                                            <div class="media-links">--}}
{{--                                                <figure class="avatar mr-2 avatar-sm text-white" style="background-color: #66874e" data-initial="{{$asset->asset_id}}"></figure>--}}
{{--                                                <div class="bullet"></div>--}}
{{--                                                {{ ucwords(str_replace('_', ' ', $asset->asset_type))}}--}}
{{--                                            </div>--}}
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                <div class="col-lg-2" style="flex: 0 0 13.555%; max-width: 13.555%;">
                    <h2 class="section-title">Creative Review</h2>
                    @foreach ($asset_list_waiting_final_approval as $asset)
                        <?php
                        $start_css = '';
                        $start_late_css = "style=background-color:#f1d2d2;";
                        if($asset->asset_type == 'email_blast'){
                            $start_date = date('m/d/Y', strtotime($asset->due . ' -10 weekday'));
                            if(strtotime($start_date) <= strtotime(date('m/d/Y')) ){
                                $start_css = $start_late_css;
                            }
                        }else if($asset->asset_type == 'website_banners'){
                            $start_date = date('m/d/Y', strtotime($asset->due . ' -11 weekday'));
                            if(strtotime($start_date) <= strtotime(date('m/d/Y')) ){
                                $start_css = $start_late_css;
                            }
                        }else if($asset->asset_type == 'social_ad'){
                            $start_date = date('m/d/Y', strtotime($asset->due . ' -10 weekday'));
                            if(strtotime($start_date) <= strtotime(date('m/d/Y')) ){
                                $start_css = $start_late_css;
                            }
                        }else if($asset->asset_type == 'landing_page'){
                            $start_date = date('m/d/Y', strtotime($asset->due . ' -18 weekday'));
                            if(strtotime($start_date) <= strtotime(date('m/d/Y')) ){
                                $start_css = $start_late_css;
                            }
                        }else if($asset->asset_type == 'a_content'){
                            $start_date = date('m/d/Y', strtotime($asset->due . ' -13 weekday'));
                            if(strtotime($start_date) <= strtotime(date('m/d/Y')) ){
                                $start_css = $start_late_css;
                            }
                        }else if($asset->asset_type == 'programmatic_banners'){
                            $start_date = date('m/d/Y', strtotime($asset->due . ' -10 weekday'));
                            if(strtotime($start_date) <= strtotime(date('m/d/Y')) ){
                                $start_css = $start_late_css;
                            }
                        }else if($asset->asset_type == 'misc'){
                            $start_date = date('m/d/Y', strtotime($asset->due . ' -9 weekday'));
                            if(strtotime($start_date) <= strtotime(date('m/d/Y')) ){
                                $start_css = $start_late_css;
                            }
                        }else if($asset->asset_type == 'image_request'){
                            $start_date = date('m/d/Y', strtotime($asset->due . ' -2 weekday'));
                            if(strtotime($start_date) <= strtotime(date('m/d/Y')) ){
                                $start_css = $start_late_css;
                            }
                        }else if($asset->asset_type == 'roll_over'){
                            $start_date = date('m/d/Y', strtotime($asset->due . ' -3 weekday'));
                            if(strtotime($start_date) <= strtotime(date('m/d/Y')) ){
                                $start_css = $start_late_css;
                            }
                        }else if($asset->asset_type == 'store_front'){
                            $start_date = date('m/d/Y', strtotime($asset->due . ' -13 weekday'));
                            if(strtotime($start_date) <= strtotime(date('m/d/Y')) ){
                                $start_css = $start_late_css;
                            }
                        }else{
                            $start_date = 'N/A';
                        }
                        ?>
                        <div class="card" {{ $start_css }}>
                            <a href="{{ url('admin/campaign/'. $asset->campaign_id .'/edit#'.$asset->asset_id)}}" style="text-decoration: none;">
                                <div class="card-body" style="padding-left: 10px; padding-right: 10px; margin-bottom: -25px;">
                                    <div class="media" style="padding-bottom: 0px;">
                                        <div class="form-group" style="width: 100%">
                                            <div class="text-lg-center media-title" style="margin-top: -30px;">
                                                    <span style="color:#ffffff; font-size: small; background-color: #933434;border-radius: 8px;">
                                                       &nbsp {{ $asset->author_name }} &nbsp
                                                    </span>
                                            </div>
                                            <div class="text-lg-center" style="color: #a50018; font-weight: 600; font-size: 16px; align-items: center;">{{$asset->campaign_name}}</div>
                                            <div class="text-lg-center" style="font-size: 13px; color: #1a1a1a; font-weight: 700;">{{ $start_date }}</div>
                                            <div class="media-description">{{ mb_strimwidth($asset->name, 0,50, '...') }}</div>
                                            <div class="media-links">
                                                <figure class="avatar mr-2 avatar-sm text-white" style="width: 35px;background-color: #3392af; font-size: small;" data-initial="{{$asset->asset_id}}">
                                                    <?php if($asset->team_to == 'content') {
                                                        $bg_type = '#018d1d';
                                                    }else if($asset->team_to == 'web production'){
                                                        $bg_type = '#013d9e';
                                                    }else{
                                                        $bg_type = '#a50018';
                                                    }
                                                    ?>
                                                    <i class="avatar-presence" style="background: {{$bg_type}}"></i>
                                                </figure>
                                                {{ ucwords(str_replace('_', ' ', $asset->asset_type))}}
                                            </div>
                                            <div class="text-lg-center">
                                                <span style="color:#ffffff; font-size: small; background-color: #314190FF;border-radius: 8px;">
                                                   &nbsp {{ $asset->assignee }} &nbsp
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                <div class="col-lg-2" style="flex: 0 0 13.555%; max-width: 13.555%;">
                    <h2 class="section-title">Asset Completed</h2>
                    @foreach ($asset_list_waiting_asset_completed as $asset)
                        <div class="card">
                            <a href="{{ url('admin/campaign/'. $asset->campaign_id .'/edit#'.$asset->asset_id)}}" style="text-decoration: none;">
                                <div class="card-body" style="padding-left: 10px; padding-right: 10px; margin-bottom: -25px;">
                                    <div class="media" style="padding-bottom: 0px;">
                                        <div class="form-group" style="width: 100%">
                                            <div class="text-lg-center media-title" style="margin-top: -30px;">
                                                    <span style="color:#ffffff; font-size: small; background-color: #933434;border-radius: 8px;">
                                                       &nbsp {{ $asset->author_name }} &nbsp
                                                    </span>
                                            </div>
                                            <div class="text-lg-center" style="color: #a50018; font-weight: 600; font-size: 16px; align-items: center;">{{$asset->campaign_name}}</div>
                                            <div class="text-lg-center" style="font-size: 13px; color: #1a1a1a; font-weight: 700;">{{ date('m/d/Y g:ia', strtotime($asset->updated_at)) }}</div>
                                            <div class="media-description">{{ mb_strimwidth($asset->name, 0,50, '...') }}</div>
                                            <div class="media-links">
                                                <figure class="avatar mr-2 avatar-sm text-white" style="width: 35px;background-color: #0f013b; font-size: small;" data-initial="{{$asset->asset_id}}">
                                                    <?php if($asset->team_to == 'content') {
                                                        $bg_type = '#018d1d';
                                                    }else if($asset->team_to == 'web production'){
                                                        $bg_type = '#013d9e';
                                                    }else{
                                                        $bg_type = '#a50018';
                                                    }
                                                    ?>
                                                    <i class="avatar-presence" style="background: {{$bg_type}}"></i>
                                                </figure>
                                                {{ ucwords(str_replace('_', ' ', $asset->asset_type))}}
                                            </div>
                                            <div class="text-lg-center">
                                                <span style="color:#ffffff; font-size: small; background-color: #314190FF;border-radius: 8px;">
                                                   &nbsp {{ $asset->assignee }} &nbsp
                                                </span>
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
