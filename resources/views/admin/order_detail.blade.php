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
            <h4>Order Detail</h4>
            <p class="mg-b-0">Please confirm this order</p>
        </div>            
    </div><!-- d-flex -->
    
    <div class="br-pagebody card card-body" id="app">            
        <div class="row row-sm mg-t-20">
            <div class="col-md-12">
               <h3 class="text-center">Bitcoin for this order</h3>
               <h4 class="text-center">{{ $invoice->price_in_bitcoin }} BIT</h4>
            </div>            
        </div><!-- row -->     
        <div class="row row-sm mg-t-20 mg-b-20">
            <div class="col-md-6">
                <h4>- Invoice ID </h4> <span>{{ $invoice->my_invoice_id }}</span>
                <h4>- Bitcoin Address </h4> <span><a href="https://www.blockchain.com/btc/address/{{ $invoice->address }}" target="_blank">{{ $invoice->address }}</a></span>
                <h4>- Number Of Ticket </h4> <span>{{ $invoice->number_of_ticket }}</span>
                <h4>- Wallet Address </h4> <span><a href="https://www.blockchain.com/btc/address/{{ $invoice->wallet_address }}" target="_blank">{{ $invoice->wallet_address }}</a></span>
                <h4>- User ID</h4> <span>{{ $invoice->user->username }}</span>
                <h4>- User Email</h4> <span>{{ $invoice->user->email }}</span>
            </div>

            <div class="col-md-6">
                @if ($invoice->is_paid)
                    <h4>- Paid Amount</h4>
                    @foreach ($invoice->invoice_payment as $item)
                        <h4>&nbsp;&nbsp;Transcation Hash </h4> <span>{{ $item->transaction_hash }} (Amount: {{ $item->value }} BIT )</span>
                    @endforeach
                @else
                    @if (!$invoice->invoice_payment->isEmpty())
                        <h4>- Current Paid</h4>
                        @foreach ($invoice->invoice_payment as $item)
                            <h4>&nbsp;&nbsp;Transcation Hash </h4> <span>{{ $item->transaction_hash }} (Amount: {{ $item->value }} BIT )</span>
                        @endforeach
                        @if (!$invoice->invoice_pending_payment->isEmpty())
                            <h4>- Pending Amount</h4>
                            @foreach ($invoice->invoice_pending_payment as $item)
                                <h4>&nbsp;&nbsp;Transcation Hash </h4> <span>{{ $item->transaction_hash }} (Amount: {{ $item->value }} BIT )</span>
                            @endforeach                        
                        @endif
                    @else
                        @if (!$invoice->invoice_pending_payment->isEmpty())
                            <h4>- Pending Amount</h4>
                            @foreach ($invoice->invoice_pending_payment as $item)
                                <h4>&nbsp;&nbsp;Transcation Hash </h4> <span>{{ $item->transaction_hash }} (Amount: {{ $item->value }} BIT )</span>
                            @endforeach
                        @else
                            <h4>Not Paid</h4>
                        @endif
                    @endif
                    
                @endif    
            </div>    
        </div>  
    </div><!-- br-pagebody -->
    
@endsection

@section('script')

    <script>
        $(document).ready(function(){
            
        })
    </script>
@endsection