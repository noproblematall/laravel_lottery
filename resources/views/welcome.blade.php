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
    <script src="{{('js/app.js')}}"></script>  
    <link rel="stylesheet" href="{{asset('css/custom.css')}}">
    <link rel="stylesheet" href="{{asset('library/spinkit/css/spinkit.css')}}">
    <title>{{ config('app.name') }}</title>
    <style>
        .invalid-feedback {color: #fdb702;display: block;}
        .more_view {background-color:#FDB702;margin-top: 20px;font-size: 16px;padding: 5px 50px;border: none;border-radius: 20px;color:#3F1268;font-weight: bold;}
        .logo {position: relative;}
        div.desktop_menu .logo > a {position: absolute; top: -7px; left: 0;}
        .buy_tickets {background-color:#fdb702;font-weight:bold;border-radius: 20px;color: #24126A;border: none;}
        #last_prize .time h2{position: relative;}
        
    </style>
    {!! htmlScriptTagJsApi() !!}
</head>
<body>
    <div class="custom-container">
        <header id="header">
            <div class="real_container container-fluid">
                <div class="row header_menu desktop_menu">
                    <div class="col-md-5 left_menu">
                        <div class="logo"><a href="{{ route('welcome') }}" id="logo"><img src="{{ asset('img/Logo-Flowy-Lottery-dark-background2.png') }}" alt="LOGO" width="200" srcset=""></a></div>
                        <ul class="float-right">
                            <li><a href="#how_work">How it Works</a></li>
                            <li><a href="#last_prize">Last prizes</a></li>
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
                            <li><a href="#how_work">How it Works</a></li>
                            <li><a href="#last_prize">Last prizes</a></li>
                        </ul>
                    </div>
                </div>
                <div class="row win_address">
                    <div class="col-md-12">
                        <p><span><a href="https://www.blockchain.com/btc/address/1E9T1LLFnofgRnWxNMypRUhdDZecWP4vR2" target="_blank">1E9T1LLFnofgRnWxNMypRUhdDZecWP4vR2</a></span></p>
                    </div>
                </div>
                <div class="row banner text-center">
                    <div class="col-md-12">
                        <p class="mt-2">Next Prize</p>
                        <h1>{{round($today_bitcoin, 8)}} btc</h1>
                        <p class="usd_now">( {{round($today_bitcoin * $usd, 2)}} USD )</p>
                        {{-- <h1>{{round($next_prize, 8)}} btc</h1>
                        <p class="usd_now">( {{round($next_prize * $usd, 2)}} USD )</p> --}}
                        <p>Accumulated Value</p>
                    </div>
                </div>
                <div class="row prizes text-center">
                    <div class="col-md-4">
                        <div class="prize_one item">
                            <p>SuperFlowy</p>
                            <div>
                                <p>{{round($prize1, 8)}} btc</p>
                                <p>( {{round($prize1 * $usd, 2)}} USD )</p>
                            </div>                            
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="prize_two item">
                            <p>MegaBitcoins</p>
                            <div>
                                <p>{{round($prize2, 8)}} btc</p>
                                <p>( {{round($prize2 * $usd, 2)}} USD )</p>
                            </div>                            
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="prize_three item">
                            <p>LuckyBitcoin</p>
                            <div>
                                <p>{{round($prize3, 8)}} btc</p>
                                <p>( {{round($prize3 * $usd, 2)}} USD )</p>
                            </div>                            
                        </div>
                    </div>
                </div>
                <form action="{{route('post_home')}}" method="post" id="{{ getFormId() }}">
                    @csrf
                    <div class="row ticket_buy mb-4">
                        <div class="col-md-3">
                            @auth
                                <input type="email" name="email" id="email" class="form-control" value="" placeholder="E-mail" disabled readonly>                                
                            @else
                                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" placeholder="E-mail">
                                @error('email')
                                    <span class="invalid-feedback" style="display: block;margin-left: 10px;" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            @endauth
                            
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="wallet_address" id="wallet_address" class="form-control" value="{{ old('wallet_address') }}" placeholder="Wallet Address">
                            <span class="invalid-feedback display_none wallet_invalid"  style=" margin-left: 10px;" role="alert">
                                <strong>Invalid wallet address</strong>
                            </span>
                            @error('wallet_address')
                                <span class="invalid-feedback" style="display: block; margin-left: 10px;" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <select name="bit_number" id="bit_number" class="custom-select custom-select2">
                                <option value="1">1 Ticket - ({{$bit_per_ticket}} USD)</option>
                                <option value="5">5 Ticket - 2% Off({{$bit_per_ticket * 5 - ($bit_per_ticket * 5 * 0.02)}} USD)</option>
                                <option value="10">10 Ticket - 5% Off({{$bit_per_ticket * 10 - ($bit_per_ticket * 10 * 0.05)}} USD)</option>
                                <option value="50">50 Ticket - 7.5% Off({{$bit_per_ticket * 50 - ($bit_per_ticket * 50 * 0.075)}} USD)</option>
                                <option value="100">100 Ticket - 10% Off({{$bit_per_ticket * 100 - ($bit_per_ticket * 100 * 0.1)}} USD)</option>
                                <option value="250">250 Ticket - 15% Off({{$bit_per_ticket * 250 - ($bit_per_ticket * 250 * 0.15)}} USD)</option>
                                <option value="500">500 Ticket - 20% Off({{$bit_per_ticket * 500 - ($bit_per_ticket * 500 * 0.2)}} USD)</option>
                                <option value="1000">1000 Ticket - 25% Off({{$bit_per_ticket * 1000 - ($bit_per_ticket * 1000 * 0.25)}} USD)</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            {!! htmlFormButton('Buy tickets', [
                                'class' => 'form-control buy_tickets',
                                'id' => 'submit_btn',
                                // 'type' => 'button',
                            ]) !!}
                            {{-- <input type="button" name="submit_btn" id="submit_btn" class="form-control buy_tickets" style="background-color:#fdb702;font-weight:bold;" value="Buy tickets"> --}}
                        </div>
                    </div>
                </form>
            </div>
        </header>
        <section id="last_prize">
            <div class="real_container container-fluid">
                <div class="row last_time">
                    <div class="col-md-12 text-center">
                        <p class="normal_text">Last for next prize</p>
                        <div class="time mt-2">
                            <img src="{{asset('img/clock.png')}}" alt="CLOCK" srcset="">
                            <h2><span id="count_hour"></span>&nbsp;<span id="count_second">:</span>&nbsp;<span id="count_min"></span></h2>
                        </div>
                        <p class="today_date">{{$result}}</p>
                        <p class="grinich">Currently Greenwich Mean Time (GMT), UTC +0</p>
                        <a href="#form_submit" class="btn btn-primary btn-sm">Buy tickets</a>
                    </div>
                </div>
            </div>
        </section>
        <section>
            <div class="real_container container-fluid">
                <div class="row chart">
                    <div class="col-md-12">
                        <div class="" id="chart"></div>
                        <p>Our wallet's timeline</p>
                    </div>
                </div>
            </div>
        </section>
        <section class="last_winner mt-5">
            <div class="real_container container-fluid">
                <div class="row accumulated">
                    <div class="col-md-12 text-center">
                        <h4>Last Winners</h4>
                        @if ($last_lottery->exists())
                            <h2>{{round($last_lottery->first()->total_bitcoin, 8)}} btc</h2>
                            <h3>( {{round($last_lottery->first()->total_bitcoin * $usd, 2)}} USD )</h3>
                        @endif
                        <h4>Total accumulated</h4>
                    </div>
                </div>
                <div class="row prize_1 mt-5">
                    <div class="col-md-6">
                        <div class="float-right text-center">
                            <h4>SuperFlowy</h4>
                            <div class="prize">
                                @if ($last_lottery->exists())
                                    <h2>{{round($last_lottery->first()->total_bitcoin * 0.05, 8)}}btc</h2>
                                    <p>( {{round($last_lottery->first()->total_bitcoin * 0.05 * $usd, 2)}} USD )</p>
                                @else
                                    <h2>Not yet</h2>
                                    <p>Not yet</p>
                                @endif
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="col-md-6 text-left">
                        <div>
                            <p>Bitcoin address:</p>
                            @if ($last_lottery->exists())
                                <p><a href="https://www.blockchain.com/btc/address/{{ $last_lottery->first()->tickets()->find($last_lottery->first()->win_of_prize1)->user->invoices()->first()->wallet_address }}" target="_blank">{{ $last_lottery->first()->tickets()->find($last_lottery->first()->win_of_prize1)->user->invoices()->first()->wallet_address }}</a></p>                                
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row prize_2 mt-4">
                    <div class="col-md-6">
                        <div class="float-right text-center mr-3">
                            <h4>MegaBitcoins</h4>
                            <div class="prize">
                                @if ($last_lottery->exists())
                                    <h2>{{round($last_lottery->first()->total_bitcoin * 0.15, 8)}}btc</h2>
                                    <p>( {{round($last_lottery->first()->total_bitcoin * 0.15 * $usd, 2)}} USD )</p>
                                @else
                                    <h2>Not yet</h2>
                                    <p>Not yet</p>
                                @endif
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="col-md-6 text-left">
                        <div>
                            <p>Bitcoin address:</p>
                            @if ($last_lottery->exists())
                                <p><a href="https://www.blockchain.com/btc/address/{{ $last_lottery->first()->tickets()->find($last_lottery->first()->win_of_prize2)->user->invoices()->first()->wallet_address }}" target="_blank">{{ $last_lottery->first()->tickets()->find($last_lottery->first()->win_of_prize2)->user->invoices()->first()->wallet_address }}</a></p>                            
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row prize_3 mt-4">
                    <div class="col-md-6">
                        <div class="float-right text-center mr-3">
                            <h4>LuckyBitcoin</h4>
                            <div class="prize">
                                @if ($last_lottery->exists())
                                    <h2>{{round($last_lottery->first()->total_bitcoin * 0.4, 8)}}btc</h2>
                                    <p>( {{round($last_lottery->first()->total_bitcoin * 0.4 * $usd, 2)}} USD )</p>
                                @else
                                    <h2>Not yet</h2>
                                    <p>Not yet</p>
                                @endif
                            </div>
                            
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="col-md-6 text-left">
                        <div>
                            <p>Bitcoin address:</p>
                            @if ($last_lottery->exists())
                                <p><a href="https://www.blockchain.com/btc/address/{{ $last_lottery->first()->tickets()->find($last_lottery->first()->win_of_prize3)->user->invoices()->first()->wallet_address }}" target="_blank">{{ $last_lottery->first()->tickets()->find($last_lottery->first()->win_of_prize3)->user->invoices()->first()->wallet_address }}</a></p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-md-12 text-center">
                        <a href="#form_submit" class="btn btn-sm buy_ticket">Buy tickets</a>
                    </div>
                </div>
            </div>
        </section>
        <section class="result_table">
            <div class="real_container container-fluid">
                <div class="row">
                    <div class="col-md-12 text-left">
                        <div class="custom_table table-responsive">
                            <h3>Winners table SuperFlowy</h3>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Winner</th>
                                        <th>Prize</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!$last_four_lottery->isEmpty())
                                    
                                        @foreach ($last_four_lottery as $item)
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
                            @if ($more_flag)
                                <a href="{{ route('more_view', 1) }}" class="btn btn-sm more_view text-center">More view</a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-left">
                        <div class="custom_table table-responsive">
                            <h3>Winners table MegaBitcoins</h3>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Winner</th>
                                        <th>Prize</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!$last_four_lottery->isEmpty())
                                    
                                        @foreach ($last_four_lottery as $item)
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
                                @if ($more_flag)
                                    <a href="{{ route('more_view', 2) }}" class="btn btn-sm more_view">More view</a>
                                @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-left">
                        <div class="custom_table table-responsive">
                            <h3>Winners table LuckyBitcoin</h3>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Winner</th>
                                        <th>Prize</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!$last_four_lottery->isEmpty())
                                        @foreach ($last_four_lottery as $item)
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
                                @if ($more_flag)
                                    <a href="{{ route('more_view', 3) }}" class="btn btn-sm more_view">More view</a>
                                @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="bitcoin_sum bit_bg_primary mt-5">
            <div class="real_container container-fluid">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <div class="">
                            <h2>{{round($sent_sum, 8)}}btc</h2>
                            <h3>{{round($sent_sum * $usd, 2)}}USD</h3>
                            <p>Amount Paid</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="prize_percent bit_bg_second">
            <div class="real_percent">
                <div class="real_container container-fluid">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <div class="">
                                <h2>30%</h2>
                                <p>Probability of winning</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="bit_bg_second number_prize">
            <div class="real_container container-fluid">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <div class="">
                            <h2>{{ $prize_number }}</h2>
                            <p>Number of prizes already paid</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="how_work" id="how_work">
            <div class="real_container container-fluid text-center">
                <h4>How it Works</h4>
                <div class="row mt-5">
                    <div class="col-md-4 col-12 text-center">
                        <div class="circle bit_bg_primary float-right">1</div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="col-md-8 col-12 text-left">
                        <p>We are a lottery fully based in Bitcoins. That means you will pay for the tickets with bitcoins and the prize will also be paid in Bitcoin.</p>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-md-4 text-center">
                        <div class="circle bit_bg_primary float-right">2</div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="col-md-8 pl-30 col-12 text-left">
                        <p>The lottery system will be based on tickets. You can get as many tickets as you want. Each ticket gives one chance. For instance, you can buy just one ticket, in that case, this you get one chance in the lottery. Another might prefer to buy 10 tickets, which will make him have 10 chances and so on.</p>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-md-4 text-center">
                        <div class="circle bit_bg_primary float-right">3</div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="col-md-8 pl-30 col-12 text-left">
                        <p>There will be three winners every day. Yes, you have three chances to win with the same ticket</p>
                        <br>
                        <p>- For each prize, there will be a different lottery separately. That means three lotteries on the same day.</p>
                        <p>- Only one lottery per.</p>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-md-12 text-center">
                        <a href="#form_submit" class="btn btn-sm">Buy tickets</a>
                    </div>
                </div>
            </div>
        </section>
        <section class="question mb-5">
            <div class="real_container container-fluid text-center">
                <h4>Questions and answers</h4>
                <div class="row">
                    <div class="col-md-12">
                        <div class="accordion" id="question_accordian">
                            <div class="card card_1">
                                <div class="card-header" id="headingOne">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            <h5>1. How its works?</h5>
                                        </button>
                                    </h2>
                                </div>
                            
                                <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#question_accordian">
                                <div class="card-body">
                                    <p>The Bitcoin Lottery is the most amazing lottery and the most exciting ever seen. Yes, the most! Cause in it there will always be a winner since the draw will be based on the tickets, rather than in a random number.</p> 
                                    <p>It is fully in Bitcoin, which means you buy your tickets paying with bitcoin and you also receive your prize in bitcoin.</p>
                                    <p>The basics are, you buy tickets, each ticket allows you to participate once on each category of the lottery. After you bought the tickets you wait for the next draw. If you win your prize will be sent to your wallet within 24 hours, and you will be happy 😊!</p>
                                </div>
                                </div>
                            </div>
                            <div class="card card_2">
                                <div class="card-header" id="headingTwo">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            <h5>2. What is the difference between traditional Lotteries and The Bitcoin Lottery? And why it is better?</h5>
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#question_accordian">
                                <div class="card-body">
                                    <p>Well, first of all, we do not track the user identity here and you will not have to pay any tax on the bitcoin amount, although if you decide to convert the bitcoin amount on any FIAT currency your country may apply some changes.</p>
                                    <p>Bitcoin Lottery has the ideal system where you can concur to awesome prizes, capable of giving your life 180 degrees change, just buying a very cheap ticket.</p>
                                    <p>And the most amazing thing about it is that your chances of winning are much more real than any traditional lottery. Why is that?  Simple answer: Cause the traditional lottery makes their draws based on the randomly chosen numbers and you are supposed to guess it. The number of combinations is pharaonic and you are supposed to guess it, so your chances on those lotteries are really small, as small as one chance in a billion.  But here, the things are a lot different. Your chances will be always way bigger.</p>
                                    <p>In Bitcoin Lottery your chances are always:  The number of tickets you bought devised by the total number of participants. So even if we get one million participants, your chances will be at least 99 million times bigger than the traditional lottery.</p>
                                </div>
                                </div>
                            </div>
                            <div class="card card_3">
                                <div class="card-header" id="headingThree">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                            <h5>3. How are the tickets?</h5>
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#question_accordian">
                                <div class="card-body">
                                    <p>The price of the tickets can vary depending on the availability of the tickets. The more tickets are available, the smaller is the price. The opposite is also true. The fewer tickets are available, the higher will be the price.</p> 
                                    <p>But in general, the ticket price is around 10,00 USD (Ten dollars) each. And you get a discount if you buy big quantities.</p>
                                </div>
                                </div>
                            </div>
                            <div class="card card_4">
                                <div class="card-header" id="headingfour">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapsefour" aria-expanded="false" aria-controls="collapsefour">
                                            <h5>4. When do ticket sales close?</h5>
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapsefour" class="collapse" aria-labelledby="headingfour" data-parent="#question_accordian">
                                <div class="card-body">
                                    <p>They don`t. This is a fully automated system, that means, even in the least second before the lottery you can place your ticket. However, it is important to advise you that the blockchain payments may not be instantaneous, so we advise you that it is possible that if you buy your tickets in less than 1 hour for the next draw, than you may not take part on it.</p>
                                    <p>What happens next?</p>
                                    <p>Every time you place a ticket order, it will be standing until we get confirmation that bitcoin was received. So, if the payment of your order is confirmed after the run of the current lottery, you will take part in the next one.</p>
                                </div>
                                </div>
                            </div>
                            <div class="card card_5">
                                <div class="card-header" id="headingfive">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapsefive" aria-expanded="false" aria-controls="collapsefive">
                                            <h5>5. Who can participate?</h5>
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapsefive" class="collapse" aria-labelledby="headingfive" data-parent="#question_accordian">
                                <div class="card-body">
                                    <p>Any adult can participate. There are no requirements.</p>
                                </div>
                                </div>
                            </div>
                            <div class="card card_6">
                                <div class="card-header" id="headingsix">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapsesix" aria-expanded="false" aria-controls="collapsesix">
                                            <h5>6. When are the draws?</h5>
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapsesix" class="collapse" aria-labelledby="headingsix" data-parent="#question_accordian">
                                <div class="card-body">
                                    <p>Draws occur daily, except if the minimum amount per category is not achieved.</p>
                                    <p>Since there are three categories of the lottery, each of them has one minimum amount necessary to allow the draw to take place:</p>
                                    <ul>
                                        <li>● SuperFlowy: The minimum amount for the draw is the Bitcoin amount that in the day of the draw corresponds to 50.000,00 USD (fifty thousand dollars).</li>
                                        <li>● MegaBitcoins: The minimum amount for the draw is the Bitcoin amount that in the day of the draw corresponds to 30.000,00 USD (thirty thousand dollars).</li>
                                        <li>● LuckyBitcoin: The minimum amount for the draw is the Bitcoin amount that in the day of the draw corresponds to 5.000,00 USD (five thousand dollars).</li>
                                    </ul>
                                    <p>Note: IF on your dashboard, when logged in the information of minimum and maximum Is different than that information here you must consider that one on your dashboard over the given information here.</p>
                                </div>
                                </div>
                            </div>
                            <div class="card card_7">
                                <div class="card-header" id="headingseven">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseseven" aria-expanded="false" aria-controls="collapseseven">
                                            <h5>7. Do I participate in all the draws with just one ticket?</h5>
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseseven" class="collapse" aria-labelledby="headingseven" data-parent="#question_accordian">
                                <div class="card-body">
                                    <p>Your ticket gives you the right to participate in all the categories of the next draw.</p>
                                    <p>It is important to be attentive to what was said on item 4, as it is possible that your tickets do not get the confirmation of payment in blockchain within the necessary time to participate in the immediate next draw. In that case, your ticket will participate in the first draw that happened after its payment confirmation.</p>
                                </div>
                                </div>
                            </div>
                            <div class="card card_8">
                                <div class="card-header" id="headingeight">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseeight" aria-expanded="false" aria-controls="collapseeight">
                                            <h5>8. What procedure determinates the winner on each draw?</h5>
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseeight" class="collapse" aria-labelledby="headingeight" data-parent="#question_accordian">
                                <div class="card-body">
                                    <p>The draw is automated it’s carried out by an algorithm that will randomly choose an existent ticket between the full number of them.</p>
                                </div>
                                </div>
                            </div>
                            <div class="card card_9">
                                <div class="card-header" id="headingnine">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapsenine" aria-expanded="false" aria-controls="collapsenine">
                                            <h5>9. How many tickets can I buy?</h5>
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapsenine" class="collapse" aria-labelledby="headingnine" data-parent="#question_accordian">
                                <div class="card-body">
                                    <p>Practically, there is no limit. The more tickets you buy, the more chances you have. But there is a limit per order. The maximum that one can buy at once (some order) is 1000 (one thousand) tickets and you get a nice discount for that.</p>
                                    <p>If you want to buy more than that, you need to place one order for each 1000 (one thousand) tickets.</p>
                                </div>
                                </div>
                            </div>
                            <div class="card card_10">
                                <div class="card-header" id="headingTen">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTen" aria-expanded="false" aria-controls="collapseTen">
                                            <h5>10. Is Flowy Lottery – The Bitcoin Lottery safe?</h5>
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseTen" class="collapse" aria-labelledby="headingTen" data-parent="#question_accordian">
                                <div class="card-body">
                                    <p>Yes, it is!</p>
                                    <p>Flowy Lottery is totally safe on all points of view. We use cold wallets, and we make the payments manually since there will be a maximum of three draws a day (one per category). That means our wallets do not stay online at any moment, with means no hacker or anything can still them from us. The physical copies are very well hidden, and they are also encrypted so only the mentors of the project know the secrets to decrypt them.</p>
                                </div>
                                </div>
                            </div>
                            <div class="card card_11">
                                <div class="card-header" id="headingele">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseele" aria-expanded="false" aria-controls="collapseele">
                                            <h5>11. Will I pay tax for the Bitcoin Lotter?</h5>
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseele" class="collapse" aria-labelledby="headingheadingelefour" data-parent="#question_accordian">
                                <div class="card-body">
                                    <p>It depends on your country`s jurisdiction. In most countries, the answer is still no, but it is your responsibility to find out about the current laws of your country regarding Bitcoin and lotteries. We hereby advise you that the law of your country is major and must be taken as the valid terms evening if in these terms we affirmed differently.</p>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                            <h3 class="mt-2"><a href="#how_work">About us</a></h3>
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
                            <h3 class="mt-2"><a href="#how_work">About us</a></h3>
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
    <input type="hidden" name="" value="{{$remaing_time}}" id="remain_time">
    <div class="loader_container display_none">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1 bg-gray-800"></div>
            <div class="sk-child sk-bounce2 bg-gray-800"></div>
            <div class="sk-child sk-bounce3 bg-gray-800"></div>
        </div>
    </div>
    <script src="{{asset('library/apexchart/dist/apexcharts.min.js')}}"></script>
    <script src="{{asset('js/custom.js')}}"></script>
    <script src="{{asset('library/wallet_validation/dist/wallet-address-validator.min.js')}}"></script>
    <script>
        $(document).ready(function(){
            var difference = Number($('#remain_time').val());
            
            var count_down = setInterval(function() {
                // var target = new Date("December 04 2019 13:30:00 GMT+0100"); //replace with YOUR DATE
                // var now = new Date();
                // var difference = Math.floor((target.getTime() - now.getTime()) / 1000);
                difference--;

                var seconds = fixIntegers(difference % 60);
                min_difference = Math.floor(difference / 60);
                

                var minutes = fixIntegers(min_difference % 60);
                hour_difference = Math.floor(min_difference / 60);

                var hours = fixIntegers(hour_difference % 24);
                // difference = Math.floor(difference / 24);
                // console.log(hours +':'+ minutes +':'+ seconds);
                // var days = difference;
            
                $("#count_second").toggleClass('display_none');
                $("#count_min").html(minutes);
                $("#count_hour").html(hours);
                // $(".countdown #days").html(days);
                if (difference <= 0) {
                    clearInterval(count_down);
                    $("#count_second").toggleClass('display_none');
                    console.log(difference)
                }
            }, 1000); 
            function fixIntegers(integer) {
                if (integer < 0)
                    integer = 0;
                if (integer < 10)
                    return "0" + integer;
                return "" + integer;
            }

            
            // $('#submit_btn').click(function(e){
            //     e.preventDefault()
            //     $('.loader_container').removeClass('display_none');
            //     let wallet = $('#wallet_address').val();
            //     var valid = WAValidator.validate(wallet, 'bitcoin');
            //     if(!valid){
            //         console.log('ok')
            //         $('.wallet_invalid').removeClass('display_none');
            //         return
            //     }
            //     $('.loader_container').removeClass('display_none');
            //     $(this).attr('disabled', 'disabled');
            //     // location.reload()
            //     // $('#form_submit').submit();
                
            // })
        })
    </script>
</body>
</html>