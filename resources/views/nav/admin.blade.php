<!-- sidebar menu -->
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <br />
        <h3>Main Menu</h3>
        <ul class="nav side-menu">
            <li><a href="{{ asset('admin/home') }}"><i class="fa fa-home"></i> Dashboard</a></li>
            <?php
                $countCenter = \App\Center::where('status','inactive')->count();
            ?>
            <li><a href="{{ asset('admin/center') }}"><i class="fa fa-building"></i> Review Centers
                @if($countCenter>0)
                <span class="badge pull-right">{{ $countCenter }} Pending</span>
                @endif
                </a></li>
            <li><a href="{{ asset('admin/announcement') }}"><i class="fa fa-bullhorn"></i> Announcements</a></li>
            <li><a href="{{ asset('admin/payment') }}"><i class="fa fa-money"></i> Payment Status</a></li>
        </ul>
    </div>
    <div class="menu_section">
        <h3>Settings</h3>
        <ul class="nav side-menu">
            <li><a href="#"><i class="fa fa-gear"></i> Change Password</a></li>
            <li><a href="{{ asset('logout') }}"><i class="fa fa-sign-out"></i> Logout</a></li>
        </ul>
    </div>

</div>
<!-- /sidebar menu -->