@extends('admin.layouts.app')
@section('css')

<style>
    body{background-color: #E9ECEF;}
    .btn-custom{background-color: #FDB702;border-color: #FDB702;color: #24126A;font-weight: bold;}
    .invalid-feedback {display: block;}
</style>
@endsection
@section('content')
@php
    $page_range = array('10', '25', '50', '100');
@endphp
    <!-- ########## START: MAIN PANEL ########## -->
    <div class="br-mainpanel">
        <div class="br-pagetitle">
            <i class="icon ion-document-text"></i>
            <div>
            <h4>Lottery Detail</h4>
            <p class="mg-b-0">Please confirm this lottery</p>
        </div>            
    </div><!-- d-flex -->
    
    <div class="br-pagebody" id="app">            
        <div class="row row-sm mg-t-20 card card-body">
            <div class="col-md-12">
               <h3 class="text-center">Total bitcoin for this lottery</h3>
               <h4 class="text-center">{{ $lottery->total_bitcoin }} BIT ({{ $lottery->total_bitcoin * $usd }} USD)</h4>
            </div>           
        </div><!-- row -->

        <div class="row row-sm mg-t-20">
            <div class="col-md-4">
                <div class="card bd-0">
                    <div class="card-header tx-medium bd-0 tx-white bg-indigo">
                        Prize 40% [{{ $lottery->total_bitcoin * 0.4 }} BIT ({{ $lottery->total_bitcoin * 0.4 * $usd }} USD)]
                    </div><!-- card-header -->
                    <div class="card-body bd bd-t-0 rounded-bottom">
                        <p class="mg-b-0">Ticket Number: <b>{{ $lottery->tickets()->find($lottery->win_of_prize1)->number }}</b></p>
                        <p class="mg-b-0 mg-t-2">User Email: <b>{{ $lottery->tickets()->find($lottery->win_of_prize1)->user->email }}</b></p>
                        <p class="mg-b-0 mg-t-2">Wallet Address: <b>{{ $lottery->tickets()->find($lottery->win_of_prize1)->invoice->wallet_address }}</b></p>
                        {{-- <p class="mg-b-0 mg-t-2">Transaction Hash For This Ticket: <b>{{ $lottery->tickets()->find($lottery->win_of_prize1)->invoice->invoice_payment()->first()->transaction_hash }}</b></p> --}}
                    </div><!-- card-body -->
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bd-0">
                    <div class="card-header tx-medium bd-0 tx-white bg-purple">
                        Prize 15% [{{ $lottery->total_bitcoin * 0.15 }} BIT ({{ $lottery->total_bitcoin * 0.15 * $usd }} USD)]
                    </div><!-- card-header -->
                    <div class="card-body bd bd-t-0 rounded-bottom">
                        <p class="mg-b-0">Ticket Number: <b>{{ $lottery->tickets()->find($lottery->win_of_prize2)->number }}</b></p>
                        <p class="mg-b-0 mg-t-2">User Email: <b>{{ $lottery->tickets()->find($lottery->win_of_prize2)->user->email }}</b></p>
                        <p class="mg-b-0 mg-t-2">Wallet Address: <b>{{ $lottery->tickets()->find($lottery->win_of_prize2)->invoice->wallet_address }}</b></p>
                    </div><!-- card-body -->
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bd-0">
                    <div class="card-header tx-medium bd-0 tx-white bg-mantle">
                        Prize 5% [{{ $lottery->total_bitcoin * 0.05 }} BIT ({{ $lottery->total_bitcoin * 0.05 * $usd }} USD)]
                    </div><!-- card-header -->
                    <div class="card-body bd bd-t-0 rounded-bottom">
                        <p class="mg-b-0">Ticket Number: <b>{{ $lottery->tickets()->find($lottery->win_of_prize3)->number }}</b></p>
                        <p class="mg-b-0 mg-t-2">User Email: <b>{{ $lottery->tickets()->find($lottery->win_of_prize3)->user->email }}</b></p>
                        <p class="mg-b-0 mg-t-2">Wallet Address: <b>{{ $lottery->tickets()->find($lottery->win_of_prize3)->invoice->wallet_address }}</b></p>
                    </div><!-- card-body -->
                </div>
            </div>           
        </div><!-- row -->

        <div class="row row-sm mg-t-20 card card-body">
            <div class="col-md-12">
                <h3 class="text-center">Pure Revenue</h3>
                <h4 class="text-center">{{ $lottery->total_bitcoin * 0.4 }} BIT ({{ $lottery->total_bitcoin * 0.4 * $usd }} USD)</h4>
            </div>           
        </div><!-- row -->
    </div><!-- br-pagebody -->
    
@endsection

@section('script')

    <script>
        $(document).ready(function(){
            
        })
    </script>
@endsection