<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel='icon' href='{{asset('img/lottory.ico')}}' type='image/x-icon'/>
    
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="{{asset('css/app.css')}}">

    <!-- jQuery library -->
    <script src="{{asset('js/app.js')}}"></script>  
    <link rel="stylesheet" href="{{asset('css/custom.css')}}">
    <link rel="stylesheet" href="{{asset('library/spinkit/css/spinkit.css')}}">
    <title>{{ config('app.name') }}</title>
    <style>
        .invalid-feedback {color: #fdb702;display: block;}
        .logo {position: relative;}
        div.desktop_menu .logo > a {position: absolute; top: -7px; left: 0;}
        header div.real_container {background-image: none;}
    </style>
</head>
<body>
    <div class="custom-container">
        <header id="header">
            <div class="real_container container-fluid">
                <div class="row header_menu desktop_menu">
                    <div class="col-md-5 left_menu">
                        <div class="logo"><a href="{{ route('welcome') }}" id="logo"><img src="{{ asset('img/Logo-Flowy-Lottery-dark-background2.png') }}" alt="LOGO" width="200" srcset=""></a></div>
                        <ul class="float-right">
                            <li><a href="{{route('welcome')}}">HOMEPAGE</a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="col-md-2 text-center">
                        <div class="bit_price"><svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="btc" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" class="svg-inline--fa fa-btc fa-w-12 fa-2x"><path fill="currentColor" d="M310.204 242.638c27.73-14.18 45.377-39.39 41.28-81.3-5.358-57.351-52.458-76.573-114.85-81.929V0h-48.528v77.203c-12.605 0-25.525.315-38.444.63V0h-48.528v79.409c-17.842.539-38.622.276-97.37 0v51.678c38.314-.678 58.417-3.14 63.023 21.427v217.429c-2.925 19.492-18.524 16.685-53.255 16.071L3.765 443.68c88.481 0 97.37.315 97.37.315V512h48.528v-67.06c13.234.315 26.154.315 38.444.315V512h48.528v-68.005c81.299-4.412 135.647-24.894 142.895-101.467 5.671-61.446-23.32-88.862-69.326-99.89zM150.608 134.553c27.415 0 113.126-8.507 113.126 48.528 0 54.515-85.71 48.212-113.126 48.212v-96.74zm0 251.776V279.821c32.772 0 133.127-9.138 133.127 53.255-.001 60.186-100.355 53.253-133.127 53.253z" class=""></path></svg>&nbsp;1 = {{$usd}}USD</div>
                    </div>
                    <div class="col-md-5 right_menu">
                        @if (Route::has('login'))
                            <ul class="float-right">
                                @auth
                                    <li><a href="{{ url('/home') }}">DASHBOARD</a></li>
                                    <li>
                                        <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();"><i class="icon ion-power"></i>LOGOUT</a>
                                    </li>
                
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                @else
                                    <li><a href="{{ route('login') }}">LOGIN</a></li>
            
                                    @if (Route::has('register'))
                                        <li><a href="{{ route('register') }}">REGISTER</a></li>
                                    @endif
                                @endauth
                            </ul>
                        @endif
                        
                    </div>
                </div>
                <div class="row mobile_menu">
                    <div class="mobile_nav">
                        <div class="logo"><a href="{{asset('/')}}" ><img src="{{ asset('img/Logo-Flowy-Lottery-light-background2.png') }}" alt="LOGO" width="70" srcset=""></a></div>
                        <div class="bit_price"><svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="btc" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" class="svg-inline--fa fa-btc fa-w-12 fa-2x"><path fill="currentColor" d="M310.204 242.638c27.73-14.18 45.377-39.39 41.28-81.3-5.358-57.351-52.458-76.573-114.85-81.929V0h-48.528v77.203c-12.605 0-25.525.315-38.444.63V0h-48.528v79.409c-17.842.539-38.622.276-97.37 0v51.678c38.314-.678 58.417-3.14 63.023 21.427v217.429c-2.925 19.492-18.524 16.685-53.255 16.071L3.765 443.68c88.481 0 97.37.315 97.37.315V512h48.528v-67.06c13.234.315 26.154.315 38.444.315V512h48.528v-68.005c81.299-4.412 135.647-24.894 142.895-101.467 5.671-61.446-23.32-88.862-69.326-99.89zM150.608 134.553c27.415 0 113.126-8.507 113.126 48.528 0 54.515-85.71 48.212-113.126 48.212v-96.74zm0 251.776V279.821c32.772 0 133.127-9.138 133.127 53.255-.001 60.186-100.355 53.253-133.127 53.253z" class=""></path></svg>&nbsp;1 = {{$usd}}USD</div>
                        <div class="menu_icon" id="menu_icon">
                            <div class="bar1"></div>
                            <div class="bar2"></div>
                            <div class="bar3"></div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="sub_menu" id="sub_menu">
                        <ul>
                            @if (Route::has('login'))
                                @auth
                                    <li><a href="{{ url('/home') }}">DASHBOARD</a></li>
                                    <li><a href="{{ route('logout') }}">LOGOUT</a></li>
                                @else
                                    <li><a href="{{ route('login') }}">LOGIN</a></li>
            
                                    @if (Route::has('register'))
                                        <li><a href="{{ route('register') }}">REGISTER</a></li>
                                    @endif
                                @endauth
                            @endif
                            <li><a href="{{route('welcome')}}">HOMEPAGE</a></li>
                        </ul>
                    </div>
                </div>
                <div class="row win_address">
                    <div class="col-md-12">
                        <p><span><a href="https://www.blockchain.com/btc/address/1E9T1LLFnofgRnWxNMypRUhdDZecWP4vR2" target="_blank">1E9T1LLFnofgRnWxNMypRUhdDZecWP4vR2</a></span></p>
                    </div>
                </div>                
            </div>
        </header>

        <section class="result_table">
            <div class="real_container container-fluid">
                @if ($id == 1)
                    <div class="row">
                        <div class="col-md-12 text-left">
                            <div class="custom_table table-responsive">
                                <h3>Winners table Superbit1</h3>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Data</th>
                                            <th>Ganhador</th>
                                            <th>Valor</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!$lottery->isEmpty())
                                        
                                            @foreach ($lottery as $item)
                                                <tr>
                                                    @if (!empty($item->tickets()->find($item->win_of_prize1)))
                                                        <td>{{ date("d/m/Y", strtotime($item->date)) }}</td>
                                                        <td><a href="https://www.blockchain.com/btc/address/{{ $item->tickets()->find($item->win_of_prize1)->user->invoices()->first()->wallet_address }}" target="_blank">{{ $item->tickets()->find($item->win_of_prize1)->user->invoices()->first()->wallet_address }}</a></td>
                                                        <td>{{ $item->total_bitcoin * 0.4 }} ({{ round($item->total_bitcoin * 0.4 * $usd, 2) }}USD)</td>                                                    
                                                    @endif
                                                </tr>
                                            @endforeach
                                        @endif                                    
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>                    
                @endif
                @if ($id == 2)
                    <div class="row">
                        <div class="col-md-12 text-left">
                            <div class="custom_table table-responsive">
                                <h3>Winners table Superbit2</h3>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Data</th>
                                            <th>Ganhador</th>
                                            <th>Valor</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!$lottery->isEmpty())
                                        
                                            @foreach ($lottery as $item)
                                                @if (!empty($item->tickets()->find($item->win_of_prize1)))
                                                    <tr>
                                                        <td>{{ date("d/m/Y", strtotime($item->date)) }}</td>
                                                        <td><a href="https://www.blockchain.com/btc/address/{{ $item->tickets()->find($item->win_of_prize2)->user->invoices()->first()->wallet_address }}" target="_blank">{{ $item->tickets()->find($item->win_of_prize2)->user->invoices()->first()->wallet_address }}</a></td>
                                                        <td>{{ $item->total_bitcoin * 0.15 }} ({{ round($item->total_bitcoin * 0.15 * $usd, 2) }}USD)</td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        @endif 
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>                    
                @endif
                @if ($id == 3)
                    <div class="row">
                        <div class="col-md-12 text-left">
                            <div class="custom_table table-responsive">
                                <h3>Winners table Superbit3</h3>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Data</th>
                                            <th>Ganhador</th>
                                            <th>Valor</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!$lottery->isEmpty())
                                            @foreach ($lottery as $item)
                                                @if (!empty($item->tickets()->find($item->win_of_prize1)))
                                                    <tr>
                                                        <td>{{ date("d/m/Y", strtotime($item->date)) }}</td>
                                                        <td><a href="https://www.blockchain.com/btc/address/{{ $item->tickets()->find($item->win_of_prize3)->user->invoices()->first()->wallet_address }}" target="_blank">{{ $item->tickets()->find($item->win_of_prize3)->user->invoices()->first()->wallet_address }}</a></td>
                                                        <td>{{ $item->total_bitcoin * 0.05 }} ({{ round($item->total_bitcoin * 0.05 * $usd, 2) }}USD)</td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        @endif 
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>                    
                @endif
            </div>
        </section>
       
        <footer>
            <div class="real_container container-fluid">
                <div class="row text-center desktop_footer">
                    <div class="col-4">
                        <div class="float-right text-left">
                            <h3 class="mb-4">Flowy Lottery 2019</h3>
                            <ul>
                                <li><a href="#" target="_blank"><img src="https://public-images.flowybusinesses.com/img/Facebook.png" alt="Facebook"></a></li>
                                <li><a href="#" target="_blank"><img src="https://public-images.flowybusinesses.com/img/Instagram.png" alt="Instagram"></a></li>
                                <li><a href="#" target="_blank"><img src="https://public-images.flowybusinesses.com/img/youtube.png" alt="Youtube"></a></li>
                            </ul>
                            <h3 class="mt-2">About us</h3>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="col-4">
                        <a href="{{ route('welcome') }}"><img src="{{ asset('img/Logo-Flowy-Lottery-light-background2.png') }}" alt="LOGO" width="110" srcset=""></a>
                    </div>
                    <div class="col-4 text-left">
                        <h3>Support</h3>
                        <h3>contact@flowylottery.com</h3>
                        <h3>(206) 260-3588</h3>
                    </div>
                </div>
                <div class="row text-center mobile_footer">
                    <div class="col-12 text-left mb-3">
                        <a href="{{ route('welcome') }}"><img src="{{ asset('img/Logo-Flowy-Lottery-light-background2.png') }}" alt="LOGO" width="70" srcset=""></a>
                    </div>
                    <div class="col-12">
                        <div class="text-left">
                            <h3 class="mb-2">Flowy Lottery 2019</h3>
                            <ul>
                                <li><a href="#" target="_blank"><img src="https://public-images.flowybusinesses.com/img/Facebook.png" alt="Facebook"></a></li>
                                <li><a href="#" target="_blank"><img src="https://public-images.flowybusinesses.com/img/Instagram.png" alt="Instagram"></a></li>
                                <li><a href="#" target="_blank"><img src="https://public-images.flowybusinesses.com/img/youtube.png" alt="Youtube"></a></li>
                            </ul>
                            <h3 class="mt-2">About us</h3>
                        </div>
                        <div class="clearfix"></div>
                    </div>                    
                    <div class="col-12 text-left mt-3">
                        <h3>Support</h3>
                        <h3>contact@flowylottery.com</h3>
                        <h3>(206) 260-3588</h3>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <div class="loader_container display_none">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1 bg-gray-800"></div>
            <div class="sk-child sk-bounce2 bg-gray-800"></div>
            <div class="sk-child sk-bounce3 bg-gray-800"></div>
        </div>
    </div>
    {{-- <script src="{{asset('js/custom.js')}}"></script> --}}
    
</body>
</html>