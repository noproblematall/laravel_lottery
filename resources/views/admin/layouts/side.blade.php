@php
  $page = session('page');  
@endphp
  <div class="br-logo">
    <a href="{{route('welcome')}}">
      {{-- <img src="{{asset('img/logo.png')}}" alt="LOGO" width="45" srcset=""> --}}
      LOGO
    </a>
  </div>

  <div class="br-sideleft sideleft-scrollbar">
    <label class="sidebar-label pd-x-10 mg-t-20 op-3 text-center">{{ $user->role->type }}</label>
    <ul class="br-sideleft-menu">

      <li class="br-menu-item">
        <a href="{{route('admin.home')}}" class="br-menu-link {{ $page==='home' ? 'active' : null }}">
          <i class="menu-item-icon icon ion-ios-home-outline tx-24"></i>
          <span class="menu-item-label">Dashboard</span>
        </a>
      </li>

      <li class="br-menu-item">
        <a href="{{route('admin.user_manage')}}" class="br-menu-link {{ $page==='user_manage' ? 'active' : null }}">
          <i class="menu-item-icon icon ion-person-stalker tx-24"></i>
          <span class="menu-item-label">User Management</span>
        </a>
      </li>
      
      <li class="br-menu-item">
        <a href="{{route('admin.lottery_manage')}}" class="br-menu-link {{ $page==='lottery_manage' ? 'active' : null }}">
          <i class="menu-item-icon icon fa fa-trophy tx-20"></i>
          <span class="menu-item-label">Lottery Management</span>
        </a>
      </li>

      <li class="br-menu-item">
        <a href="{{route('admin.order_manage')}}" class="br-menu-link {{ $page==='order_manage' ? 'active' : null }}">
          <i class="menu-item-icon icon ion-briefcase tx-20"></i>
          <span class="menu-item-label">Order History</span>
        </a>
      </li>

      <li class="br-menu-item">
        <a href="{{route('admin.setting')}}" class="br-menu-link {{ $page==='setting' ? 'active' : null }}">
          <i class="menu-item-icon icon ion-gear-b tx-24"></i>
          <span class="menu-item-label">Setting</span>
        </a>
      </li>      

    </ul>
    <br>
  </div>