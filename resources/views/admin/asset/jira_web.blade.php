@extends('layouts.dashboard')

@section('content')

    <section class="section">
        <div class="section-header">
            <h1>Asset Status Board (Web)</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Asset Status Board (Web)</div>
            </div>
        </div>

        <div class="section-body">

            @include('admin.asset.jira_web_filter')
            @include('admin.asset.flash')

            <div class="row">

                <div class="col-lg-3">
                    <h2 class="section-title">To Do</h2>
                        @foreach ($asset_list_todo as $asset)

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
                        }else if($asset->asset_type == 'misc'){
                            $start_date =  date('m/d/Y', strtotime($asset->due . ' -16 weekday'));
                            if(strtotime($start_date) <= strtotime(date('m/d/Y')) ){
                                $start_css = $start_late_css;
                            }
                        }else if($asset->asset_type == 'a_content'){
                            $start_date = date('m/d/Y', strtotime($asset->due . ' -28 weekday'));
                            if(strtotime($start_date) <= strtotime(date('m/d/Y')) ){
                                $start_css = $start_late_css;
                            }
                        }else if ($asset->asset_type == 'programmatic_banners'){
                            $start_date = date('m/d/Y', strtotime($asset->due . ' -20 weekday'));
                            if(strtotime($start_date) <= strtotime(date('m/d/Y')) ){
                                $start_css = $start_late_css;
                            }
                        }else if ($asset->asset_type == 'image_request'){
                            $start_date = date('m/d/Y', strtotime($asset->due . ' -9 weekday'));
                            if(strtotime($start_date) <= strtotime(date('m/d/Y')) ){
                                $start_css = $start_late_css;
                            }
                        }else if ($asset->asset_type == 'roll_over'){
                            $start_date = date('m/d/Y', strtotime($asset->due . ' -10 weekday'));
                            if(strtotime($start_date) <= strtotime(date('m/d/Y')) ){
                                $start_css = $start_late_css;
                            }
                        }else if ($asset->asset_type == 'store_front'){
                            $start_date = date('m/d/Y', strtotime($asset->due . ' -28 weekday'));
                            if(strtotime($start_date) <= strtotime(date('m/d/Y')) ){
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
                                                {{$asset->author_name}}
                                            </a>
                                            </div>
                                            <a href="{{ url('admin/campaign/'. $asset->campaign_id .'/edit#'.$asset->asset_id)}}" style="text-decoration: none;">
                                                <div class="text-time">{{ $start_date }}
                                                    <span style="color:#ffffff; font-size: small;background-color: #314190FF;border-radius: 8px; float: right;">
                                                       &nbsp {{ $asset->assignee }} &nbsp
                                                    </span>
                                                </div>
                                                <div class="media-description text-muted">{{ mb_strimwidth($asset->name, 0,50, '...') }}</div>
                                                <div class="media-links">
                                                    <figure class="avatar mr-2 avatar-sm text-white" style="background-color: #fc544b" data-initial="{{$asset->asset_id}}"></figure>
                                                    <div class="bullet"></div>
                                                    {{ ucwords(str_replace('_', ' ', $asset->asset_type))}}
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
                                            <div class="media-title mb-1">{{$asset->author_name}}</div>
                                            <div class="text-time">&nbsp
                                                <span style="color:#ffffff; font-size: small;background-color: #314190FF;border-radius: 8px; float: right;">
                                                   &nbsp {{ $asset->assignee }} &nbsp
                                                </span>
                                            </div>
                                            <div class="media-description text-muted">{{ mb_strimwidth($asset->name, 0,50, '...') }}</div>
                                            <div class="media-links">
                                                <figure class="avatar mr-2 avatar-sm text-white" style="background-color: #66874e" data-initial="{{$asset->asset_id}}"></figure>
                                                <div class="bullet"></div>
                                                {{ ucwords(str_replace('_', ' ', $asset->asset_type))}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                <div class="col-lg-3">
                    <h2 class="section-title">Creative Review</h2>
                    @foreach ($asset_list_done as $asset)
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
                                <div class="card-body">
                                    <div class="media" style="padding-bottom: 0px;">
                                        <div class="form-group" style="width: 100%">
                                            <div class="media-right" >{{$asset->campaign_name}}</div>
                                            <div class="media-title mb-1">{{$asset->author_name}}</div>
                                            <div class="text-time">{{ $start_date }}
                                                <span style="color:#ffffff; font-size: small;background-color: #314190FF;border-radius: 8px; float: right;">
                                                   &nbsp {{ $asset->assignee }} &nbsp
                                                </span>
                                            </div>
                                            <div class="media-description text-muted">{{ mb_strimwidth($asset->name, 0,50, '...') }}</div>
                                            <div class="media-links">
                                                <figure class="avatar mr-2 avatar-sm text-white" style="background-color: #3392af" data-initial="{{$asset->asset_id}}"></figure>
                                                <div class="bullet"></div>
                                                {{ ucwords(str_replace('_', ' ', $asset->asset_type))}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                <div class="col-lg-3">
                    <h2 class="section-title">Asset Completed (Within a Week)</h2>
                    @foreach ($asset_list_finish as $asset)
                        <div class="card">
                            <a href="{{ url('admin/campaign/'. $asset->campaign_id .'/edit#'.$asset->asset_id)}}" style="text-decoration: none;">
                                <div class="card-body">
                                    <div class="media" style="padding-bottom: 0px;">
                                        <div class="form-group" style="width: 100%">
                                            <div class="media-right" >{{$asset->campaign_name}}</div>
                                            <div class="media-title mb-1">{{$asset->author_name}}</div>
                                            <div class="text-time">{{ date('m/d/Y', strtotime($asset->due))}}
                                                <span style="color:#ffffff; font-size: small;background-color: #314190FF;border-radius: 8px; float: right;">
                                                   &nbsp {{ $asset->assignee }} &nbsp
                                                </span>
                                            </div>
                                            <div class="media-description text-muted">{{ mb_strimwidth($asset->name, 0,50, '...') }}</div>
                                            <div class="media-links">
                                                <figure class="avatar mr-2 avatar-sm text-white" style="background-color: #050a61" data-initial="{{$asset->asset_id}}"></figure>
                                                <div class="bullet"></div>
                                                {{ ucwords(str_replace('_', ' ', $asset->asset_type))}}
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
