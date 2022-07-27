@php
    $activeClass = 'active';
@endphp
<aside id="sidebar-wrapper">
    <div class="sidebar-brand">
        <a href="{{ url('/admin/dashboard')}}">KEC PROJECT MANAGER</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
        <a href="{{ url('/')}}">KPM</a>
    </div>
    <ul class="sidebar-menu">

        <li class="{{ ($currentAdminMenu == 'dashboard') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/dashboard') }}"><i class="fas fa-fire"></i> <span>Dashboard</span></a></li>

        <li class="menu-header">Project</li>
        <li class="{{ ($currentAdminMenu == 'campaign') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/campaign') }}"><i class="fas fa-calendar"></i> <span>Project Manage</span></a></li>
        <li class="{{ ($currentAdminMenu == 'archives') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/archives') }}"><i class="fas fa-archive"></i> <span>Project Archives</span></a></li>

        <li class="menu-header">Asset</li>
        <li class="{{ ($currentAdminMenu == 'asset_jira_kec') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/asset_jira_kec') }}"><i class="fas fa-th"></i> <span>Status Board (KEC)</span></a></li>
        <li class="{{ ($currentAdminMenu == 'asset_approval') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/asset_approval') }}"><i class="fas fa-th-list"></i> <span>Approval List</span></a></li>
{{--        <li class="{{ ($currentAdminMenu == 'asset_assign') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/asset_assign') }}"><i class="fas fa-clipboard"></i> <span>Asset Assign</span></a></li>--}}
        <li class="{{ ($currentAdminMenu == 'asset_jira') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/asset_jira') }}"><i class="fas fa-th"></i> <span>Status Board (Creative)</span></a></li>

        <li class="menu-header">Account</li>
        <li class="{{ ($currentAdminMenu == 'users') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/users')}}"><i class="fas fa-user"></i> <span>Users</span></a></li>
{{--        <li class="{{ ($currentAdminMenu == 'roles') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/roles')}}"><i class="fas fa-lock"></i> <span>@lang('roles.menu_role_label')</span></a></li>--}}
{{--        <li class="{{ ($currentAdminMenu == 'settings') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/settings')}}"><i class="fas fa-cogs"></i> <span>@lang('settings.menu_settings_label')</span></a></li>--}}

        <li class="menu-header">Setting</li>
        <li class="{{ ($currentAdminMenu == 'brands') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/brands')}}"><i class="fas fa-user"></i> <span>Brand</span></a></li>

    </ul>
</aside>
