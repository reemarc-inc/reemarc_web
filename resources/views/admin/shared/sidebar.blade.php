@php
    $activeClass = 'active';
@endphp
<aside id="sidebar-wrapper">
    <div class="sidebar-brand">
        <a href="{{ url('/admin/dashboard')}}">KDO PROJECT MANAGER</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
        <a href="{{ url('/')}}">KPM</a>
    </div>
    <ul class="sidebar-menu">

        <li class="{{ ($currentAdminMenu == 'dashboard') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/dashboard') }}"><i class="fas fa-fire"></i> <span>Dashboard</span></a></li>

        <li class="menu-header">Projects</li>
        <li class="{{ ($currentAdminMenu == 'campaign') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/campaign') }}"><i class="fas fa-calendar"></i> <span>Project Manager</span></a></li>
        <li class="{{ ($currentAdminMenu == 'archives') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/archives') }}"><i class="fas fa-archive"></i> <span>Project Archives</span></a></li>

        <li class="menu-header">KDO Operations Team</li>
        <?php if(auth()->user()->team == 'KDO' || auth()->user()->team == 'Global Marketing' || auth()->user()->role == 'admin'){ ?>
        <li class="{{ ($currentAdminMenu == 'asset_jira_kec') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/asset_jira_kec') }}"><i class="fas fa-th"></i> <span>Status Board (KDO)</span></a></li>
        <?php } ?>
        <?php if(auth()->user()->role == 'copywriter' || auth()->user()->role == 'admin'){ ?>
        <li class="{{ ($currentAdminMenu == 'asset_jira_copywriter') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/asset_jira_copywriter') }}"><i class="fas fa-th"></i> <span>Status Board (C/W)</span></a></li>
        <?php } ?>

        <li class="menu-header">Creative Dept</li>
        <?php if(auth()->user()->role == 'creative director' || auth()->user()->role == 'admin'){ ?>
        <li class="{{ ($currentAdminMenu == 'asset_approval') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/asset_approval') }}"><i class="fas fa-th-list"></i> <span>Approval List</span></a></li>
        <?php } ?>
        <?php if(auth()->user()->team == 'Creative' || auth()->user()->role == 'admin'){ ?>
        <li class="{{ ($currentAdminMenu == 'asset_jira') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/asset_jira') }}"><i class="fas fa-th"></i> <span>Status Board (Creative)</span></a></li>
        <?php } ?>

        <li class="menu-header">KDO Content Team</li>
        <?php if(auth()->user()->role == 'content manager' || auth()->user()->role == 'admin'){ ?>
        <li class="{{ ($currentAdminMenu == 'asset_approval_content') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/asset_approval_content') }}"><i class="fas fa-th-list"></i> <span>Approval List</span></a></li>
        <?php } ?>
        <?php if(auth()->user()->role == 'content manager' || auth()->user()->role == 'content creator' || auth()->user()->role == 'admin'){ ?>
        <li class="{{ ($currentAdminMenu == 'asset_jira_content') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/asset_jira_content') }}"><i class="fas fa-th"></i> <span>Status Board (Content)</span></a></li>
        <?php } ?>

        <li class="menu-header">KDO Web Production</li>
        <?php if(auth()->user()->role == 'web production manager' || auth()->user()->role == 'admin'){ ?>
        <li class="{{ ($currentAdminMenu == 'asset_approval_web') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/asset_approval_web') }}"><i class="fas fa-th-list"></i> <span>Approval List</span></a></li>
        <?php } ?>
        <?php if(auth()->user()->role == 'web production manager' || auth()->user()->role == 'web production' || auth()->user()->role == 'admin'){ ?>
        <li class="{{ ($currentAdminMenu == 'asset_jira_web') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/asset_jira_web') }}"><i class="fas fa-th"></i> <span>Status Board (Web)</span></a></li>
        <?php } ?>

        <?php if(auth()->user()->role == 'admin'){ ?>
        <li class="menu-header">Account</li>
        <li class="{{ ($currentAdminMenu == 'users') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/users')}}"><i class="fas fa-user"></i> <span>Users</span></a></li>
        <li class="menu-header">Settings</li>
        <li class="{{ ($currentAdminMenu == 'asset_owners') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/asset_owners')}}"><i class="fas fa-user"></i> <span>Asset Owners</span></a></li>
        <li class="{{ ($currentAdminMenu == 'brands') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/brands')}}"><i class="fas fa-user"></i> <span>Brands</span></a></li>
        <?php } ?>
    </ul>
</aside>
