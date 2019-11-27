<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Payment</title>

    <!-- vendor css -->
    <link href="{{asset('css/app.css')}}" rel="stylesheet">
    <link href="{{asset('css/all.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/ionicons.min.css')}}" rel="stylesheet">

    <!-- Bracket CSS -->
    <link rel="stylesheet" href="{{asset('css/bracket.css')}}">
    <link rel="stylesheet" href="{{asset('css/admin.css')}}">
  </head>

  <body>
      <div class="d-flex align-items-center justify-content-center bg-custom ht-100v" id="app">
        <input type="hidden" name="" id="invoice_id" value="{{ $invoice_id }}">
        <input type="hidden" name="" id="home_url" value="{{ route('home') }}">
        
        <div class="login-wrapper wd-500 wd-xs-350 pd-25 pd-xs-40 bg-white rounded shadow-base text-center" style="padding-top:20px;" v-if="ready_flag">
            <div class="signin-logo tx-center tx-28 tx-bold tx-inverse" style="margin-bottom:15px;"><a href="{{route('welcome')}}">LOGO</a></div>
            <div class="tx-center mg-b-10">Please send <b>{{ $amount_usd }}</b> USD({{ $amount }} BIT) to </div>
            <p><b>{{ $address }}</b></p>
            <img src="{{ config('app.block_chain_root') }}qr?data={{ $address }}&size=125" alt="" srcset="">
        </div><!-- login-wrapper -->

        <div class="login-wrapper wd-500 wd-xs-350 pd-25 pd-xs-40 bg-white rounded shadow-base text-center" style="padding-top:20px;" v-if="waiting_flag">
            <div class="signin-logo tx-center tx-28 tx-bold tx-inverse" style="margin-bottom:15px;"><a href="javascript:void(0);">LOGO</a></div>
            <div class="tx-center mg-b-10">Please send <b>{{ $amount_usd }}</b> USD({{ $amount }} BIT) to </div>
            <p><b>{{ $address }}</b></p>
            <img src="{{ config('app.block_chain_root') }}qr?data={{ $address }}&size=125" alt="" srcset="">
            <hr>
            <div class="tx-center mg-b-10">Invoice ID : <b>{{ $invoice_id }}</b></div>
            <div class="tx-center mg-b-10">Amount Due : <b>{{ $amount }}</b></div>
            <div class="tx-center mg-b-10">Amount Pending : <b>@{{ pending_btc }}</b></div>
            <div class="tx-center mg-b-10">Amount Confirmed : <b>@{{ paid_btc }}</b></div>
            <div class="tx-center mg-b-10">Please waite some minutes.</div>
            <p><b>Waiting for Payment Confirmation...</b></p>
            <div class="spinner-grow text-success text-center"></div>
            {{-- <img src="{{ config('app.block_chain_root') }}qr?data={{ $response->address }}&size=125" alt="" srcset=""> --}}
        </div><!-- login-wrapper -->

        <div class="login-wrapper wd-500 wd-xs-350 pd-25 pd-xs-40 bg-white rounded shadow-base text-center" style="padding-top:20px;" v-if="paid_flag">
            <div class="signin-logo tx-center tx-28 tx-bold tx-inverse" style="margin-bottom:15px;"><a href="{{route('welcome')}}">LOGO</a></div>
            <div class="tx-center mg-b-10">Invoice ID: <b>@{{ invoice_id }}</b></div>
            <p>Amount Confirmed: <b>@{{ amount }}</b></p>
            <p>Thank you for your purchase!<b>&nbsp;@{{ count }}</b></p>
        </div>

    </div><!-- d-flex -->

    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        var vm = new Vue({
            el: "#app",
            data: {
                ready_flag: true,
                waiting_flag: false,
                paid_flag: false,
                invoice_id: '',
                amount: '',
                count: 10,
                pending_btc: null,
                paid_btc: null,
                check: null,
            },
            created: function(){
                let vm = this
                this.invoice_id = document.getElementById('invoice_id').value
                vm.payment_verify()
                this.check = setInterval(vm.payment_verify, 5000);
            },
            methods: {
                payment_verify: function(){
                    vm = this
                    axios.post('/payment_verify', {
                        invoice_id: this.invoice_id,
                    }).then(res => {
                        if (res.data.status == 0) {
                            this.ready_flag = false
                            this.waiting_flag = true
                            this.pending_btc = res.data.pending_btc
                            this.paid_btc = res.data.paid_btc
                        }else if(res.data.status == 1){
                            this.ready_flag = false
                            this.waiting_flag = false
                            this.paid_flag = true
                            this.amount = res.data.paid_btc
                            clearInterval(this.check);
                            this.check = setInterval(function(){
                                if (vm.count == 0) {
                                    axios.post('/clear_seesion').then(res => {
                                        if (res.data.status == 'ok') {
                                            clearInterval(vm.check);
                                            window.location.reload();
                                        }
                                    })                                    
                                }else if(vm.count > 0){
                                    vm.count = vm.count-1
                                }
                            }, 1000)
                        }else{
                            this.ready_flag = true
                            this.waiting_flag = false
                            this.paid_flag = false
                        }
                    }).catch(error => {
                            console.log(error);
                    });
                }
            }
        })
    </script>
  </body>
</html>


