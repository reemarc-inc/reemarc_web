@extends('layouts.dashboard')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Asset Owners Management</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active">Asset Owners</div>
        </div>
    </div>
    <div class="section-body">
        <h2 class="section-title">Asset Owners Table</h2>

        <div class="table-responsive">
            <table class="table-bordered" style="text-align: center;">
                <tbody>
                <tr>
                    <th></th>
                    @foreach ($brands as $brand)
                        <th style="color: #b91d19;">{{ $brand['campaign_name'] }}</th>
                    @endforeach
                </tr>

                @foreach ($asset_owner_assets as $asset)
                    <tr>
                        <td style="padding: 0 10px; color: #1a1a1a; font-weight: bold;">{{ $asset['asset_name'] }}</td>
{{--                        <td style="padding: 0 10px;"><div class="btn btn-light" data-toggle="modal" data-target="#kiss_nails-{{$asset['id']}}">{{ App\Http\Controllers\admin\AssetController::get_owner_name_by_id($asset['kiss_nails']) }}</div></td>--}}
{{--                        <td style="padding: 0 10px;"><div class="btn btn-light" data-toggle="modal" data-target="#kiss_lashes-{{$asset['id']}}">{{ App\Http\Controllers\admin\AssetController::get_owner_name_by_id($asset['kiss_lashes']) }}</div></td>--}}
{{--                        <td style="padding: 0 10px;"><div class="btn btn-light" data-toggle="modal" data-target="#kiss_hair-{{$asset['id']}}">{{ App\Http\Controllers\admin\AssetController::get_owner_name_by_id($asset['kiss_hair']) }}</div></td>--}}
{{--                        <td style="padding: 0 10px;"><div class="btn btn-light" data-toggle="modal" data-target="#impress-{{$asset['id']}}">{{ App\Http\Controllers\admin\AssetController::get_owner_name_by_id($asset['impress']) }}</div></td>--}}
{{--                        <td style="padding: 0 10px;"><div class="btn btn-light" data-toggle="modal" data-target="#joah-{{$asset['id']}}">{{ App\Http\Controllers\admin\AssetController::get_owner_name_by_id($asset['joah']) }}</div></td>--}}
{{--                        <td style="padding: 0 10px;"><div class="btn btn-light" data-toggle="modal" data-target="#color_care-{{$asset['id']}}">{{ App\Http\Controllers\admin\AssetController::get_owner_name_by_id($asset['color_care']) }}</div></td>--}}
{{--                        <td style="padding: 0 10px;"><div class="btn btn-light" data-toggle="modal" data-target="#kiss_mass_market-{{$asset['id']}}">{{ App\Http\Controllers\admin\AssetController::get_owner_name_by_id($asset['kiss_mass_market']) }}</div></td>--}}
{{--                        <td style="padding: 0 10px;"><div class="btn btn-light" data-toggle="modal" data-target="#kiss_international-{{$asset['id']}}">{{ App\Http\Controllers\admin\AssetController::get_owner_name_by_id($asset['kiss_international']) }}</div></td>--}}
{{--                        <td style="padding: 0 10px;"><div class="btn btn-light" data-toggle="modal" data-target="#retailer_support-{{$asset['id']}}">{{ App\Http\Controllers\admin\AssetController::get_owner_name_by_id($asset['retailer_support']) }}</div></td>--}}
{{--                        <td style="padding: 0 10px;"><div class="btn btn-light" data-toggle="modal" data-target="#kiss_beauty_supply-{{$asset['id']}}">{{ App\Http\Controllers\admin\AssetController::get_owner_name_by_id($asset['kiss_beauty_supply']) }}</div></td>--}}
{{--                        <td style="padding: 0 10px;"><div class="btn btn-light" data-toggle="modal" data-target="#falscara-{{$asset['id']}}">{{ App\Http\Controllers\admin\AssetController::get_owner_name_by_id($asset['falscara']) }}</div></td>--}}
{{--                        <td style="padding: 0 10px;"><div class="btn btn-light" data-toggle="modal" data-target="#myedit-{{$asset['id']}}">{{ App\Http\Controllers\admin\AssetController::get_owner_name_by_id($asset['myedit']) }}</div></td>--}}
{{--                        <td style="padding: 0 10px;"><div class="btn btn-light" data-toggle="modal" data-target="#meamora-{{$asset['id']}}">{{ App\Http\Controllers\admin\AssetController::get_owner_name_by_id($asset['meamora']) }}</div></td>--}}
{{--                        <td style="padding: 0 10px;"><div class="btn btn-light" data-toggle="modal" data-target="#beautify_tips-{{$asset['id']}}">{{ App\Http\Controllers\admin\AssetController::get_owner_name_by_id($asset['beautify_tips']) }}</div></td>--}}
                        <td style="padding: 0 10px;"><div class="btn btn-light" data-toggle="modal" data-target="#kiss_nails-{{$asset['id']}}">{{ $asset['kiss_nails']}}</div></td>
                        <td style="padding: 0 10px;"><div class="btn btn-light" data-toggle="modal" data-target="#kiss_lashes-{{$asset['id']}}">{{ $asset['kiss_lashes']}}</div></td>
                        <td style="padding: 0 10px;"><div class="btn btn-light" data-toggle="modal" data-target="#kiss_hair-{{$asset['id']}}">{{ $asset['kiss_hair']}}</div></td>
                        <td style="padding: 0 10px;"><div class="btn btn-light" data-toggle="modal" data-target="#impress-{{$asset['id']}}">{{ $asset['impress']}}</div></td>
                        <td style="padding: 0 10px;"><div class="btn btn-light" data-toggle="modal" data-target="#joah-{{$asset['id']}}">{{ $asset['joah']}}</div></td>
                        <td style="padding: 0 10px;"><div class="btn btn-light" data-toggle="modal" data-target="#color_care-{{$asset['id']}}">{{ $asset['color_care']}}</div></td>
                        <td style="padding: 0 10px;"><div class="btn btn-light" data-toggle="modal" data-target="#kiss_mass_market-{{$asset['id']}}">{{ $asset['kiss_mass_market']}}</div></td>
                        <td style="padding: 0 10px;"><div class="btn btn-light" data-toggle="modal" data-target="#kiss_international-{{$asset['id']}}">{{ $asset['kiss_international']}}</div></td>
                        <td style="padding: 0 10px;"><div class="btn btn-light" data-toggle="modal" data-target="#retailer_support-{{$asset['id']}}">{{ $asset['retailer_support']}}</div></td>
                        <td style="padding: 0 10px;"><div class="btn btn-light" data-toggle="modal" data-target="#kiss_beauty_supply-{{$asset['id']}}">{{ $asset['kiss_beauty_supply']}}</div></td>
                        <td style="padding: 0 10px;"><div class="btn btn-light" data-toggle="modal" data-target="#falscara-{{$asset['id']}}">{{ $asset['falscara']}}</div></td>
                        <td style="padding: 0 10px;"><div class="btn btn-light" data-toggle="modal" data-target="#myedit-{{$asset['id']}}">{{ $asset['myedit']}}</div></td>
                        <td style="padding: 0 10px;"><div class="btn btn-light" data-toggle="modal" data-target="#meamora-{{$asset['id']}}">{{ $asset['meamora']}}</div></td>
                        <td style="padding: 0 10px;"><div class="btn btn-light" data-toggle="modal" data-target="#beautify_tips-{{$asset['id']}}">{{ $asset['beautify_tips']}}</div></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

