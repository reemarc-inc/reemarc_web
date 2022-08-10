@extends('layouts.dashboard')

@section('content')

    <section class="section">
        <div class="section-header">
            <h1>Status Board (KOE)</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Status Board (KOE)</div>
            </div>
        </div>

        <div class="section-body">

            @include('admin.asset.jira_kec_filter')
            @include('admin.asset.flash')

            <div class="row">

                <div class="col-lg-3">
                    <h2 class="section-title">Copy Request</h2>
                        @foreach ($asset_list_copy_request as $asset)
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
                                                        <figure class="avatar mr-2 avatar-sm text-white" style="background-color: #eacc34" data-initial="{{$asset->campaign_id}}"></figure>
                                                        <div class="bullet"></div>
                                                        {{ date('m/d/Y', strtotime($asset->due)) }}
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                </div>

                <div class="col-lg-3">
                    <h2 class="section-title">Waiting Copy Review</h2>
                    @foreach ($asset_list_copy_review as $asset)
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
                                                <figure class="avatar mr-2 avatar-sm text-white" style="background-color: lightsalmon" data-initial="{{$asset->campaign_id}}"></figure>
                                                <div class="bullet"></div>
                                                {{ date('m/d/Y', strtotime($asset->due)) }}
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
                                                <div class="bullet"></div>
                                                {{ date('m/d/Y', strtotime($asset->due)) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                <div class="col-lg-3">
                    <h2 class="section-title">Waiting Final Approval</h2>
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
                                                <div class="bullet"></div>
                                                {{ date('m/d/Y', strtotime($asset->due)) }}
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
