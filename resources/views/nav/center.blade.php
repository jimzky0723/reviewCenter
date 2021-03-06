<!-- sidebar menu -->
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <br />
        <h3>Main Menu</h3>
        <ul class="nav side-menu">
            <?php
                $count = \App\Http\Controllers\center\HomeCtrl::countAnnouncement();
            ?>
            <li><a href="{{ asset('center/home') }}"><i class="fa fa-home"></i> Dashboard
                    @if($count>0)
                        <span class="badge pull-right">{{ $count }} New</span>
                    @endif
                </a></li>
            <li><a href="{{ asset('center/announcement') }}"><i class="fa fa-bullhorn"></i> Announcements</a></li>
            <li><a href="{{ asset('center/class') }}"><i class="fa fa-book"></i> Subjects</a></li>
        </ul>
    </div>
    <div class="menu_section">
        <h3>Instructors and Reviewees</h3>
        <?php
        $center_id = Session::get('center');
        $users = \App\User::where('center_id',$center_id)
            ->where('level','reviewee')
            ->where('status','pending')
            ->count();
        $user2 = \App\User::where('center_id',$center_id)
            ->where('level','instructor')
            ->where('status','pending')
            ->count();
        ?>
        <ul class="nav side-menu">
            <li><a href="{{ asset('center/instructor') }}"><i class="fa fa-user"></i> Instructors
                    @if($user2>0)
                        <span class="badge pull-right">{{ $user2 }} Pending</span>
                    @endif
                </a></li>
            <li>


                <a href="{{ asset('center/reviewee') }}"><i class="fa fa-group"></i> Students
                    @if($users>0)
                        <span class="badge pull-right">{{ $users }} Pending</span>
                    @endif
                </a>
            </li>
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