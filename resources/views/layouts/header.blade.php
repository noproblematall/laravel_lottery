<div class="br-header">
    <div class="br-header-left">
        <div class="navicon-left hidden-md-down"><a id="btnLeftMenu" href=""><i class="icon ion-navicon-round"></i></a></div>
        <div class="navicon-left hidden-lg-up"><a id="btnLeftMenuMobile" href=""><i class="icon ion-navicon-round"></i></a></div>
        
    </div><!-- br-header-left -->
    <div class="br-header-right">
        <nav class="nav">                
            <div class="dropdown">
                <a href="javascript:void(0);" class="nav-link nav-link-profile" data-toggle="dropdown">
                    <span class="logged-name hidden-md-down">{{$user->username}}</span>
                    @if ($user->photo)
                        <img src="{{asset($user->photo)}}" class="wd-32 rounded-circle" alt="">                        
                    @else
                        <img src="{{asset('img/avatar.png')}}" class="wd-32 rounded-circle" alt="">     
                    @endif
                    <span class="square-10 bg-success"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-header wd-250">
                <div class="tx-center">
                    @if ($user->photo)
                        <img src="{{asset($user->photo)}}" class="wd-32 rounded-circle" alt="">                        
                    @else
                        <img src="{{asset('img/avatar.png')}}" class="wd-32 rounded-circle" alt="">     
                    @endif
                    <h6 class="logged-fullname">{{$user->username}}</h6>
                    <p>{{$user->email}}</p>
                </div>
                <hr>
                <ul class="list-unstyled user-profile-nav">
                    <li id="profile"><a href="javascript:void(0);"><i class="icon ion-ios-person"></i> Edit Profile</a></li>
                    <li id="password_change"><a href="javascript:void(0);"><i class="icon ion-unlocked"></i> Change Password</a></li>
                    <li>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();"><i class="icon ion-power"></i> Sign Out</a>
                    </li>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>

                </ul>
                </div><!-- dropdown-menu -->
            </div><!-- dropdown -->
        </nav>
    </div><!-- br-header-right -->
</div><!-- br-header -->