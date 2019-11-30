@php
  $page = session('page');  
@endphp
  <div class="br-logo">
    <a href="{{route('welcome')}}">
        <img src="{{asset('img/Logo-Flowy-Lottery-05.png')}}" alt="LOGO" width="150" srcset="">
    </a>
  </div>

  <div class="br-sideleft sideleft-scrollbar">
    <label class="sidebar-label pd-x-10 mg-t-20 op-3 text-center">{{ $user->role->type }}</label>
    <ul class="br-sideleft-menu">

      <li class="br-menu-item">
        <a href="{{route('home')}}" class="br-menu-link {{ $page==='home' ? 'active' : null }}">
          <i class="menu-item-icon icon ion-ios-home-outline tx-24"></i>
          <span class="menu-item-label">Dashboard</span>
        </a>
      </li>

      <li class="br-menu-item">
        <a href="{{route('history')}}" class="br-menu-link {{ $page==='history' ? 'active' : null }}">
          <i class="menu-item-icon icon ion-clock tx-24"></i>
          <span class="menu-item-label">Ticket History</span>
        </a>
      </li> 

      <li class="br-menu-item">
        <a href="{{route('order_history')}}" class="br-menu-link {{ $page==='order_history' ? 'active' : null }}">
          <i class="menu-item-icon icon ion-briefcase tx-24"></i>
          <span class="menu-item-label">Order History</span>
        </a>
      </li>      

    </ul>
    <br>
  </div>