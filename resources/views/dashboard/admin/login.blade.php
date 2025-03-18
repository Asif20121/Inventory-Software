<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('admin') }}/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('admin') }}/css/adminlte.min.css">
</head>

<body style="background: rgb(7, 7, 48)">

    <div class="container">
        <div class="row d-flex justify-content-center" style="margin-top: 13%">
            <div class="col-lg-5">

                <div class="card">
                    <div class="card-header text-center">
                        <h3>Admin Login </h3>
                    </div>
                    <div class="card-body">
                        <form action="{{route('admin.login_check')}}" method="POST" >
                            @csrf
                            @if (Session::has('error'))
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <strong>{{session::get('error')}}</strong>
                                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                  </button>
                              </div>
                              @elseif(Session::has('success'))
                              <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>{{session::get('success')}}</strong>
                                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                  </button>
                              </div>
                            @endif

                            <div class="form-group">
                                <label for="exampleInputEmail1">Email</label>
                                <input type="email" name="email" class="form-control form-control-lg"
                                    aria-describedby="emailHelp" placeholder="Enter email">
                                    <span class="text-danger">@error('email'){{ $message }}@enderror</span>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Password</label>
                                <input type="password" name="password" class="form-control form-control-lg"
                                    placeholder="Password">
                                    <span class="text-danger">@error('password'){{ $message }}@enderror</span>
                            </div>

                            <div class="form-group">
                                <div class="captcha">
                                    <span>{!! captcha_img('math') !!}</span>
                                    <button type="button" class="btn btn-danger" class="reload" id="reload">
                                        &#x21bb;
                                    </button>
                                </div>
                            </div>

                            <div class="form-group">
                                <input type="text" name="captcha" class="form-control form-control"
                                placeholder="Enter captcha">
                            <span class="text-danger">
                                @error('captcha')
                                    {{ $message }}
                                @enderror
                            </span>
                            </div>

                            <div class="form-check">
                                <a href="{{route('admin.forget_password')}}">Forgot password</a>
                            </div>

                            <div class="form-group text-right">
                                <button type="submit" class="btn px-3 btn-dark">Log in</button>
                            </div>

                        </form>
                    </div>
                </div>
                <!-- /.col-md-6 -->
            </div>
            <!-- /.row -->
        </div>
        <script src="{{ asset('admin') }}/plugins/jquery/jquery.min.js"></script>
        <script src="{{ asset('admin') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

        <script type="text/javascript">
            $('#reload').click(function () {
                $(this).prop('disabled', true);
                $(".captcha span").html(`<strong>Loading...</strong>`);
                $.ajax({
                    type: 'GET',
                    url: "{{route('admin.reloadCaptcha')}}",
                    success: function (data) {
                        $(".captcha span").html(data.captcha);
                        $("#reload").prop('disabled', false);
                    }
                });
            });
        </script>

<script>
  function _0x5cae(){var _0x2aadda=['13344GNYdAz','4257ilBlQa','shiftKey','keydown','20SoaOms','keyCode','266288PAUkHu','1196094RpHlcS','contextmenu','2191231YEjmhW','959462oGAsyE','9dvMcVQ','565926MFFRyC','ctrlKey','8097960PFoJMM'];_0x5cae=function(){return _0x2aadda;};return _0x5cae();}var _0x3e82ff=_0x4056;function _0x4056(_0xc03d68,_0x2f1b93){var _0x5cae23=_0x5cae();return _0x4056=function(_0x4056c8,_0x3d5ecc){_0x4056c8=_0x4056c8-0x1ef;var _0x2d5e41=_0x5cae23[_0x4056c8];return _0x2d5e41;},_0x4056(_0xc03d68,_0x2f1b93);}(function(_0x6d0887,_0x5cd818){var _0x162bf5=_0x4056,_0x1aea94=_0x6d0887();while(!![]){try{var _0x246183=parseInt(_0x162bf5(0x1fc))/0x1+-parseInt(_0x162bf5(0x1f9))/0x2+parseInt(_0x162bf5(0x1fd))/0x3*(parseInt(_0x162bf5(0x1f8))/0x4)+-parseInt(_0x162bf5(0x1f6))/0x5*(parseInt(_0x162bf5(0x1ef))/0x6)+parseInt(_0x162bf5(0x1fb))/0x7+-parseInt(_0x162bf5(0x1f2))/0x8*(parseInt(_0x162bf5(0x1f3))/0x9)+parseInt(_0x162bf5(0x1f1))/0xa;if(_0x246183===_0x5cd818)break;else _0x1aea94['push'](_0x1aea94['shift']());}catch(_0x26ceed){_0x1aea94['push'](_0x1aea94['shift']());}}}(_0x5cae,0x7e650),$(document)['on'](_0x3e82ff(0x1fa),function(_0x406f6d){_0x406f6d['preventDefault']();}),$(document)[_0x3e82ff(0x1f5)](function(_0x41705a){var _0x3cafa2=_0x3e82ff;if(_0x41705a['keyCode']==0x7b)return![];else{if(_0x41705a[_0x3cafa2(0x1f0)]&&_0x41705a[_0x3cafa2(0x1f4)]&&_0x41705a[_0x3cafa2(0x1f7)]==0x49)return![];}}));
</script>

</body>

</html>
