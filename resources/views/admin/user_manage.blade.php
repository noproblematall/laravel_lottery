@extends('admin.layouts.app')

@section('content')
@php
    $page_range = array('10', '25', '50', '100');
@endphp
    <!-- ########## START: MAIN PANEL ########## -->
    <div class="br-mainpanel">
        <div class="br-pagetitle">
            <i class="icon ion-person-stalker"></i>
            <div>
            <h4>User Management</h4>
            <p class="mg-b-0">Registed All Users</p>
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
                    <form action="{{ route('admin.user_manage') }}" method="POST" class="form-inline float-left" id="searchForm">
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
                            <th>User ID</th>
                            <th>Email</th>
                            <th>Email Verified</th>
                            <th>Action</th>
                        </thead>
                        <tbody>                           
                            @forelse ($user as $item)
                                <tr>
                                    <td>{{ (($user->currentPage() - 1 ) * $user->perPage() ) + $loop->iteration }}</td>
                                    <td>{{ $item->username }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>
                                        @if ($item->email_verified_at != null)
                                            Yes ({{ $item->email_verified_at }})
                                        @else
                                            No
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.user_delete', $item->id) }}" onclick="return confirm('Are you sure?');">&nbsp;<i class="fa fa-trash" style="color:#24126A;">&nbsp;</i></a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">There is not registed users.</td>
                                </tr>

                            @endforelse                        
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-12">
                <div class="clearfix mt-2">
                    <div class="float-left" style="margin: 0;">
                        <p>Total <strong style="color: red">{{ $user->total() }}</strong> entries</p>
                    </div>
                    <div class="float-right" style="margin: 0;">
                        {{ $user->appends(['pagesize' => $pagesize])->links() }}
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
            
            if($('#success_message').val() != ''){
                toast_call('Success', $('#success_message').val())
            }else if($('#error_message').val() != ''){
                toast_call('Error', $('#error_message').val(), 'error')
            }
        })
    </script>
@endsection