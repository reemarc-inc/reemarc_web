@php
    $activeClass = 'active';
@endphp
<aside id="sidebar-wrapper">
    <div class="sidebar-brand">
        <a href="{{ url('/admin/dashboard')}}">REEMARC</a>
    </div>

    <ul class="sidebar-menu">

        <li class="{{ ($currentAdminMenu == 'dashboard') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/dashboard') }}"><i class="fas fa-fire"></i> <span>Dashboard</span></a></li>

        <li class="menu-header">Appointments</li>
        <?php if(auth()->user()->role == 'admin'){ ?>
        <li class="{{ ($currentAdminMenu == 'appointment_make') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/appointment_make')}}"><i class="fas fa-table"></i> <span>Make Appointment</span></a></li>
        <li class="{{ ($currentAdminMenu == 'appointments_list') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/appointments_list')}}"><i class="fas fa-list-ul"></i> <span>Appointment List</span></a></li>
        <?php }?>
{{--        <?php if(auth()->user()->role == 'admin'){ ?>--}}
{{--        <li class="{{ ($currentAdminMenu == 'appointment_follow_up') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/appointment_follow_up')}}"><i class="fas fa-check-square"></i> <span>Follow Up</span></a></li>--}}
{{--        <?php } ?>--}}
{{--        <?php if(auth()->user()->role == 'admin'){ ?>--}}
{{--        <li class="{{ ($currentAdminMenu == 'appointment_pending') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/appointment_pending')}}"><i class="fas fa-check-square"></i> <span>Pending & Canceled</span></a></li>--}}
{{--        <?php } ?>--}}
        <li class="menu-header">Clinic</li>
        <?php if(auth()->user()->role == 'admin' || auth()->user()->role == 'doctor'){ ?>
        <li class="{{ ($currentAdminMenu == 'patient_jira') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/patient_jira')}}"><i class="fa fa-magnet"></i> <span>Patient Status</span></a></li>
        <?php } ?>
        <li class="menu-header">Package</li>
        <?php if(auth()->user()->role == 'admin'){ ?>
        <li class="{{ ($currentAdminMenu == 'package_jira') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/package_jira')}}"><i class="fa fa-magnet"></i> <span>Package Order Status</span></a></li>
        <?php } ?>
        <li class="menu-header">Treatments</li>
        <?php if(auth()->user()->role == 'admin' || auth()->user()->role == 'doctor'){ ?>
        <li class="{{ ($currentAdminMenu == 'treatments') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/treatments')}}"><i class="fas fa-stethoscope"></i> <span>Treatment List</span></a></li>
        <?php } ?>
        <li class="menu-header">Account</li>
        <?php if(auth()->user()->role == 'admin'){ ?>
        <li class="{{ ($currentAdminMenu == 'users') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/users')}}"><i class="fas fa-user"></i> <span>Users</span></a></li>
        <?php } ?>
        <li class="menu-header">Notification</li>
        <?php if(auth()->user()->role == 'admin'){ ?>
        <li class="{{ ($currentAdminMenu == 'notification') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/notification')}}"><i class="fas fa-bullhorn"></i> <span>Notification</span></a></li>
        <?php } ?>
        <li class="menu-header">Settings</li>
        <?php if(auth()->user()->role == 'admin'){ ?>
{{--        <li class="{{ ($currentAdminMenu == 'asset_lead_time') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/asset_lead_time')}}"><i class="fas fa-user"></i> <span>Clinics</span></a></li>--}}
        <li class="{{ ($currentAdminMenu == 'clinic') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/clinic')}}"><i class="fas fa-user-md"></i> <span>Clinics</span></a></li>
        <li class="{{ ($currentAdminMenu == 'package') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/package')}}"><i class="fas fa-medkit"></i> <span>Package</span></a></li>
        <?php } ?>
        <li class="menu-header">APIs</li>
        <?php if(auth()->user()->role == 'admin'){ ?>
        <li class="{{ ($currentAdminMenu == 'api') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/api')}}"><i class="fas fa-wifi"></i> <span>Api Test</span></a></li>
        <?php } ?>
    </ul>
</aside>
