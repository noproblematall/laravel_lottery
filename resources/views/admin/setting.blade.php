@extends('admin.layouts.app')
@section('css')
{{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css"> --}}
<link rel="stylesheet" href="{{ asset('library/datetime/css/bootstrap-datetimepicker.min.css') }}">
<style>
    body{background-color: #E9ECEF;}
    .btn-custom{background-color: #FDB702;border-color: #FDB702;color: #24126A;font-weight: bold;}
    .invalid-feedback {display: block;}
    div.timepicker-picker span.glyphicon-chevron-up{color: #24126a !important;font-weight: bold;}
    .glyphicon-chevron-up:before {
        content: "⊼";
    }
    div.timepicker-picker span.glyphicon-chevron-down{color: #24126a !important;font-weight: bold;}
    .glyphicon-chevron-down:before {
        content: "⊻";
    }
    div.timepicker-picker {color: #24126A !important;}
</style>
@endsection
@section('content')
@php
    $page_range = array('10', '25', '50', '100');
    $setting == null ? $flag = 0 : $flag = 1;
@endphp
    <!-- ########## START: MAIN PANEL ########## -->
    <div class="br-mainpanel">
        <div class="br-pagetitle">
            <i class="icon ion-gear-b"></i>
            <div>
            <h4>Setting</h4>
            <p class="mg-b-0">Setting for lottery</p>
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
        <div class="card card-body p-4">
            <div class="row row-sm mg-t-20">
                <div class="col-md-6">
                    <h3 class="text-center">Time for prize ,Cost for ticket and Minimum</h3>
                    <form action="{{ route('admin.time_cost') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="prize1_time">Time for prize1</label>
                            <input type="text" name="time_of_prize1" class="form-control" value="{{ $flag == 1 ? $setting->time_of_prize1 : old('time_of_prize1') }}" id="prize1_time">
                            @error('time_of_prize1')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="prize2_time">Time for prize2</label>
                            <input type="text" name="time_of_prize2" class="form-control" value="{{ $flag == 1 ? $setting->time_of_prize2 : old('time_of_prize2') }}" id="prize2_time">
                            @error('time_of_prize2')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="prize3_time">Time for prize3</label>
                            <input type="text" name="time_of_prize3" value="{{ $flag == 1 ? $setting->time_of_prize3 : old('time_of_prize3') }}" class="form-control" id="prize3_time">
                        </div>
                        @error('time_of_prize3')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <div class="form-group">
                            <label for="prize3_time">Cost of ticket (BTC)</label>
                            <input type="text" name="cost_of_ticket" value="{{ $flag == 1 ? $setting->cost_of_ticket : old('cost_of_ticket') }}" class="form-control" id="cost_of_ticket">
                            @error('cost_of_ticket')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="min_of_btc">Minimum BTC For Sold Tickets (BTC)</label>
                            <input type="text" name="min_of_btc" value="{{ $flag == 1 ? $setting->min_of_btc : old('min_of_btc') }}" class="form-control" id="min_of_btc">
                            @error('min_of_btc')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-custom form-control">Update</button>
                    </form>
                </div>
                <div class="col-md-6">
                    <h3 class="text-center">The Minimum Amount For Each Prize (BTC)</h3>
                    <div class="bd rounded table-responsive mg-t-40">
                        <table class="table table-bordered mg-b-0 text-center">
                            <thead>
                                <tr>
                                    <th>Minimum BTC For Sold Tickets</th>
                                    <th>Minimum BTC For Prize1</th>
                                    <th>Minimum BTC For Prize2</th>
                                    <th>Minimum BTC For Prize3</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $setting->min_of_btc }}</td>
                                    <td>{{ $setting->min_of_btc * 0.05 }}</td>
                                    <td>{{ $setting->min_of_btc * 0.15 }}</td>
                                    <td>{{ $setting->min_of_btc * 0.4 }}</td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
               
            </div><!-- row -->

        </div>
    </div><!-- br-pagebody -->
    
@endsection

@section('script')
{{-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script> --}}
<script src="{{ asset('library/moment/moment.min.js') }}"></script>
<script src="{{ asset('library/datetime/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script>
        $(document).ready(function(){
            // $('#lottery_date').datetimepicker({
            //     minDate: new Date(),
            //     format: 'Y-M-D'
            // });
            $('#prize1_time').datetimepicker({
                useCurrent: false,
                format: 'HH:mm',
            })
            $("#prize1_time").on("dp.change", function (e) {
                $('#prize2_time').data("DateTimePicker").minDate(e.date);
                $('#prize3_time').data("DateTimePicker").minDate(e.date);
            });
            $('#prize2_time').datetimepicker({
                useCurrent: false,
                format: 'HH:mm',
            })
            $("#prize2_time").on("dp.change", function (e) {
                $('#prize3_time').data("DateTimePicker").minDate(e.date);
            });
            $('#prize3_time').datetimepicker({
                useCurrent: false,
                format: 'HH:mm',
            })
            
            if($('#success_message').val() != ''){
                toast_call('Success', $('#success_message').val())
            }else if($('#error_message').val() != ''){
                toast_call('Error', $('#error_message').val(), 'error')
            }
        })
    </script>
@endsection