<ul class="page-sidebar-menu   " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
    <li class="nav-item {{ Request::is('/') ? 'active' : '' }}">
        <a href="{{ url('/') }}" class="nav-link ">
            <i class="icon-home"></i>
            <span class="title">Dashboard</span>
            <span class="selected"></span>

        </a>

    </li>

    <li class="nav-item {{ Request::is('/') ? 'active' : '' }} ">
        <a href="{{ url('promoter/sale') }}" class="nav-link ">
            <i class=" icon-handbag"></i>
            <span class="title"> Journal Sales</span>

        </a>
    </li>

    <li class="nav-item {{ Request::is('/') ? 'active' : '' }} ">
        <a href="{{ url('promoter/attendance') }}" class="nav-link ">
            <i class="icon-compass"></i>
            <span class="title"> Attendances</span>

        </a>
    </li>

    <li class="heading">
        <h3 class="uppercase">Reports</h3>
    </li>

    <li class="nav-item  {{ Request::is('/') ? 'active' : '' }} ">
        <a href="{{ url('promoter/report/sale') }}" class="nav-link ">
            <i class="icon-bar-chart"></i>
            <span class="title">Sales Report</span>
        </a>
    </li>
    <li class="nav-item {{ Request::is('/') ? 'active' : '' }} ">
        <a href="{{ url('promoter/report/achievement') }}" class="nav-link ">
            <i class="icon-pie-chart"></i>
            <span class="title">Achievement Report</span>

        </a>
    </li>
    <li class="nav-item {{ Request::is('/') ? 'active' : '' }} ">
        <a href="{{ url('promoter/report/attendance') }}" class="nav-link ">
            <i class="icon-equalizer"></i>
            <span class="title">Attendance Report</span>
        </a>
    </li>

    <li class="heading">
        <h3 class="uppercase">Administration</h3>
    </li>
    <li class="nav-item {{ Request::is('user') ? 'active' : '' }} ">
        <a href="{{ url('promoter/user') }}" class="nav-link nav-toggle">
            <i class="icon-users"></i>
            <span class="title">Users</span>

        </a>

    </li>
    <li class="nav-item {{ Request::is('promoter.taget') ? 'active' : '' }} ">
        <a href="{{ url('promoter/target') }}" class="nav-link nav-toggle">
            <i class="icon-target"></i>
            <span class="title">Target</span>

        </a>

    </li>
    <li class="nav-item  ">
        <a href="{{ url('promoter/outlet') }}" class="nav-link ">
            <i class="icon-home"></i>
            <span class="title">Outlets</span>
        </a>
    </li>
    <li class="nav-item {{ Request::is('/') ? 'active' : '' }}  ">
        <a href="{{ url('promoter.model') }}" class="nav-link nav-toggle">
            <i class="icon-basket"></i>
            <span class="title">Models</span>

        </a>

    </li>
    
    

</ul>
