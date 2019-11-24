<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="{{asset('css/app.css')}}">

    <!-- jQuery library -->
    <script src="{{('js/app.js')}}"></script>  
    <link rel="stylesheet" href="{{asset('css/custom.css')}}">
    <title>{{ config('app.name') }}</title>
    <style>
        .invalid-feedback {color: #fdb702;display: block;}
    </style>
</head>
<body>
    <div class="custom-container">
        <header id="header">
            <div class="real_container container-fluid">
                <div class="row header_menu desktop_menu">
                    <div class="col-md-5 left_menu">
                        <div class="logo float-left"><a href="{{ route('welcome') }}" id="logo">LOGO</a></div>
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
                        <div class="logo"><a href="{{asset('/')}}" >LOGO</a></div>
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
                        <p><span><a href="https://www.blockchain.com/btc/address/1234567890123456789123456789123456" style="color: #3F1268;">1234567890123456789123456789123456</a></span></p>
                    </div>
                </div>
                <div class="row banner text-center">
                    <div class="col-md-12">
                        <p class="mt-2">Next Prize</p>
                        <h1>{{$today_bitcoin}} btc</h1>
                        <p class="usd_now">( {{$today_bitcoin * $usd}} USD )</p>
                        <p>Total accumulated so for</p>
                    </div>
                </div>
                <div class="row prizes text-center">
                    <div class="col-md-4">
                        <div class="prize_one item">
                            <p>Prize one - SuperBit</p>
                            <div>
                                <p>{{$today_bitcoin * 0.4}} btc</p>
                                <p>( {{$today_bitcoin * 0.4 * $usd}} USD )</p>
                            </div>                            
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="prize_two item">
                            <p>Prize one - SuperBit</p>
                            <div>
                                <p>{{$today_bitcoin * 0.15}} btc</p>
                                <p>( {{$today_bitcoin * 0.15 * $usd}} USD )</p>
                            </div>                            
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="prize_three item">
                            <p>Prize one - SuperBit</p>
                            <div>
                                <p>{{$today_bitcoin * 0.05}} btc</p>
                                <p>( {{$today_bitcoin * 0.05 * $usd}} USD )</p>
                            </div>                            
                        </div>
                    </div>
                </div>
                <form action="{{route('post_home')}}" id="form_submit" method="post">
                    @csrf
                    <div class="row ticket_buy mb-4">
                        <div class="col-md-3">
                            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" placeholder="E-mail">
                            @error('email')
                                <span class="invalid-feedback" style="display: block;margin-left: 10px;" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            
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
                                <option value="1">1 Number of tickets</option>
                                <option value="2">2 Number of tickets</option>
                                <option value="3">3 Number of tickets</option>
                                <option value="4">4 Number of tickets</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="button" name="submit_btn" id="submit_btn" class="form-control" style="background-color:#fdb702;font-weight:bold;" value="Buy tickets">
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
                            <h2>{{$next_time}}</h2>
                        </div>
                        <p class="today_date">11/09/2019 - Today at 8pm</p>
                        <p class="grinich">Currently Greenwich Mean Time (GMT), UTC +0</p>
                        <a href="#header" class="btn btn-primary btn-sm">Buy tickets</a>
                    </div>
                </div>
            </div>
        </section>
        <section>
            <div class="real_container container-fluid">
                <div class="row chart">
                    <div class="col-md-12">
                        <div class="" id="chart"></div>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
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
                            <h2>{{$last_lottery->first()->total_bitcoin}} btc</h2>
                            <h3>( {{$last_lottery->first()->total_bitcoin * $usd}} USD )</h3>                            
                        @endif
                        <h4>Total accumulated</h4>
                    </div>
                </div>
                <div class="row prize_1 mt-5">
                    <div class="col-md-6">
                        <div class="float-right text-center">
                            <h4>Prize one - SuperBit</h4>
                            <div class="prize">
                                @if ($last_lottery->exists())
                                    <h2>{{$last_lottery->first()->total_bitcoin * 0.4}}btc</h2>
                                    <p>( {{$last_lottery->first()->total_bitcoin * 0.4 * $usd}} USD )</p>                                    
                                @endif
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="col-md-6 text-left">
                        <div>
                            <p>Address bitcoin:</p>
                            @if ($last_lottery->exists())
                                <p><a href="https://www.blockchain.com/btc/address/{{ $last_lottery->first()->tickets()->find($last_lottery->first()->win_of_prize1)->user->invoices()->first()->wallet_address }}">{{ $last_lottery->first()->tickets()->find($last_lottery->first()->win_of_prize1)->user->invoices()->first()->wallet_address }}</a></p>                                
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row prize_2 mt-4">
                    <div class="col-md-6">
                        <div class="float-right text-center mr-3">
                            <h4>Prize two - SuperBit</h4>
                            <div class="prize">
                                @if ($last_lottery->exists())
                                    <h2>{{$last_lottery->first()->total_bitcoin * 0.15}}btc</h2>
                                    <p>( {{$last_lottery->first()->total_bitcoin * 0.15 * $usd}} USD )</p>
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
                            <p>Address bitcoin:</p>
                            @if ($last_lottery->exists())
                                <p>{{ $last_lottery->first()->tickets()->find($last_lottery->first()->win_of_prize2)->user->invoices()->first()->wallet_address }}</p>
                            @else
                                <h2>Not yet</h2>
                                <p>Not yet</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row prize_3 mt-4">
                    <div class="col-md-6">
                        <div class="float-right text-center mr-3">
                            <h4>Prize three - SuperBit</h4>
                            <div class="prize">
                                @if ($last_lottery->exists())
                                    <h2>{{$last_lottery->first()->total_bitcoin * 0.05}}btc</h2>
                                    <p>( {{$last_lottery->first()->total_bitcoin * 0.05 * $usd}} USD )</p>
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
                            <p>Address bitcoin:</p>
                            @if ($last_lottery->exists())
                                <p>{{ $last_lottery->first()->tickets()->find($last_lottery->first()->win_of_prize3)->user->invoices()->first()->wallet_address }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-md-12 text-center">
                        <a href="#header" class="btn btn-sm">Buy tickets</a>
                    </div>
                </div>
            </div>
        </section>
        <section class="result_table">
            <div class="real_container container-fluid">
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
                                    @if (!$last_four_lottery->isEmpty())
                                        @foreach ($last_four_lottery as $item)
                                            <tr>
                                                <td>{{ date("d/m/Y", strtotime($item->date)) }}</td>
                                                <td>{{ $item->tickets()->find($item->win_of_prize1)->user->invoices()->first()->wallet_address }}</td>
                                                <td>{{ $item->total_bitcoin * 0.4 }} ({{ $item->total_bitcoin * 0.4 }}USD)</td>
                                            </tr>
                                        @endforeach
                                    @endif                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
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
                                    @if (!$last_four_lottery->isEmpty())
                                        @foreach ($last_four_lottery as $item)
                                            <tr>
                                                <td>{{ date("d/m/Y", strtotime($item->date)) }}</td>
                                                <td>{{ $item->tickets()->find($item->win_of_prize2)->user->invoices()->first()->wallet_address }}</td>
                                                <td>{{ $item->total_bitcoin * 0.15 }} ({{ $item->total_bitcoin * 0.15 }}USD)</td>
                                            </tr>
                                        @endforeach
                                    @endif 
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
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
                                    @if (!$last_four_lottery->isEmpty())
                                        @foreach ($last_four_lottery as $item)
                                            <tr>
                                                <td>{{ date("d/m/Y", strtotime($item->date)) }}</td>
                                                <td>{{ $item->tickets()->find($item->win_of_prize3)->user->invoices()->first()->wallet_address }}</td>
                                                <td>{{ $item->total_bitcoin * 0.05 }} ({{ $item->total_bitcoin * 0.05 }}USD)</td>
                                            </tr>
                                        @endforeach
                                    @endif 
                                </tbody>
                            </table>
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
                            <h2>{{$sent_sum}}btc</h2>
                            <h3>{{$sent_sum * $usd}}USD</h3>
                            <p>amount paid</p>
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
                                <p>probability</p>
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
                            <p>Number of prizes </p>
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
                        <p>The lottery system will be based on tickets. You can get as many tickest as you want. Each ticket gives one chance. For instance, you can buy just one ticket, in that case, this you gets one chnace in the loterry. Other one maybe will prefer to buy 10 tickets, what will make him to have 10 chances, and so on.</p>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-md-4 text-center">
                        <div class="circle bit_bg_primary float-right">3</div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="col-md-8 pl-30 col-12 text-left">
                        <p> The system will run the lottery every day, and there will be three prizes. Yes you have three chances to win.</p>
                        <br>
                        <p>- For each prize there will be a different lottery separetely. That means, three lotteries in the same day.</p>
                        <p>- Only one lotery per.</p>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-md-12 text-center">
                        <a href="#header" class="btn btn-sm">Buy tickets</a>
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
                                            Questions and answers ?
                                        </button>
                                    </h2>
                                </div>
                            
                                <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#question_accordian">
                                <div class="card-body">
                                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                </div>
                                </div>
                            </div>
                            <div class="card card_2">
                                <div class="card-header" id="headingTwo">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            Questions and answers ?
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#question_accordian">
                                <div class="card-body">
                                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                </div>
                                </div>
                            </div>
                            <div class="card card_3">
                                <div class="card-header" id="headingThree">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                            Questions and answers ?
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#question_accordian">
                                <div class="card-body">
                                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                </div>
                                </div>
                            </div>
                            <div class="card card_4">
                                <div class="card-header" id="headingfour">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapsefour" aria-expanded="false" aria-controls="collapseThree">
                                            Questions and answers ?
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapsefour" class="collapse" aria-labelledby="headingfour" data-parent="#question_accordian">
                                <div class="card-body">
                                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
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
                                <li><a href="#"><img src="https://public-images.flowybusinesses.com/img/Facebook.png" alt="Facebook"></a></li>
                                <li><a href="#"><img src="https://public-images.flowybusinesses.com/img/Instagram.png" alt="Instagram"></a></li>
                                <li><a href="#"><img src="https://public-images.flowybusinesses.com/img/youtube.png" alt="Youtube"></a></li>
                            </ul>
                            <h3 class="mt-2">About us</h3>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="col-4">
                        <h3>LOGO</h3>
                    </div>
                    <div class="col-4 text-left">
                        <h3>Support</h3>
                        <h3>contact@flowylottery.com</h3>
                        <h3>(206) 260-3588</h3>
                    </div>
                </div>
                <div class="row text-center mobile_footer">
                    <div class="col-12 text-left mb-3">
                        <h3>LOGO</h3>
                    </div>
                    <div class="col-12">
                        <div class="text-left">
                            <h3 class="mb-2">Flowy Lottery 2019</h3>
                            <ul>
                                <li><a href="#"><img src="https://public-images.flowybusinesses.com/img/Facebook.png" alt="Facebook"></a></li>
                                <li><a href="#"><img src="https://public-images.flowybusinesses.com/img/Instagram.png" alt="Instagram"></a></li>
                                <li><a href="#"><img src="https://public-images.flowybusinesses.com/img/youtube.png" alt="Youtube"></a></li>
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
    <script src="{{asset('library/apexchart/dist/apexcharts.min.js')}}"></script>
    <script src="{{asset('js/custom.js')}}"></script>
    <script src="{{asset('library/wallet_validation/dist/wallet-address-validator.min.js')}}"></script>
    <script>
        $(document).ready(function(){
            $('#submit_btn').click(function(){
                let wallet = $('#wallet_address').val();
                var valid = WAValidator.validate(wallet, 'bitcoin');
                if(!valid){
                    console.log('ok')
                    $('.wallet_invalid').removeClass('display_none');
                    return
                }
                $(this).attr('disabled', 'disabled');
                $('#form_submit').submit();
                
            })
        })
    </script>
</body>
</html>