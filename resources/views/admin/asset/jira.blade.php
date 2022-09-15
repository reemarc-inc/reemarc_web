@extends('layouts.dashboard')

@section('content')

    <section class="section">
        <div class="section-header">
            <h1>Asset Status Board (Creative)</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Asset Status Board (Creative)</div>
            </div>
        </div>

        <div class="section-body">

            @include('admin.asset.jira_filter')
            @include('admin.asset.flash')

            <div class="row">

                <div class="col-lg-3">
                    <h2 class="section-title">To Do</h2>
                        @foreach ($asset_list_todo as $asset)

                        <?php
                        $start_css = '';
                        $start_late_css = "style=background-color:#f1d2d2;";
                        if($asset->asset_type == 'email_blast'){
                            $start_date = date('m/d/Y', strtotime($asset->due . ' -10 weekday'));
                            if($start_date <= date('m/d/Y') ){
                                $start_css = $start_late_css;
                            }
                        }else if($asset->asset_type == 'website_banners'){
                            $start_date = date('m/d/Y', strtotime($asset->due . ' -11 weekday'));
                            if($start_date <= date('m/d/Y') ){
                                $start_css = $start_late_css;
                            }
                        }else if($asset->asset_type == 'social_ad'){
                            $start_date = date('m/d/Y', strtotime($asset->due . ' -10 weekday'));
                            if($start_date <= date('m/d/Y') ){
                                $start_css = $start_late_css;
                            }
                        }else if($asset->asset_type == 'landing_page'){
                            $start_date = date('m/d/Y', strtotime($asset->due . ' -21 weekday'));
                            if($start_date <= date('m/d/Y') ){
                                $start_css = $start_late_css;
                            }
                        }else if($asset->asset_type == 'misc'){
                            $start_date =  date('m/d/Y', strtotime($asset->due . ' -9 weekday'));
                            if($start_date <= date('m/d/Y') ){
                                $start_css = $start_late_css;
                            }
                        }else if($asset->asset_type == 'a_content'){
                            $start_date = date('m/d/Y', strtotime($asset->due . ' -21 weekday'));
                            if($start_date <= date('m/d/Y') ){
                                $start_css = $start_late_css;
                            }
                        }else if ($asset->asset_type == 'programmatic_banners'){
                            $start_date = date('m/d/Y', strtotime($asset->due . ' -13 weekday'));
                            if($start_date <= date('m/d/Y') ){
                                $start_css = $start_late_css;
                            }
                        }else if ($asset->asset_type == 'image_requested'){
                            $start_date = date('m/d/Y', strtotime($asset->due . ' -7 weekday'));
                            if($start_date <= date('m/d/Y') ){
                                $start_css = $start_late_css;
                            }
                        }else if ($asset->asset_type == 'roll_over'){
                            $start_date = date('m/d/Y', strtotime($asset->due . ' -8 weekday'));
                            if($start_date <= date('m/d/Y') ){
                                $start_css = $start_late_css;
                            }
                        }else if ($asset->asset_type == 'store_front'){
                            $start_date = date('m/d/Y', strtotime($asset->due . ' -21 weekday'));
                            if($start_date <= date('m/d/Y') ){
                                $start_css = $start_late_css;
                            }
                        }else{
                            $start_date = 'N/A';
                        }
                        ?>

                            <div class="card" {{ $start_css }}>
                                <div class="card-body">
                                    <div class="media" style="padding-bottom: 0px;">
                                        <div class="form-group" style="width: 100%">
                                            <div class="media-right" >{{$asset->campaign_name}}</div>
                                            <div class="media-title mb-1">
                                            <a href="">
                                                {{$asset->assignee}}
                                            </a>
                                            </div>
                                            <a href="{{ url('admin/campaign/'. $asset->campaign_id .'/edit#'.$asset->asset_id)}}" style="text-decoration: none;">
                                                <div class="text-time">{{ date('m/d/Y', strtotime($asset->due))}}</div>
                                                <div class="media-description text-muted">{{$asset->name}}</div>
                                                <div class="media-links">
                                                    {{ ucwords(str_replace('_', ' ', $asset->asset_type))}} ({{$asset->asset_id}})
                                                    <div class="bullet"></div>
                                                    <figure class="avatar mr-2 avatar-sm text-white" style="background-color: #fc544b" data-initial="{{$asset->campaign_id}}"></figure>
                                                    <div class="bullet"></div>
                                                    {{ $start_date }}
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                </div>

                <div class="col-lg-3">
                    <h2 class="section-title">In Progress</h2>
                    @foreach ($asset_list_progress as $asset)
                        <div class="card">
                            <a href="{{ url('admin/campaign/'. $asset->campaign_id .'/edit#'.$asset->asset_id)}}" style="text-decoration: none;">
                                <div class="card-body">
                                    <div class="media" style="padding-bottom: 0px;">
                                        <div class="form-group" style="width: 100%">
                                            <div class="media-right" >{{$asset->campaign_name}}</div>
                                            <div class="media-title mb-1">{{$asset->assignee}}</div>
                                            <div class="text-time">{{ date('m/d/Y', strtotime($asset->due))}}</div>
                                            <div class="media-description text-muted">{{$asset->name}}</div>
                                            <div class="media-links">
                                                {{ ucwords(str_replace('_', ' ', $asset->asset_type))}} ({{$asset->asset_id}})
                                                <div class="bullet"></div>
                                                <figure class="avatar mr-2 avatar-sm text-white" style="background-color: #66874e" data-initial="{{$asset->campaign_id}}"></figure>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                <div class="col-lg-3">
                    <h2 class="section-title">Done (Waiting Final Approval)</h2>
                    @foreach ($asset_list_done as $asset)
                        <div class="card">
                            <a href="{{ url('admin/campaign/'. $asset->campaign_id .'/edit#'.$asset->asset_id)}}" style="text-decoration: none;">
                                <div class="card-body">
                                    <div class="media" style="padding-bottom: 0px;">
                                        <div class="form-group" style="width: 100%">
                                            <div class="media-right" >{{$asset->campaign_name}}</div>
                                            <div class="media-title mb-1">{{$asset->assignee}}</div>
                                            <div class="text-time">{{ date('m/d/Y', strtotime($asset->due))}}</div>
                                            <div class="media-description text-muted">{{$asset->name}}</div>
                                            <div class="media-links">
                                                {{ ucwords(str_replace('_', ' ', $asset->asset_type))}} ({{$asset->asset_id}})
                                                <div class="bullet"></div>
                                                <figure class="avatar mr-2 avatar-sm text-white" style="background-color: #3392af" data-initial="{{$asset->campaign_id}}"></figure>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                <div class="col-lg-3">
                    <h2 class="section-title">Final Approved (Within a Week)</h2>
                    @foreach ($asset_list_finish as $asset)
                        <div class="card">
                            <a href="{{ url('admin/campaign/'. $asset->campaign_id .'/edit#'.$asset->asset_id)}}" style="text-decoration: none;">
                                <div class="card-body">
                                    <div class="media" style="padding-bottom: 0px;">
                                        <div class="form-group" style="width: 100%">
                                            <div class="media-right" >{{$asset->campaign_name}}</div>
                                            <div class="media-title mb-1">{{$asset->assignee}}</div>
                                            <div class="text-time">{{ date('m/d/Y', strtotime($asset->due))}}</div>
                                            <div class="media-description text-muted">{{$asset->name}}</div>
                                            <div class="media-links">
                                                {{ ucwords(str_replace('_', ' ', $asset->asset_type))}} ({{$asset->asset_id}})
                                                <div class="bullet"></div>
                                                <figure class="avatar mr-2 avatar-sm text-white" style="background-color: #050a61" data-initial="{{$asset->campaign_id}}"></figure>
                                            </div>
                                            <div class="media-links">
                                                Approved
                                                <div class="bullet"></div>
                                                {{ date('m/d/Y h:i:s', strtotime($asset->updated_at)) }}
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
