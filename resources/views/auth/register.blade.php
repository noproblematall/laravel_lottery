<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Register | {{ config('app.name', 'Lottery') }}</title>

    <!-- Bracket CSS -->
    <link rel="stylesheet" href="{{asset('css/spinkit.css')}}">
    <link rel="stylesheet" href="{{asset('css/bracket.css')}}">
    <link rel="stylesheet" href="{{asset('css/admin.css')}}">
  </head>

  <body>
    @php
        $payment_flag = session('payment_flag');
        $data = session('post_home');
        $email = '';
        if($payment_flag) {$email = $data['email'];}
    @endphp
    <div class="d-flex align-items-center justify-content-center bg-custom ht-100v">        
        <form action="{{ route('register') }}" method="post">
            @csrf
            <div class="login-wrapper wd-300 wd-xs-350 pd-25 pd-xs-40 bg-white rounded shadow-base" id="register_form">
                <div class="signin-logo tx-center tx-28 tx-bold tx-inverse"><a href="{{ asset('/') }}"><span class="tx-normal">[ LOGO ]</span></a></div>
                <div class="tx-center mg-b-30">Please enter your info</div>

                <div class="form-group">
                <div class="form-group">
                    <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" placeholder="Enter Your User ID" required>
                    @error('username')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div><!-- form-group -->
                <div class="form-group">
                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email == '' ? old('email') : $email }}" placeholder="Enter your email" required>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div><!-- form-group -->
                <div class="form-group">
                    <label class="d-block tx-11 tx-uppercase tx-medium tx-spacing-1">The password must be at least 8 characters.</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Enter your password" required>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div><!-- form-group -->
                <div class="form-group">
                    <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm your password" required>
                </div><!-- form-group -->

                <div class="form-group tx-12">By clicking the Sign Up button below, you agreed to our privacy policy and terms of use of our website.</div>
                <button type="submit" class="btn btn-custom btn-block">Sign Up</button>

                <div class="mg-t-10 tx-center">Already a member? <a href="{{ route('login') }}" class="tx-info">Sign In</a></div>
                <div class="mg-t-10 tx-center"><a href="{{ route('welcome') }}" class="tx-info">Go to homepage</a></div>
            </div><!-- login-wrapper -->
        </form>
    </div><!-- d-flex -->

    <div class="loader_container display_none">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1 bg-gray-800"></div>
            <div class="sk-child sk-bounce2 bg-gray-800"></div>
            <div class="sk-child sk-bounce3 bg-gray-800"></div>
        </div>
    </div>

    <script src="{{asset('js/app.js')}}"></script>
    <script defer>
        
    </script>
  </body>
</html>
