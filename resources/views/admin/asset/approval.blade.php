@extends('layouts.dashboard')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Asset Approval</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item">Asset Approval</div>
        </div>
    </div>

    <div class="section-body">

        <h2 class="section-title">Asset Approval List</h2>

        @include('admin.asset.approval_filter')
        @include('admin.asset.flash')

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <th>Due Date</th>
                                        <th>Asset Type</th>
                                        <th>Asset ID</th>
                                        <th>Project ID</th>
                                        <th>Project Name</th>
                                        <th>Action</th>
                                    </tr>

                                    @foreach ($asset_list as $asset)
                                        <tr>
                                            <td>{{ date('m/d/Y', strtotime($asset->due)) }}</td>
                                            <td>{{ ucwords(str_replace('_', ' ', $asset->asset_type)) }}</td>
                                            <td>{{ $asset->asset_id }}</td>
                                            <td>
                                                <a href="{{ url('admin/campaign/'.$asset->campaign_id.'/edit') }}">
                                                    <figure class="avatar mr-2 avatar-sm text-white" style="background-color: #ea3c75" data-initial="{{$asset->campaign_id}}"></figure>
                                                </a>
                                            </td>
                                            <td>{{ $asset->name }}</td>
                                            <td>
                                                <a href="{{ url('admin/asset/'. $asset->asset_id .'/'. $asset->campaign_id . '/' . $asset->asset_type . '/detail')}}" class="btn btn-secondary">
                                                    Detail
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>



@endsection
