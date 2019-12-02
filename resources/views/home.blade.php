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

    <div class="br-pagebody" id="home_page">
        @if ($unpaid_flag)
            <div class="row mg-t-20 unpaid">
                <div class="col-lg-6 offset-lg-3">
                    <div class="card mg-t-5" style="background-color: #ffce87;">
                        <div class="card-body">
                            <i class="ion ion-alert-circled tx-60 lh-0 tx-white-8 custom_icon"></i>
                            <div class="custom_content">
                                <h5 class="card-title" style="color: #24126A;">You have unpaid orders now. plesae manage it.</h5>
                                <p class="card-subtitle"><a href="{{ route('payment') }}" style="box-shadow: 5px 5px 10px;" class="btn btn-custom">Manage Order</a></p>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>

                </div>
            </div>            
        @endif
        <div class="row mg-t-20">
            <div class="col-lg-6 mg-t-20 mg-lg-t-0 more_ticket">
                <div class="card mg-t-5 bg-primary">
                    <div class="card-body">
                        <i class="ion ion-archive tx-60 lh-0 tx-white-8 custom_icon"></i>
                        <div class="custom_content">
                            <h5 class="card-title" style="color: #fff;">Current Available Tickets.</h5>
                            @if ($available_number == '')
                                <p class="card-subtitle" style="color: #fff;">You have not any tickets yet. Please purchase tickets.</p>
                            @else
                                <p class="card-subtitle" style="color: #fff;">{{$available_number}}</p>
                            @endif
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div><!-- col-3 -->

            <div class="col-lg-6 mg-t-20 mg-lg-t-0">

                <div class="card mg-t-5 bg-purple">
                    <div class="card-body">
                        <i class="ion ion-bag tx-60 lh-0 tx-white-8 custom_icon"></i>
                        <div class="custom_content">
                            <h5 class="card-title" style="color: #fff;">Do you want more lucky? ({{$cost_of_ticket}} USD per ticket)</h5>
                            <p style="color: #fff;">Please click here for more tickets</p>
                            <p class="card-subtitle"><a href="{{ route('welcome') }}" style="box-shadow: 5px 5px 10px;" class="btn btn-custom">More Tickets</a></p>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div><!-- col-3 -->    
        </div>      
        {{-- <div class="row row-sm mg-t-20">            
            <div class="col-sm-6 col-lg-6">
                <div class="bg-info rounded overflow-hidden" style="height: 160px;">
                    <div class="pd-x-20 pd-t-20 d-flex align-items-center">
                        <i class="ion ion-earth tx-60 lh-0 tx-white-8"></i>
                        <div class="mg-l-20">
                        <p class="tx-12 tx-spacing-1 tx-mont tx-semibold tx-uppercase tx-white-8 mg-b-10">Earned Bitcoin So Far</p>
                        <p class="tx-24 tx-white tx-lato tx-bold mg-b-0 lh-1">1,975,224</p>
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
                        </div>
                    </div>
                </div>
            </div><!-- col-3 -->

            
        </div> --}}
            
    </div>
    
@endsection