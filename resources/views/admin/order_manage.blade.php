@extends('admin.layouts.app')

@section('content')
@php
    $page_range = array('10', '25', '50', '100');
@endphp
    <!-- ########## START: MAIN PANEL ########## -->
    <div class="br-mainpanel">
        <div class="br-pagetitle">
            <i class="icon ion-briefcase"></i>
            <div>
            <h4>Order Management</h4>
            <p class="mg-b-0">Registed All Orders</p>
        </div>            
    </div><!-- d-flex -->
    @if(Session::has('success'))
        <input type="hidden" name="" id="success_message" value="{{ Session::get('success') }}">
    @else
        <input type="hidden" name="" id="success_message" value="">
    @endif
    @if(Session::has('errors'))
        <input type="hidden" name="" id="error_message" value="{{ session('errors')->first('exist') }}">
    @else
        <input type="hidden" name="" id="error_message" value="">
    @endif
    <div class="br-pagebody">            
        <div class="row row-sm mg-t-20 card card-body">
            <div class="col-md-12">
                <div class="search-form">
                    <form action="{{ route('admin.order_manage') }}" method="POST" class="form-inline float-left" id="searchForm">
                        @csrf
                        <label for="pagesize" class="control-label ml-3 mb-2">Show :</label>
                        <select class="form-control form-control-sm mx-2 mb-2" name="pagesize" id="pagesize">
                            <option value="10" @if($pagesize == '10') selected @endif>10</option>
                            <option value="25" @if($pagesize == '25') selected @endif>25</option>
                            <option value="50" @if($pagesize == '50') selected @endif>50</option>
                            <option value="100" @if($pagesize == '100') selected @endif>100</option>
                            <option value="all" @if(!in_array($pagesize, $page_range)) selected @endif>All</option>
                        </select>
                    </form>
                    <div class="clearfix"></div>
                </div>
                <div class="bd bd-gray-300 rounded table-responsive">
                    <table class="table table-bordered mg-b-0">
                        <thead>
                            <th>No</th>
                            <th>Invoice ID</th>
                            <th>User Email</th>
                            <th>Wallet Address</th>
                            <th>Bitcoin Address</th>
                            <th>Bitcoin Amount(BIT)</th>
                            <th>Is Paid</th>
                            <th>Date</th>
                            <th>Detail</th>
                        </thead>
                        <tbody>                           
                            @forelse ($invoice as $item)
                                <tr>
                                    <td>{{ (($invoice->currentPage() - 1 ) * $invoice->perPage() ) + $loop->iteration }}</td>
                                    <td>{{ $item->my_invoice_id }}</td>
                                    <td>{{ $item->user ? $item->user->email : 'User deleted' }}</td>
                                    <td><a href="https://www.blockchain.com/btc/address/{{ $item->wallet_address }}" target="_blank">{{ $item->wallet_address }}</a></td>
                                    <td><a href="https://www.blockchain.com/btc/address/{{ $item->address }}" target="_blank">{{ $item->address }}</a></td>
                                    <td>{{ $item->price_in_bitcoin }}</td>
                                    <td>
                                        @if ($item->is_paid)
                                        <span class="badge badge-success">Paid</span>
                                        @else
                                            @if (!$item->invoice_payment->isEmpty())
                                            <span class="badge badge-warning">Pending</span>
                                            @else
                                                @if (!$item->invoice_pending_payment->isEmpty())
                                                <span class="badge badge-warning">Pending</span>
                                                @else
                                                <span class="badge badge-danger">Not Paid</span>
                                                @endif
                                            @endif
                                        @endif    
                                    </td>
                                    <td>{{ $item->updated_at }}</td>
                                    <td>
                                        <a href="{{ route('admin.order_detail', $item->id) }}">&nbsp;<i class="fa fa-eye" style="color:#24126A;">&nbsp;</i></a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">There is not registed orders.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-12">
                <div class="clearfix mt-2">
                    <div class="float-left" style="margin: 0;">
                        <p>Total <strong style="color: red">{{ $invoice->total() }}</strong> entries</p>
                    </div>
                    <div class="float-right" style="margin: 0;">
                        {{ $invoice->appends(['pagesize' => $pagesize])->links() }}
                    </div>
                </div>
            </div>
        </div><!-- row -->
    </div><!-- br-pagebody -->
    
@endsection

@section('script')
    <script>
        $(document).ready(function(){
            $("#pagesize").change(function(){
                $("#searchForm").submit();
            });
            
        })
    </script>
@endsection