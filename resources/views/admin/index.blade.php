@extends('admin.layouts.app')

@section('css')
    <style>
        .bg-teal-1{background-color: #1caf9a7a}
        .bg-teal-2{background-color: #1caf9a1f}
    </style>
@endsection
@section('content')

    <!-- ########## START: MAIN PANEL ########## -->
    <div class="br-mainpanel">
        <div class="br-pagetitle">
            <i class="icon ion-home"></i>
            <div>
            <h4>Dashboard</h4>
            <p class="mg-b-0">Dashboard For Administrator</p>
        </div>            
    </div><!-- d-flex -->
    
    <div class="br-pagebody">
        @if ($lottery_running)
            <div class="row row-sm mg-t-20">
                <div class="col-md-4">
                    <div class="card bg-teal">
                        <div class="card-body">
                            @if ($win_of_prize1 != null)
                                <h5 class="card-title">Winner For Prize1: {{ \App\Ticket::find($win_of_prize1)->number }}</h5>
                                <p class="card-subtitle">Wallet Address:</p>
                                <p><a class="card-text" target="_blank" href="https://www.blockchain.com/btc/address/{{\App\Ticket::find($win_of_prize1)->invoice->wallet_address}}">{{\App\Ticket::find($win_of_prize1)->invoice->wallet_address}}</a></p>
                                <span href="#" class="card-link">{{$today_bitcoin * 0.4}} BIT</span>
                                <span href="#" class="card-link">{{round($today_bitcoin * 0.4 * $usd, 2)}} USD</span>
                            @else
                                <h5 class="card-title">Winner For Prize1: ?</h5>
                                <p class="card-subtitle">Wallet Address:</p>
                                <p class="card-text">?</p>
                                <span></span>
                                <span href="#" class="card-link"></span> 
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-teal-1">
                        <div class="card-body">
                            @if ($win_of_prize2 != null)
                                <h5 class="card-title">Winner For Prize2: {{ \App\Ticket::find($win_of_prize2)->number }}</h5>
                                <p class="card-subtitle">Wallet Address:</p>
                                <p><a class="card-text" target="_blank" href="https://www.blockchain.com/btc/address/{{\App\Ticket::find($win_of_prize2)->invoice->wallet_address}}">{{\App\Ticket::find($win_of_prize2)->invoice->wallet_address}}</a></p>
                                <span href="#" class="card-link">{{$today_bitcoin * 0.15}} BIT</span>
                                <span href="#" class="card-link">{{round($today_bitcoin * 0.15 * $usd, 2)}} USD</span>
                            @else
                                <h5 class="card-title">Winner For Prize2: ?</h5>
                                <p class="card-subtitle">Wallet Address:</p>
                                <p class="card-text">?</p>
                                <span href="#" class="card-link"></span>
                                <span href="#" class="card-link"></span>
                                
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-teal-2">
                        <div class="card-body">
                            @if ($win_of_prize3 != null)
                                <h5 class="card-title">Winner For Prize3: {{ \App\Ticket::find($win_of_prize3)->number }}</h5>
                                <p class="card-subtitle">Wallet Address:</p>
                                <p><a class="card-text" target="_blank" href="https://www.blockchain.com/btc/address/{{\App\Ticket::find($win_of_prize3)->invoice->wallet_address}}">{{\App\Ticket::find($win_of_prize3)->invoice->wallet_address}}</a></p>
                                <span href="#" class="card-link">{{$today_bitcoin * 0.05}} BIT</span>
                                <span href="#" class="card-link">{{round($today_bitcoin * 0.05 * $usd, 2)}} USD</span>
                            @else
                                <h5 class="card-title">Winner For Prize3: ?</h5>
                                <p class="card-subtitle">Wallet Address:</p>
                                <p class="card-text">?</p>
                                <span href="#" class="card-link"></span>
                                <span href="#" class="card-link"></span>                                
                            @endif
                        </div>
                    </div>
                </div>
            </div>            
        @endif
        <div class="row row-sm mg-t-20">            
            <div class="col-sm-6 col-lg-3 mg-t-20 mg-sm-t-0">
                <div class="bg-purple rounded overflow-hidden">
                    <div class="pd-x-20 pd-t-20 d-flex align-items-center">
                        <i class="ion ion-earth tx-60 lh-0 tx-white-8"></i>
                        <div class="mg-l-20">
                        <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase tx-white-8 mg-b-10">Total Bitcoin So Far</p>
                        <p class="tx-24 tx-white tx-lato tx-bold mg-b-0 lh-1">{{ $get_sum }} BIT</p>
                        <span class="tx-14 tx-roboto tx-white-8">{{ round($get_sum * $usd, 2) }} USD</span>
                        </div>
                    </div>
                    <div id="ch3" class="ht-50 tr-y-1 rickshaw_graph"></div>
                </div>
            </div><!-- col-3 -->
            <div class="col-sm-6 col-lg-3">
                <div class="bg-info rounded overflow-hidden">
                    <div class="pd-x-20 pd-t-20 d-flex align-items-center">
                        <i class="ion ion-bag tx-60 lh-0 tx-white-8"></i>
                        <div class="mg-l-20">
                        <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase tx-white-8 mg-b-10">Paid Bitcoin</p>
                        <p class="tx-24 tx-white tx-lato tx-bold mg-b-0 lh-1">{{ $sent_sum }} BIT</p>
                        <span class="tx-14 tx-roboto tx-white-8">{{ round($sent_sum * $usd, 2) }} USD</span>
                        </div>
                    </div>
                    <div id="ch1" class="ht-50 tr-y-1 rickshaw_graph"></div>
                </div>
            </div><!-- col-3 -->
            <div class="col-sm-6 col-lg-3 mg-t-20 mg-lg-t-0">
                <div class="bg-teal rounded overflow-hidden">
                <div class="pd-x-20 pd-t-20 d-flex align-items-center">
                    <i class="ion ion-clock tx-60 lh-0 tx-white-8"></i>
                    <div class="mg-l-20">
                    <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase tx-white-8 mg-b-10">Bitcoin for next lottery</p>
                    <p class="tx-24 tx-white tx-lato tx-bold mg-b-0 lh-1">{{ $today_bitcoin }} BIT</p>
                    <span class="tx-14 tx-roboto tx-white-8">{{ round($today_bitcoin * $usd, 2) }} USD</span>
                    </div>
                </div>
                <div id="ch2" class="ht-50 tr-y-1 rickshaw_graph"></div>
                </div>
            </div><!-- col-3 -->
            <div class="col-sm-6 col-lg-3 mg-t-20 mg-lg-t-0">
                <div class="bg-primary rounded overflow-hidden">
                <div class="pd-x-20 pd-t-20 d-flex align-items-center">
                    <i class="ion ion-monitor tx-60 lh-0 tx-white-8"></i>
                    <div class="mg-l-20">
                    <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase tx-white-8 mg-b-10">Registered All User</p>
                    <p class="tx-24 tx-white tx-lato tx-bold mg-b-0 lh-1">{{ $total_user }}</p>
                    <span class="tx-14 tx-roboto tx-white-8">{{ $real_user }} (Email Verified Users) </span>
                    </div>
                </div>
                <div id="ch4" class="ht-50 tr-y-1 rickshaw_graph"></div>
                </div>
            </div><!-- col-3 -->
        </div>
            
    </div>
@endsection