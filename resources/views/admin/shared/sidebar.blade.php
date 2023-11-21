@php
    $activeClass = 'active';
@endphp
<aside id="sidebar-wrapper">
    <div class="sidebar-brand">
        <a href="{{ url('/admin/dashboard')}}">REEMARC</a>
    </div>

    <ul class="sidebar-menu">

        <li class="{{ ($currentAdminMenu == 'dashboard') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/dashboard') }}"><i class="fas fa-fire"></i> <span>Dashboard</span></a></li>

{{--        <li class="menu-header">APPOINTMENT</li>--}}
{{--        <li class="{{ ($currentAdminMenu == 'campaign') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/campaign') }}"><i class="fas fa-calendar"></i> <span>Project Manager</span></a></li>--}}
{{--        <li class="{{ ($currentAdminMenu == 'archives') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/archives') }}"><i class="fas fa-archive"></i> <span>Project Archives</span></a></li>--}}

{{--        <li class="menu-header">Operations</li>--}}

{{--        <li class="{{ ($currentAdminMenu == 'asset_jira_kec') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/asset_jira_kec') }}"><i class="fas fa-th"></i> <span>All Status Board</span></a></li>--}}
{{--        <li class="{{ ($currentAdminMenu == 'asset_approval') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/asset_approval') }}"><i class="fas fa-th-list"></i> <span>Payment List</span></a></li>--}}


{{--        <li class="menu-header">Creative Dept</li>--}}
{{--        <?php if(auth()->user()->role == 'creative director' || auth()->user()->role == 'admin'){ ?>--}}
{{--        <li class="{{ ($currentAdminMenu == 'asset_approval') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/asset_approval') }}"><i class="fas fa-th-list"></i> <span>Approval List</span></a></li>--}}
{{--        <?php } ?>--}}
{{--        <?php if(auth()->user()->team == 'Creative' || auth()->user()->role == 'admin'){ ?>--}}
{{--        <li class="{{ ($currentAdminMenu == 'asset_jira') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/asset_jira') }}"><i class="fas fa-th"></i> <span>Status Board (Creative)</span></a></li>--}}
{{--        <?php } ?>--}}
{{--        <?php if(auth()->user()->role == 'creative director' || auth()->user()->role == 'admin'){ ?>--}}
{{--        <li class="{{ ($currentAdminMenu == 'asset_kpi') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/asset_kpi') }}"><i class="fas fa-th-list"></i> <span>KPI (Creative)</span></a></li>--}}
{{--        <?php } ?>--}}

        <li class="menu-header">Account</li>
        <?php if(auth()->user()->role == 'admin'){ ?>
        <li class="{{ ($currentAdminMenu == 'users') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/users')}}"><i class="fas fa-user"></i> <span>Users</span></a></li>
        <?php } ?>
        <li class="menu-header">Settings</li>
{{--        <li class="{{ ($currentAdminMenu == 'asset_lead_time') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/asset_lead_time')}}"><i class="fas fa-user"></i> <span>Clinics</span></a></li>--}}
        <li class="{{ ($currentAdminMenu == 'clinic') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/clinic')}}"><i class="fas fa-user"></i> <span>Clinics</span></a></li>
        <li class="menu-header">APIs</li>
        <li class="{{ ($currentAdminMenu == 'api') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/api')}}"><i class="fas fa-user"></i> <span>Api Test</span></a></li>
    </ul>
</aside>
