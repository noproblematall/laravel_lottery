<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{config('app.name')}}</title>
    
    <!-- vendor css -->
    <link href="{{asset('css/all.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/ionicons.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/select2.min.css')}}" rel="stylesheet">

    <!-- Bracket CSS -->
    <link rel="stylesheet" href="{{asset('css/bracket.css')}}">
    <link rel="stylesheet" href="{{asset('css/spinkit.css')}}">
    <link href="{{ asset('library/jquery_toast/jquery.toast.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/admin.css')}}">
    @yield('css')
  </head>

  <body>
    @php
        $user = auth()->user();
    @endphp
    <input type="hidden" id="base_url" value="{{asset('/')}}">
    <!-- ########## START: LEFT PANEL ########## -->
    
    @include('admin.layouts.side')
    
    <!-- ########## END: LEFT PANEL ########## -->

    <!-- ########## START: HEAD PANEL ########## -->
    @include('admin.layouts.header')
    <!-- ########## END: HEAD PANEL ########## -->

    @yield('content')

    {{-- @include('admin.layouts.footer') --}}
    <!-- The Profile Modal -->
    <div class="modal fade effect-fall" id="profile_modal">
      <div class="modal-dialog" style="margin-top:100px;">
        <div class="modal-content">
          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">Profile Edit</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <!-- Modal body -->
          <div class="modal-body">
            <div class="alert alert-success display_none" id="alert0" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <div class="d-flex align-items-center justify-content-start">
                  <i class="icon ion-ios-checkmark alert-icon tx-32 mg-t-5 mg-xs-t-0"></i>
                  <span><strong>Well done!</strong> Your profile was changed successfully.</span>
                </div><!-- d-flex -->
              </div><!-- alert -->
              @csrf
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="icon ion-person tx-16 lh-0 op-6"></i></span>
              </div>
              <input type="text" id="username" class="form-control" placeholder="Username" autocomplete="off">
            </div><!-- input-group -->
            <br>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="icon ion-email tx-16 lh-0 op-6"></i></span>
              </div>
              <input type="email" id="email" class="form-control" placeholder="Email">
            </div><!-- input-group -->
            <br>
            <div class="custom-file">
              <input type="file" id="photo" class="custom-file-input">
              <label class="custom-file-label">Profile Photo</label>
            </div>
          </div>

          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="profile_save">Save</button>
            <button type="button" id="profile_close" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>

        </div>
      </div>
    </div>
    <!-- The Password Modal -->
    <div class="modal fade effect-fall" id="password_modal">
      <div class="modal-dialog" style="margin-top:100px;">
        <div class="modal-content">
          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">Change Password</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <!-- Modal body -->
          <div class="modal-body">
            <div class="alert alert-success display_none" id="alert1" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <div class="d-flex align-items-center justify-content-start">
                <i class="icon ion-ios-checkmark alert-icon tx-32 mg-t-5 mg-xs-t-0"></i>
                <span><strong>Well done!</strong> Your password was changed successfully.</span>
              </div><!-- d-flex -->
            </div><!-- alert -->
            <div class="alert alert-danger display_none" id="alert2" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <div class="d-flex align-items-center justify-content-start">
                <i class="icon ion-ios-checkmark alert-icon tx-32 mg-t-5 mg-xs-t-0"></i>
                <span><strong>Fail !</strong> The old password is incorrect.</span>
              </div><!-- d-flex -->
            </div><!-- alert -->
            <input class="form-control" id="old_password" placeholder="Old Password" type="password" autocomplete="off">
            <small class="first">Please enter old password</small>
            <br>
            <input class="form-control" id="new_password" placeholder="New Password" type="password">
            <small class="second">Please enter new password</small>
            <small class="third">Passwords must be match the confirmation.</small>
            <br>
            <input class="form-control" id="confirm_password" placeholder="Confirm Password" type="password">
          </div>

          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="password_save">Save</button>
            <button type="button" id="password_close" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>

        </div>
      </div>
    </div>

    <div class="loader_container display_none">
      <div class="sk-three-bounce">
        <div class="sk-child sk-bounce1 bg-gray-800"></div>
        <div class="sk-child sk-bounce2 bg-gray-800"></div>
        <div class="sk-child sk-bounce3 bg-gray-800"></div>
      </div>
    </div>


    <script src="{{asset('js/app.js')}}"></script>
    <script src="{{asset('js/perfect-scrollbar.min.js')}}"></script>
    <script src="{{asset('js/bracket.js')}}"></script>
    <script src="{{ asset('library/jquery_toast/jquery.toast.min.js') }}"></script>
        
    <script>
      $(document).ready(function(){
        $('#password_close').click(function(){
          $('#old_password').val('');
          $('#new_password').val('');
          $('#confirm_password').val('');
          $('#alert1').addClass('display_none');
          $('#alert2').addClass('display_none');
        })
        $('#profile_close').click(function(){
          $('#username').val('');
          $('#email').val('');
          $('#photo').val('');
          $('#alert0').addClass('display_none');
        })
        $('#profile').click(function(){
          $('#profile_modal').modal({backdrop:'static'});
        })
        $('#password_change').click(function(){
          $('#password_modal').modal({backdrop:'static'});
        })

        $('#profile_save').click(function(){
          let username = $('#username').val()
          let email = $('#email').val();
          var formData = new FormData();
          formData.append('username', username);          
          formData.append('email', email);
          formData.append('photo', $('#photo')[0].files[0]);
          formData.append('_token', $('input[name=_token]').val());
          $.ajax({
            url: '/profile',
            data: formData,
            type: 'post',
            contentType: false,
            processData: false,
            beforeSend: function () { $('.loader_container').removeClass('display_none'); },
            success: function(data){
              if(data.success != ''){
                $('#alert0').removeClass('display_none');
                location.reload()
              }
            }
          }).done(function () {
              $('.loader_container').addClass('display_none');
          })

        })

        $('#password_save').click(function(){
          let old_password = $('#old_password').val();
          let new_password = $('#new_password').val();
          let confirm_password = $('#confirm_password').val();
          if(old_password == ''){
            $('small.first').addClass('display_show');
            return false;
          }
          if(new_password == ''){
            $('small.first').removeClass('display_show');
            $('small.second').addClass('display_show');
            return false;
          }
          if(new_password != confirm_password){
            $('small.second').removeClass('display_show');
            $('small.third').addClass('display_show');
            return false;
          }
          $('small.first').removeClass('display_show');
          $('small.second').removeClass('display_show');
          $('small.third').removeClass('display_show');
          $.ajax({
            url: '/password',
            type: 'get',
            data: {old_password:old_password, new_password:new_password},
            beforeSend: function () { $('.loader_container').removeClass('display_none'); },
            success: function(data){
              if(data.error){
                $('#alert1').addClass('display_none');
                $('#alert2').removeClass('display_none');
              }else{
                $('#alert2').addClass('display_none');
                $('#alert1').removeClass('display_none');
              }
            }
          }).done(function () {
              $('.loader_container').addClass('display_none');
          })
        })
      })

      $(document).ready(function(){
        $(".custom-file-input").on("change", function() {
            let fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
    })

      function toast_call(type, text, icon = 'success') {
        $.toast({
            heading: type,
            text: text,
            showHideTransition: 'slide',
            icon: icon,
            position: 'bottom-right',
            hideAfter: 5000,
        })
      }
    </script>
    @yield('script')
  </body>
</html>
