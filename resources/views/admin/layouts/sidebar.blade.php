<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li style="padding: 10px;">
                <div class="dropdown profile-element">
                    <a href="{{route('admin.dashboard')}}" target="_blank">
                        <img alt="image" src="{{ asset('backend/assets/image/logo.png') }}" style="height: 50px;width: 100%;" />
                    </a>
                </div>
                <div class="logo-element">
                    <a href="{{route('admin.dashboard')}}" target="_blank">
                        <img alt="image" src="{{ asset('backend/assets/image/small_logo.png') }}" style="height: 50px;width: 100%;" />
                    </a>
                </div>
            </li>
            @can('dashboard')
                <li @if(in_array(Route::currentRouteName(), ['admin.dashboard'])) class="active" @endif>
                    <a href="{{route('admin.dashboard')}}"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboard</span></a>
                </li>
            @endcan

            @can('user-index')
                <li @if(in_array(Route::currentRouteName(), ['admin.users.index','admin.users.create','admin.users.edit','admin.user.documnet.detail','admin.user.team'])) class="active" @endif>
                    <a href="{{route('admin.users.index')}}"><i class="fa fa-users"></i> <span class="nav-label">User</span></a>
                </li>
            @endcan

            <li @if(in_array(Route::currentRouteName(), ['admin.campaigns.index','admin.campaigns.create','admin.campaigns.edit'])) class="active" @endif>
                <a href="{{route('admin.campaigns.index')}}"><i class="fa fa-bullhorn"></i> <span class="nav-label">Campaign</span></a>
            </li>

            <li @if(in_array(Route::currentRouteName(), ['admin.campaign.donation'])) class="active" @endif>
                <a href="{{route('admin.campaign.donation')}}"><i class="fas fa-hand-holding-usd"></i> <span class="nav-label">Campaign Donation</span></a>
            </li>

            <li @if(in_array(Route::currentRouteName(), ['admin.event.index','admin.event.create','admin.event.edit'])) class="active" @endif>
                <a href="{{route('admin.event.index')}}"><i class="fas fa-calendar-alt"></i> <span class="nav-label">Event</span></a>
            </li>

            <li @if(in_array(Route::currentRouteName(), ['admin.image.index','admin.image.create'])) class="active" @endif>
                <a href="{{route('admin.image.index')}}"><i class="fas fa-images"></i> <span class="nav-label">Image</span></a>
            </li>

            <li @if(in_array(Route::currentRouteName(), ['admin.about.index','admin.about.create'])) class="active" @endif>
                <a href="{{route('admin.about.index')}}"><i class="fas fa-info-circle"></i> <span class="nav-label">About</span></a>
            </li>

            <li @if(in_array(Route::currentRouteName(), ['admin.social.index','admin.social.create'])) class="active" @endif>
                <a href="{{route('admin.social.index')}}"><i class="fas fa-podcast"></i> <span class="nav-label">Social Link</span></a>
            </li>

            @canany(['role-list','staff-list'])
                <li @if(in_array(Route::currentRouteName(), ['admin.roles.index','admin.roles.create','admin.roles.edit','admin.staffs.index','admin.staffs.create','admin.staffs.edit'])) class="active" @endif>
                    <a href="#"><i class="fa fa-users-cog"></i> <span class="nav-label">Staff Management</span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level">
                        @can('role-list')
                            <li @if(in_array(Route::currentRouteName(), ['admin.roles.index','admin.roles.create','admin.roles.edit'])) class="active" @endif><a href="{{route('admin.roles.index')}}">Role</a></li>
                        @endcan

                        @can('staff-list')
                            <li @if(in_array(Route::currentRouteName(), ['admin.staffs.index','admin.staffs.create','admin.staffs.edit'])) class="active" @endif><a href="{{route('admin.staffs.index')}}">Staff</a></li>
                        @endcan
                    </ul>
                </li>
            @endcanany

        </ul>
    </div>
</nav>
