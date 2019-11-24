@extends('admin.layouts.app')

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
        <div class="row row-sm mg-t-20">            
            <div class="col-sm-6 col-lg-3 mg-t-20 mg-sm-t-0">
                <div class="bg-purple rounded overflow-hidden">
                    <div class="pd-x-20 pd-t-20 d-flex align-items-center">
                        <i class="ion ion-earth tx-60 lh-0 tx-white-8"></i>
                        <div class="mg-l-20">
                        <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase tx-white-8 mg-b-10">Total Bitcoin So Far</p>
                        <p class="tx-24 tx-white tx-lato tx-bold mg-b-0 lh-1">{{ $get_sum }} BIT</p>
                        <span class="tx-14 tx-roboto tx-white-8">{{ $get_sum * $usd }} USD</span>
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
                        <span class="tx-14 tx-roboto tx-white-8">{{ $sent_sum * $usd }} USD</span>
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
                    <span class="tx-14 tx-roboto tx-white-8">{{ $today_bitcoin * $usd }} USD</span>
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