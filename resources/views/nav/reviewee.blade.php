<!-- sidebar menu -->
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <br />
        <h3>Main Menu</h3>
        <ul class="nav side-menu">
            <?php
                $count = \App\Http\Controllers\reviewee\HomeCtrl::countAnnouncement();
            ?>
            <li><a href="{{ asset('reviewee/home') }}"><i class="fa fa-home"></i> Dashboard
                @if($count>0)
                    <span class="badge pull-right">{{ $count }} New</span>
                @endif
                </a>
            </li>
            <li><a href="{{ asset('reviewee/class') }}"><i class="fa fa-book"></i> My Subjects</a></li>
            <li><a href="#feedbackModal" data-toggle="modal"><i class="fa fa-book"></i> Feedback</a></li>
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