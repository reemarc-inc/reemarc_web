@php
    $activeClass = 'active';
@endphp
<aside id="sidebar-wrapper">
    <div class="sidebar-brand">
        <a href="{{ url('/admin/dashboard')}}">KOE PROJECT MANAGER</a>
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
        <?php if(auth()->user()->team == 'KEC' || auth()->user()->team == 'Brand' || auth()->user()->role == 'admin'){ ?>
        <li class="{{ ($currentAdminMenu == 'asset_jira_kec') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/asset_jira_kec') }}"><i class="fas fa-th"></i> <span>Status Board (KOE)</span></a></li>
        <?php } ?>
        <?php if(auth()->user()->role == 'creative director' || auth()->user()->role == 'admin'){ ?>
        <li class="{{ ($currentAdminMenu == 'asset_approval') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/asset_approval') }}"><i class="fas fa-th-list"></i> <span>Approval List</span></a></li>
        <?php } ?>
        <?php if(auth()->user()->team == 'Creative' || auth()->user()->role == 'admin'){ ?>
        <li class="{{ ($currentAdminMenu == 'asset_jira') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/asset_jira') }}"><i class="fas fa-th"></i> <span>Status Board (Creative)</span></a></li>
        <?php } ?>

        <?php if(auth()->user()->role == 'admin'){ ?>
        <li class="menu-header">Account</li>
        <li class="{{ ($currentAdminMenu == 'users') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/users')}}"><i class="fas fa-user"></i> <span>Users</span></a></li>
        <li class="menu-header">Setting</li>
        <li class="{{ ($currentAdminMenu == 'brands') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/brands')}}"><i class="fas fa-user"></i> <span>Brand</span></a></li>
        <?php } ?>
    </ul>
</aside>