</section>

@foreach ($asset_owner_assets as $asset)
    <div class="modal fade" id="kiss_nails-{{$asset['id']}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ route('asset.asset_owner_change_mapping') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Change Asset Owner</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="row">
                                <?php if (isset($users)): ?>
                                @foreach($users as $user)
                                    <div class="col-sm-3">
                                        <div class="form-check">
                                            <input  <?php if ($user->id == $asset['kiss_nails']) echo "checked" ?>
                                                    type="radio"
                                                    name="asset_owner_id"
                                                    value="{{ $user->id }},kiss_nails,{{ $asset['id'] }}"
                                            >
                                            <label class="form-check-label " for="{{ $user->first_name }}">
                                                {{ $user->first_name }} {{ $user->last_name }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="kiss_lashes-{{$asset['id']}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ route('asset.asset_owner_change_mapping') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Change Asset Owner</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="row">
                                <?php if (isset($users)): ?>
                                @foreach($users as $user)
                                    <div class="col-sm-3">
                                        <div class="form-check">
                                            <input  <?php if ($user->id == $asset['kiss_lashes']) echo "checked" ?>
                                                    type="radio"
                                                    name="asset_owner_id"
                                                    value="{{ $user->id }},kiss_lashes,{{ $asset['id'] }}"
                                            >
                                            <label class="form-check-label " for="{{ $user->first_name }}">
                                                {{ $user->first_name }} {{ $user->last_name }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="kiss_hair-{{$asset['id']}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ route('asset.asset_owner_change_mapping') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Change Asset Owner</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="row">
                                <?php if (isset($users)): ?>
                                @foreach($users as $user)
                                    <div class="col-sm-3">
                                        <div class="form-check">
                                            <input  <?php if ($user->id == $asset['kiss_hair']) echo "checked" ?>
                                                    type="radio"
                                                    name="asset_owner_id"
                                                    value="{{ $user->id }},kiss_hair,{{ $asset['id'] }}"
                                            >
                                            <label class="form-check-label " for="{{ $user->first_name }}">
                                                {{ $user->first_name }} {{ $user->last_name }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="impress-{{$asset['id']}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ route('asset.asset_owner_change_mapping') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Change Asset Owner</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="row">
                                <?php if (isset($users)): ?>
                                @foreach($users as $user)
                                    <div class="col-sm-3">
                                        <div class="form-check">
                                            <input  <?php if ($user->id == $asset['impress']) echo "checked" ?>
                                                    type="radio"
                                                    name="asset_owner_id"
                                                    value="{{ $user->id }},impress,{{ $asset['id'] }}"
                                            >
                                            <label class="form-check-label " for="{{ $user->first_name }}">
                                                {{ $user->first_name }} {{ $user->last_name }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="joah-{{$asset['id']}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ route('asset.asset_owner_change_mapping') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Change Asset Owner</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="row">
                                <?php if (isset($users)): ?>
                                @foreach($users as $user)
                                    <div class="col-sm-3">
                                        <div class="form-check">
                                            <input  <?php if ($user->id == $asset['joah']) echo "checked" ?>
                                                    type="radio"
                                                    name="asset_owner_id"
                                                    value="{{ $user->id }},joah,{{ $asset['id'] }}"
                                            >
                                            <label class="form-check-label " for="{{ $user->first_name }}">
                                                {{ $user->first_name }} {{ $user->last_name }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="color_care-{{$asset['id']}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ route('asset.asset_owner_change_mapping') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Change Asset Owner</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="row">
                                <?php if (isset($users)): ?>
                                @foreach($users as $user)
                                    <div class="col-sm-3">
                                        <div class="form-check">
                                            <input  <?php if ($user->id == $asset['color_care']) echo "checked" ?>
                                                    type="radio"
                                                    name="asset_owner_id"
                                                    value="{{ $user->id }},color_care,{{ $asset['id'] }}"
                                            >
                                            <label class="form-check-label " for="{{ $user->first_name }}">
                                                {{ $user->first_name }} {{ $user->last_name }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="kiss_mass_market-{{$asset['id']}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ route('asset.asset_owner_change_mapping') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Change Asset Owner</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="row">
                                <?php if (isset($users)): ?>
                                @foreach($users as $user)
                                    <div class="col-sm-3">
                                        <div class="form-check">
                                            <input  <?php if ($user->id == $asset['kiss_mass_market']) echo "checked" ?>
                                                    type="radio"
                                                    name="asset_owner_id"
                                                    value="{{ $user->id }},kiss_mass_market,{{ $asset['id'] }}"
                                            >
                                            <label class="form-check-label " for="{{ $user->first_name }}">
                                                {{ $user->first_name }} {{ $user->last_name }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="kiss_international-{{$asset['id']}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ route('asset.asset_owner_change_mapping') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Change Asset Owner</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="row">
                                <?php if (isset($users)): ?>
                                @foreach($users as $user)
                                    <div class="col-sm-3">
                                        <div class="form-check">
                                            <input  <?php if ($user->id == $asset['kiss_international']) echo "checked" ?>
                                                    type="radio"
                                                    name="asset_owner_id"
                                                    value="{{ $user->id }},kiss_international,{{ $asset['id'] }}"
                                            >
                                            <label class="form-check-label " for="{{ $user->first_name }}">
                                                {{ $user->first_name }} {{ $user->last_name }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="retailer_support-{{$asset['id']}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ route('asset.asset_owner_change_mapping') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Change Asset Owner</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="row">
                                <?php if (isset($users)): ?>
                                @foreach($users as $user)
                                    <div class="col-sm-3">
                                        <div class="form-check">
                                            <input  <?php if ($user->id == $asset['retailer_support']) echo "checked" ?>
                                                    type="radio"
                                                    name="asset_owner_id"
                                                    value="{{ $user->id }},retailer_support,{{ $asset['id'] }}"
                                            >
                                            <label class="form-check-label " for="{{ $user->first_name }}">
                                                {{ $user->first_name }} {{ $user->last_name }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="kiss_beauty_supply-{{$asset['id']}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ route('asset.asset_owner_change_mapping') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Change Asset Owner</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="row">
                                <?php if (isset($users)): ?>
                                @foreach($users as $user)
                                    <div class="col-sm-3">
                                        <div class="form-check">
                                            <input  <?php if ($user->id == $asset['kiss_beauty_supply']) echo "checked" ?>
                                                    type="radio"
                                                    name="asset_owner_id"
                                                    value="{{ $user->id }},kiss_beauty_supply,{{ $asset['id'] }}"
                                            >
                                            <label class="form-check-label " for="{{ $user->first_name }}">
                                                {{ $user->first_name }} {{ $user->last_name }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="falscara-{{$asset['id']}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ route('asset.asset_owner_change_mapping') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Change Asset Owner</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="row">
                                <?php if (isset($users)): ?>
                                @foreach($users as $user)
                                    <div class="col-sm-3">
                                        <div class="form-check">
                                            <input  <?php if ($user->id == $asset['falscara']) echo "checked" ?>
                                                    type="radio"
                                                    name="asset_owner_id"
                                                    value="{{ $user->id }},falscara,{{ $asset['id'] }}"
                                            >
                                            <label class="form-check-label " for="{{ $user->first_name }}">
                                                {{ $user->first_name }} {{ $user->last_name }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="myedit-{{$asset['id']}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ route('asset.asset_owner_change_mapping') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Change Asset Owner</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="row">
                                <?php if (isset($users)): ?>
                                @foreach($users as $user)
                                    <div class="col-sm-3">
                                        <div class="form-check">
                                            <input  <?php if ($user->id == $asset['myedit']) echo "checked" ?>
                                                    type="radio"
                                                    name="asset_owner_id"
                                                    value="{{ $user->id }},myedit,{{ $asset['id'] }}"
                                            >
                                            <label class="form-check-label " for="{{ $user->first_name }}">
                                                {{ $user->first_name }} {{ $user->last_name }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="meamora-{{$asset['id']}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ route('asset.asset_owner_change_mapping') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Change Asset Owner</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="row">
                                <?php if (isset($users)): ?>
                                @foreach($users as $user)
                                    <div class="col-sm-3">
                                        <div class="form-check">
                                            <input  <?php if ($user->id == $asset['meamora']) echo "checked" ?>
                                                    type="radio"
                                                    name="asset_owner_id"
                                                    value="{{ $user->id }},meamora,{{ $asset['id'] }}"
                                            >
                                            <label class="form-check-label " for="{{ $user->first_name }}">
                                                {{ $user->first_name }} {{ $user->last_name }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="beautify_tips-{{$asset['id']}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ route('asset.asset_owner_change_mapping') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Change Asset Owner</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="row">
                                <?php if (isset($users)): ?>
                                @foreach($users as $user)
                                    <div class="col-sm-3">
                                        <div class="form-check">
                                            <input  <?php if ($user->id == $asset['beautify_tips']) echo "checked" ?>
                                                    type="radio"
                                                    name="asset_owner_id"
                                                    value="{{ $user->id }},beautify_tips,{{ $asset['id'] }}"
                                            >
                                            <label class="form-check-label " for="{{ $user->first_name }}">
                                                {{ $user->first_name }} {{ $user->last_name }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

@endsection
