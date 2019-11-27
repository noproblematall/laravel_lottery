@extends('layouts.app')
@section('css')
    <style>
        .win_active {background-color: #FDB702;}
    </style>
@endsection
@section('content')
@php
    $page_range = array('10', '25', '50', '100');
@endphp

    <!-- ########## START: MAIN PANEL ########## -->
    <div class="br-mainpanel">
        <div class="br-pagetitle">
            <i class="icon ion-clock"></i>
            <div>
            <h4>History</h4>
            <p class="mg-b-0">History For Tickets</p>
        </div>            
    </div><!-- d-flex -->

    <div class="br-pagebody">      
        <div class="row row-sm mg-t-20 card card-body">
            <div class="col-md-12">
                <div class="search-form">
                    <form action="{{route('history')}}" method="POST" class="form-inline float-left" id="searchForm">
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
                            <th>Number</th>
                            <th>Invoice ID</th>
                            <th>Is Win</th>
                            <th>Created Date</th>
                            {{-- <th>Action</th> --}}
                        </thead>
                        <tbody>                           
                            @forelse ($tickets as $item)
                                @if ($item->is_win != null)
                                    <tr class="win_active">
                                        <td>{{ (($tickets->currentPage() - 1 ) * $tickets->perPage() ) + $loop->iteration }}</td>
                                        <td>{{ $item->number }}</td>
                                        <td>{{ $item->invoice->my_invoice_id }}</td>                                    
                                        <td>
                                            @if ($item->is_win != null)
                                                {{ $item->is_win }}% prize
                                            @else
                                                ---
                                            @endif
                                        </td>
                                        <td>{{ $item->created_at }}</td>
                                    </tr>
                                @else
                                    <tr>
                                        <td>{{ (($tickets->currentPage() - 1 ) * $tickets->perPage() ) + $loop->iteration }}</td>
                                        <td>{{ $item->number }}</td>
                                        <td>{{ $item->invoice->my_invoice_id }}</td>                                    
                                        <td>
                                            @if ($item->is_win != null)
                                                {{ $item->is_win }}% prize
                                            @else
                                                ---
                                            @endif
                                        </td>
                                        <td>{{ $item->created_at }}</td>
                                    </tr>
                                @endif                                
                            @empty
                                <tr>
                                    <td colspan="4">There is not registed tickets.</td>
                                </tr>

                            @endforelse                        
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-12">
                <div class="clearfix mt-2">
                    <div class="float-left" style="margin: 0;">
                        <p>Total <strong style="color: red">{{ $tickets->total() }}</strong> entries</p>
                    </div>
                    <div class="float-right" style="margin: 0;">
                        {{ $tickets->appends(['pagesize' => $pagesize])->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    
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