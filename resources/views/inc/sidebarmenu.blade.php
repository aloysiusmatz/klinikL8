<!-- Brand Logo -->
<a href="#" class="brand-link">
    <span class="brand-text font-weight-light" style="margin-left:20px;">@include('inc.companyname')</span>
</a>

<!-- Sidebar -->
<div class="sidebar">
    <!-- Sidebar user (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            <!--<img src="/adminlte/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">-->
        </div>
        <div class="info">
            <a href="#" class="d-block">Welcome, {{Auth::user()->name}}</a>
            {{-- @if(Auth::user()->hasRole('level1'))
                <a href="#" class="d-block" style="font-size:10pt;">User</a>
            @elseif(Auth::user()->hasRole('level2'))
                <a href="#" class="d-block" style="font-size:10pt;">Manager</a>
            @elseif(Auth::user()->hasRole('level3'))
                <a href="#" class="d-block" style="font-size:10pt;">Owner</a>
            @elseif(Auth::user()->hasRole('level4'))
                <a href="#" class="d-block" style="font-size:10pt;">Developer</a>
            @endif --}}
        </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        
        @can('show medrec')
        <li class="nav-item">
            <a href="{{route('medrec.index')}}" class="nav-link">
                <i class="nav-icon fas fa-book"></i>
                <p>
                Medical Records
                </p>
            </a>
        </li>
        @endcan


        @can('show checkup')
        <li class="nav-header">REPORTS</li>
        <li class="nav-item">
        <a href="{{ route('checkup.index') }}" class="nav-link">
            <i class="nav-icon fas fa-book"></i>
            <p>
            Checkup
            </p>
        </a>
        </li> 
        @endcan

        @canany('show general setting'||'show user setting')
        <li class="nav-header">SETTINGS</li>
        @endcanany

        <li class="nav-item">
        @can('show general setting')
            <a href="{{ route('gensettings.index') }}" class="nav-link">
                <i class="nav-icon fas fa-book"></i>
                <p>
                General Settings
                </p>
            </a>
        @endcan
        </li>

        <li class="nav-item">
        @can('show user setting')
        <a href="{{ route('usrsettings.index') }}" class="nav-link">
            <i class="nav-icon fas fa-book"></i>
            <p>
            User Settings
            </p>
        </a>
        @endcan
        </li>
        
    </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->