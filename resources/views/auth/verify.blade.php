<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login</title>

    <!-- vendor css -->
    <link href="{{asset('css/all.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/ionicons.min.css')}}" rel="stylesheet">

    <!-- Bracket CSS -->
    <link rel="stylesheet" href="{{asset('css/bracket.css')}}">
    <link rel="stylesheet" href="{{asset('css/admin.css')}}">
  </head>

  <body>
    <div class="d-flex align-items-center justify-content-center bg-custom ht-100v">
        
        <div class="login-wrapper wd-500 wd-xs-350 pd-25 pd-xs-40 bg-white rounded shadow-base" style="padding-top:20px;">
            <div class="signin-logo tx-center tx-28 tx-bold tx-inverse" style="margin-bottom:15px;"><a href="{{route('welcome')}}">LOGO</a></div>
            @if (isset($response))
              @if (property_exists($response, 'message'))
                <div class="alert alert-danger" role="alert">                
                  <strong class="d-block d-sm-inline-block-force">{{$response->message}} ! &nbsp;</strong>{{$response->description}}
                  So, Please try again in a few minutes. Thank you for your patient.
                </div>                
              @endif                
            @endif

            <div class="tx-center mg-b-30">{{ __('Verify Your Email Address') }}</div>
            @if (session('resent'))
                <div class="alert alert-success" role="alert">
                    {{ __('A fresh verification link has been sent to your email address.') }}
                </div>
            @endif

            {{ __('Before proceeding, please check your email for a verification link.') }}
            {{ __('If you did not receive the email') }}, <a style="color:#23BF08;" href="{{ route('verification.resend') }}">{{ __('click here to request another') }}</a>.
            
        </div><!-- login-wrapper -->

    </div><!-- d-flex -->

  </body>
</html>


