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
                                <span href="#" class="card-link">{{$today_bitcoin * 0.05}} BTC</span>
                                <span href="#" class="card-link">{{round($today_bitcoin * 0.05 * $usd, 2)}} USD</span>
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
                                <span href="#" class="card-link">{{$today_bitcoin * 0.4}} BTC</span>
                                <span href="#" class="card-link">{{round($today_bitcoin * 0.4 * $usd, 2)}} USD</span>
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

        <div class="row mg-t-20">
            <div class="col-lg-4 col-12">
                <div class="card bg-teal mg-t-5">
                    <div class="card-body">
                        <i class="ion ion-bag tx-60 lh-0 tx-white-8 float-left"></i>
                        <div class="float-right">
                            <h5 class="card-title">Current BTC For Prize1</h5>
                            <p class="card-subtitle tx-white-8">{{ $today_bitcoin * 0.05 }} BTC</p>
                            <p class="tx-white-8">{{ round($today_bitcoin * 0.05 * $usd, 2) }} USD</p>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-12">
                <div class="card bg-primary mg-t-5">
                    <div class="card-body">
                        <i class="ion ion-bag tx-60 lh-0 tx-white-8 float-left"></i>
                        <div class="float-right">
                            <h5 class="card-title">Current BTC For Prize2</h5>
                            <p class="card-subtitle tx-white-8">{{ $today_bitcoin * 0.15 }} BTC</p>
                            <p class="tx-white-8">{{ round($today_bitcoin * 0.15 * $usd, 2) }} USD</p>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-12">
                <div class="card bg-purple mg-t-5">
                    <div class="card-body">
                        <i class="ion ion-bag tx-60 lh-0 tx-white-8 float-left"></i>
                        <div class="float-right">
                            <h5 class="card-title">Current BTC For Prize3</h5>
                            <p class="card-subtitle tx-white-8">{{ $today_bitcoin * 0.4 }} BTC</p>
                            <p class="tx-white-8">{{ round($today_bitcoin * 0.4 * $usd, 2) }} USD</p>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mg-t-10">
            <div class="col-md-4">
                <div class="card bg-purple mg-t-5">
                    <div class="card-body">
                        <i class="ion ion-earth tx-60 lh-0 tx-white-8 float-left"></i>
                        <div class="float-right">
                            <h5 class="card-title">Total Bitcoin So Far</h5>
                            <p class="card-subtitle">{{ $get_sum }} BTC</p>
                            <p>{{ round($get_sum * $usd, 2) }} USD</p>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-info mg-t-5">
                    <div class="card-body">
                        <i class="ion ion-clock tx-60 lh-0 tx-white-8 float-left"></i>
                        <div class="float-right">
                            <h5 class="card-title">Paid Bitcoin So Far</h5>
                            <p class="card-subtitle">{{ $sent_sum }} BTC</p>
                            <p>{{ round($sent_sum * $usd, 2) }} USD</p>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-teal mg-t-5">
                    <div class="card-body">
                        <i class="ion ion-monitor tx-60 lh-0 tx-white-8 float-left"></i>
                        <div class="float-right">
                            <h5 class="card-title">Registered All User</h5>
                            <p class="card-subtitle">{{ $total_user }}</p>
                            <p>{{ $real_user }} (Email Verified Users)</p>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            
        </div>
        
            
    </div>
@endsection