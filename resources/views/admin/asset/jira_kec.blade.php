@extends('layouts.dashboard')

@section('content')

    <section class="section">
        <div class="section-header">
            <h1>Status Board (Omnichannel)</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Status Board (Omnichannel)</div>
            </div>
        </div>

        <div class="section-body">

            @include('admin.asset.jira_kec_filter')
            @include('admin.asset.flash')

            <div class="row">

                <div class="col-lg-3">
                    <h2 class="section-title">Copy Request</h2>
                        @foreach ($asset_list_copy_request as $asset)

                        <?php
                            $start_css = '';
                            $start_late_css = "style=background-color:#f1d2d2;";
                            if($asset->asset_type == 'email_blast'){
                                $start_date = date('m/d/Y', strtotime($asset->due . ' -14 weekday'));
                                if($start_date <= date('m/d/Y') ){
                                    $start_css = $start_late_css;
                                }
                            }else if($asset->asset_type == 'website_banners'){
                                $start_date = date('m/d/Y', strtotime($asset->due . ' -15 weekday'));
                                if($start_date <= date('m/d/Y') ){
                                    $start_css = $start_late_css;
                                }
                            }else if($asset->asset_type == 'social_ad'){
                                $start_date = date('m/d/Y', strtotime($asset->due . ' -14 weekday'));
                                if($start_date <= date('m/d/Y') ){
                                    $start_css = $start_late_css;
                                }
                            }else if($asset->asset_type == 'landing_page'){
                                $start_date = date('m/d/Y', strtotime($asset->due . ' -28 weekday'));
                                if($start_date <= date('m/d/Y') ){
                                    $start_css = $start_late_css;
                                }
                            }else if($asset->asset_type == 'topcategories_copy'){
                                $start_date =  date('m/d/Y', strtotime($asset->due . ' -6 weekday'));
                                if($start_date <= date('m/d/Y') ){
                                    $start_css = $start_late_css;
                                }
                            }else if($asset->asset_type == 'a_content'){
                                $start_date = date('m/d/Y', strtotime($asset->due . ' -25 weekday'));
                                if($start_date <= date('m/d/Y') ){
                                    $start_css = $start_late_css;
                                }
                            }else if ($asset->asset_type == 'programmatic_banners'){
                                $start_date = date('m/d/Y', strtotime($asset->due . ' -17 weekday'));
                                if($start_date <= date('m/d/Y') ){
                                    $start_css = $start_late_css;
                                }
                            }else if($asset->asset_type == 'misc'){
                                $start_date = date('m/d/Y', strtotime($asset->due . ' -13 weekday'));
                                if($start_date <= date('m/d/Y') ){
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
                                                <div class="text-time">{{ date('m/d/Y', strtotime($asset->due))}}</div>
                                                <div class="media-description text-muted">{{$asset->name}}</div>
                                                <div class="media-links">
                                                    {{ ucwords(str_replace('_', ' ', $asset->asset_type))}} ({{$asset->asset_id}})
                                                    <div class="bullet"></div>
                                                    <figure class="avatar mr-2 avatar-sm text-white" style="background-color: #eacc34" data-initial="{{$asset->campaign_id}}"></figure>
                                                    <div class="bullet"></div>
                                                    {{ $start_date }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                </div>

                <div class="col-lg-3">
                    <h2 class="section-title">Copy Review</h2>
                    @foreach ($asset_list_copy_review as $asset)

                        <?php
                        $start_css = '';
                        $start_late_css = "style=background-color:#f1d2d2;";
                        if($asset->asset_type == 'email_blast'){
                            $start_date = date('m/d/Y', strtotime($asset->due . ' -12 weekday'));
                            if($start_date <= date('m/d/Y') ){
                                $start_css = $start_late_css;
                            }
                        }else if($asset->asset_type == 'website_banners'){
                            $start_date = date('m/d/Y', strtotime($asset->due . ' -13 weekday'));
                            if($start_date <= date('m/d/Y') ){
                                $start_css = $start_late_css;
                            }
                        }else if($asset->asset_type == 'social_ad'){
                            $start_date = date('m/d/Y', strtotime($asset->due . ' -12 weekday'));
                            if($start_date <= date('m/d/Y') ){
                                $start_css = $start_late_css;
                            }
                        }else if($asset->asset_type == 'landing_page'){
                            $start_date = date('m/d/Y', strtotime($asset->due . ' -24 weekday'));
                            if($start_date <= date('m/d/Y') ){
                                $start_css = $start_late_css;
                            }
                        }else if($asset->asset_type == 'topcategories_copy'){
                            $start_date =  date('m/d/Y', strtotime($asset->due . ' -4 weekday'));
                            if($start_date <= date('m/d/Y') ){
                                $start_css = $start_late_css;
                            }
                        }else if($asset->asset_type == 'a_content'){
                            $start_date = date('m/d/Y', strtotime($asset->due . ' -23 weekday'));
                            if($start_date <= date('m/d/Y') ){
                                $start_css = $start_late_css;
                            }
                        }else if($asset->asset_type == 'programmatic_banners'){
                            $start_date = date('m/d/Y', strtotime($asset->due . ' -15 weekday'));
                            if($start_date <= date('m/d/Y') ){
                                $start_css = $start_late_css;
                            }
                        }else if($asset->asset_type == 'misc'){
                            $start_date = date('m/d/Y', strtotime($asset->due . ' -11 weekday'));
                            if($start_date <= date('m/d/Y') ){
                                $start_css = $start_late_css;
                            }
                        }else if($asset->asset_type == 'image_request'){
                            $start_date = date('m/d/Y', strtotime($asset->due . ' -9 weekday'));
                            if($start_date <= date('m/d/Y') ){
                                $start_css = $start_late_css;
                            }
                        }else if($asset->asset_type == 'roll_over'){
                            $start_date = date('m/d/Y', strtotime($asset->due . ' -10 weekday'));
                            if($start_date <= date('m/d/Y') ){
                                $start_css = $start_late_css;
                            }
                        }else if($asset->asset_type == 'store_front'){
                            $start_date = date('m/d/Y', strtotime($asset->due . ' -23 weekday'));
                            if($start_date <= date('m/d/Y') ){
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
                                            <div class="text-time">{{ date('m/d/Y', strtotime($asset->due))}}</div>
                                            <div class="media-description text-muted">{{$asset->name}}</div>
                                            <div class="media-links">
                                                {{ ucwords(str_replace('_', ' ', $asset->asset_type))}} ({{$asset->asset_id}})
                                                <div class="bullet"></div>
                                                <figure class="avatar mr-2 avatar-sm text-white" style="background-color: lightsalmon" data-initial="{{$asset->campaign_id}}"></figure>
                                                <div class="bullet"></div>
                                                {{ $start_date }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                <div class="col-lg-3">
                    <h2 class="section-title">Copy Completed</h2>
                    @foreach ($asset_list_copy_complete as $asset)
                        <div class="card">
                            <a href="{{ url('admin/campaign/'. $asset->campaign_id .'/edit#'.$asset->asset_id)}}" style="text-decoration: none;">
                                <div class="card-body">
                                    <div class="media" style="padding-bottom: 0px;">
                                        <div class="form-group" style="width: 100%">
                                            <div class="media-right" >{{$asset->campaign_name}}</div>
                                            <div class="media-title mb-1">{{$asset->author_name}}</div>
                                            <div class="text-time">{{ date('m/d/Y', strtotime($asset->due))}}</div>
                                            <div class="media-description text-muted">{{$asset->name}}</div>
                                            <div class="media-links">
                                                {{ ucwords(str_replace('_', ' ', $asset->asset_type))}} ({{$asset->asset_id}})
                                                <div class="bullet"></div>
                                                <figure class="avatar mr-2 avatar-sm text-white" style="background-color: #ea3c75" data-initial="{{$asset->campaign_id}}"></figure>
{{--                                                <div class="bullet"></div>--}}
{{--                                                {{ date('m/d/Y', strtotime($asset->due)) }}--}}
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
                    @foreach ($asset_list_waiting_final_approval as $asset)
                        <div class="card">
                            <a href="{{ url('admin/campaign/'. $asset->campaign_id .'/edit#'.$asset->asset_id)}}" style="text-decoration: none;">
                                <div class="card-body">
                                    <div class="media" style="padding-bottom: 0px;">
                                        <div class="form-group" style="width: 100%">
                                            <div class="media-right" >{{$asset->campaign_name}}</div>
                                            <div class="media-title mb-1">{{$asset->author_name}}</div>
                                            <div class="text-time">{{ date('m/d/Y', strtotime($asset->due))}}</div>
                                            <div class="media-description text-muted">{{$asset->name}}</div>
                                            <div class="media-links">
                                                {{ ucwords(str_replace('_', ' ', $asset->asset_type))}} ({{$asset->asset_id}})
                                                <div class="bullet"></div>
                                                <figure class="avatar mr-2 avatar-sm text-white" style="background-color: #3392af" data-initial="{{$asset->campaign_id}}"></figure>
{{--                                                <div class="bullet"></div>--}}
{{--                                                {{ date('m/d/Y', strtotime($asset->due)) }}--}}
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
