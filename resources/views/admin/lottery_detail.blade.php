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
    
    <div class="br-pagebody">            
        <div class="row row-sm mg-t-20 card card-body">
            <div class="col-md-12">
                @if ($lottery->is_paid)
                    <h3 class="text-center bg-success">You already have paid to winners.</h3>
                @else
                    <h3 class="text-center bg-warning">You have to pay to winners now.</h3>
                @endif
               {{-- <h4 class="text-center">{{ $lottery->total_bitcoin }} BIT ({{ round($lottery->total_bitcoin * $usd, 2) }} USD)</h4> --}}
            </div>           
        </div><!-- row -->

        <div class="row row-sm mg-t-20">
            <div class="col-md-4">
                <div class="card bd-0">
                    <div class="card-header tx-medium bd-0 tx-white bg-mantle">
                        Prize 5% [{{ $lottery->total_bitcoin * 0.05 }} BIT ({{ round($lottery->total_bitcoin * 0.05 * $usd, 2) }} USD)]
                    </div><!-- card-header -->
                    <div class="card-body bd bd-t-0 rounded-bottom">
                        <p class="mg-b-0">Ticket Number: <b>{{ $lottery->tickets()->find($lottery->win_of_prize1)->number }}</b></p>
                        <p class="mg-b-0 mg-t-2">User Email: <b>{{ $lottery->tickets()->find($lottery->win_of_prize1)->user->email }}</b></p>
                        <p class="mg-b-0 mg-t-2">Wallet Address: <b><a href="https://www.blockchain.com/btc/address/{{ $lottery->tickets()->find($lottery->win_of_prize1)->invoice->wallet_address }}" target="_blank">{{ $lottery->tickets()->find($lottery->win_of_prize1)->invoice->wallet_address }}</a></b></p>
                        @if ($lottery->payments()->where('prize_type', '5')->first()->hash_code != null)
                            <p class="mg-b-0 mg-t-2">Hash Code: {{$lottery->payments()->where('prize_type', '5')->first()->hash_code}}</p>
                            <span class="badge badge-success">Paid</span>
                        @else
                            <span class="badge badge-danger">Pending</span>
                            <form action="{{route('admin.win_payment')}}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="hash_code">Transaction Hash Code</label>
                                    <input type="text" name="hash_code" class="form-control">
                                </div>
                                @error('hash_code')
                                    <span class="invalid-feedback" style="display: block; margin-left: 10px;" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <input type="hidden" name="lottery_id" value="{{$lottery->id}}">
                                <input type="hidden" name="prize_type" value="5">
                                <button class="btn btn-custom">Paid</button>
                            </form>
                        @endif
                    </div><!-- card-body -->
                </div>
            </div> 
            
            <div class="col-md-4">
                <div class="card bd-0">
                    <div class="card-header tx-medium bd-0 tx-white bg-purple">
                        Prize 15% [{{ $lottery->total_bitcoin * 0.15 }} BIT ({{ round($lottery->total_bitcoin * 0.15 * $usd, 2) }} USD)]
                    </div><!-- card-header -->
                    <div class="card-body bd bd-t-0 rounded-bottom">
                        <p class="mg-b-0">Ticket Number: <b>{{ $lottery->tickets()->find($lottery->win_of_prize2)->number }}</b></p>
                        <p class="mg-b-0 mg-t-2">User Email: <b>{{ $lottery->tickets()->find($lottery->win_of_prize2)->user->email }}</b></p>
                        <p class="mg-b-0 mg-t-2">Wallet Address: <b><a href="https://www.blockchain.com/btc/address/{{ $lottery->tickets()->find($lottery->win_of_prize2)->invoice->wallet_address }}" target="_blank">{{ $lottery->tickets()->find($lottery->win_of_prize2)->invoice->wallet_address }}</a></b></p>
                        @if ($lottery->payments()->where('prize_type', '15')->first()->hash_code != null)
                            <p class="mg-b-0 mg-t-2">Hash Code: {{$lottery->payments()->where('prize_type', '15')->first()->hash_code}}</p>
                            <span class="badge badge-success">Paid</span>
                        @else
                            <span class="badge badge-danger">Pending</span>
                            <form action="{{route('admin.win_payment')}}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="hash_code">Transaction Hash Code</label>
                                    <input type="text" name="hash_code" class="form-control">
                                </div>
                                @error('hash_code')
                                    <span class="invalid-feedback" style="display: block; margin-left: 10px;" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <input type="hidden" name="lottery_id" value="{{$lottery->id}}">
                                <input type="hidden" name="prize_type" value="15">
                                <button class="btn btn-custom">Paid</button>
                            </form>
                        @endif
                    </div><!-- card-body -->
                </div>
            </div>

            <div class="col-md-4">
                <div class="card bd-0">
                    <div class="card-header tx-medium bd-0 tx-white bg-indigo">
                        Prize 40% [{{ $lottery->total_bitcoin * 0.4 }} BIT ({{ round($lottery->total_bitcoin * 0.4 * $usd, 2) }} USD)]
                    </div><!-- card-header -->
                    <div class="card-body bd bd-t-0 rounded-bottom">
                        <p class="mg-b-0">Ticket Number: <b>{{ $lottery->tickets()->find($lottery->win_of_prize3)->number }}</b></p>
                        <p class="mg-b-0 mg-t-2">User Email: <b>{{ $lottery->tickets()->find($lottery->win_of_prize3)->user->email }}</b></p>
                        <p class="mg-b-0 mg-t-2">Wallet Address: <b><a href="https://www.blockchain.com/btc/address/{{ $lottery->tickets()->find($lottery->win_of_prize3)->invoice->wallet_address }}" target="_blank">{{ $lottery->tickets()->find($lottery->win_of_prize3)->invoice->wallet_address }}</a></b></p>
                        @if ($lottery->payments()->where('prize_type', '40')->first()->hash_code != null)
                            <p class="mg-b-0 mg-t-2">Hash Code: {{$lottery->payments()->where('prize_type', '40')->first()->hash_code}}</p>
                            <span class="badge badge-success">Paid</span>
                        @else
                            <span class="badge badge-danger">Pending</span>
                            <form action="{{route('admin.win_payment')}}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="hash_code">Transaction Hash Code</label>
                                    <input type="text" name="hash_code" class="form-control">
                                </div>
                                @error('hash_code')
                                    <span class="invalid-feedback" style="display: block; margin-left: 10px;" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <input type="hidden" name="lottery_id" value="{{$lottery->id}}">
                                <input type="hidden" name="prize_type" value="40">
                                <button class="btn btn-custom">Paid</button>
                            </form>
                        @endif
                    </div><!-- card-body -->
                </div>
            </div>
                      
        </div><!-- row -->

        {{-- <div class="row row-sm mg-t-20 card card-body">
            <div class="col-md-12">
                <h3 class="text-center">Pure Revenue</h3>
                <h4 class="text-center">{{ $lottery->total_bitcoin * 0.4 }} BIT ({{ round($lottery->total_bitcoin * 0.4 * $usd, 2) }} USD)</h4>
            </div>           
        </div><!-- row --> --}}
    </div><!-- br-pagebody -->
    
@endsection

@section('script')

    <script>
        $(document).ready(function(){
            
        })
    </script>
@endsection