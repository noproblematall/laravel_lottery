@extends('layouts.app')

@section('content')

    <!-- ########## START: MAIN PANEL ########## -->
    <div class="br-mainpanel">
        <div class="br-pagetitle">
            <i class="icon ion-home"></i>
            <div>
            <h4>Dashboard</h4>
            <p class="mg-b-0">Dashboard For User</p>
        </div>            
    </div><!-- d-flex -->

    <div class="br-pagebody">      
        <div class="row row-sm mg-t-20">
            <div class="col-sm-6 col-lg-6 mg-t-20 mg-lg-t-0">
                <div class="bg-primary rounded overflow-hidden" style="height: 160px;">
                    <div class="pd-x-20 pd-t-20 d-flex align-items-center">
                        <i class="icon ion-archive tx-60 lh-0 tx-white-8"></i>
                        <div class="mg-l-20">
                        <p class="tx-12 tx-spacing-1 tx-mont tx-semibold tx-uppercase tx-white-8 mg-b-10">Current Available Tickets (Incoming Lottery {{$income_lottery}} of {{$current_bitcoin}})</p>
                        <p class="tx-24 tx-white tx-lato tx-bold mg-b-0 lh-1">{{$available_number}}</p>
                        
                        </div>
                    </div>
                </div>
            </div><!-- col-3 -->


            <div class="col-sm-6 col-lg-6 mg-t-20 mg-sm-t-0">
                <div class="bg-purple rounded overflow-hidden" style="height: 160px;">
                <div class="pd-x-20 pd-t-20 d-flex align-items-center">
                    <i class="ion ion-bag tx-60 lh-0 tx-white-8"></i>
                    <div class="mg-l-20">
                    <p class="tx-12 tx-spacing-1 tx-mont tx-semibold tx-uppercase tx-white-8 mg-b-10">Do you want more lucky? ({{$cost_of_ticket}} bit per ticket)</p>
                    <p class="tx-24 tx-white tx-lato tx-bold mg-b-0 lh-1"><a href="{{ route('welcome') }}" style="box-shadow: 5px 5px 10px;" class="btn btn-custom">Please click here for more tickets</a></p>
                    </div>
                </div>
                </div>
            </div><!-- col-3 -->    
        </div>      
        <div class="row row-sm mg-t-20">            
            <div class="col-sm-6 col-lg-6">
                <div class="bg-info rounded overflow-hidden" style="height: 160px;">
                    <div class="pd-x-20 pd-t-20 d-flex align-items-center">
                        <i class="ion ion-earth tx-60 lh-0 tx-white-8"></i>
                        <div class="mg-l-20">
                        <p class="tx-12 tx-spacing-1 tx-mont tx-semibold tx-uppercase tx-white-8 mg-b-10">Earned Bitcoin So Far</p>
                        <p class="tx-24 tx-white tx-lato tx-bold mg-b-0 lh-1">1,975,224</p>
                        {{-- <span class="tx-11 tx-roboto tx-white-8">24% higher yesterday</span> --}}
                        </div>
                    </div>
                </div>
            </div><!-- col-3 -->
            
            <div class="col-sm-6 col-lg-6 mg-t-20 mg-lg-t-0">
                <div class="bg-teal rounded overflow-hidden" style="height: 160px;">
                    <div class="pd-x-20 pd-t-20 d-flex align-items-center">
                        <i class="ion ion-monitor tx-60 lh-0 tx-white-8"></i>
                        <div class="mg-l-20">
                        <p class="tx-12 tx-spacing-1 tx-mont tx-semibold tx-uppercase tx-white-8 mg-b-10">Bitcoin for bought tickets</p>
                        <p class="tx-24 tx-white tx-lato tx-bold mg-b-0 lh-1">32.235</p>
                        {{-- <span class="tx-11 tx-roboto tx-white-8">23% average duration</span> --}}
                        </div>
                    </div>
                </div>
            </div><!-- col-3 -->

            
        </div>
            
    </div>
    
@endsection