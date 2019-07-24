@extends('layouts.app')
<link rel="stylesheet" href="{{URL::to('/')}}/css/candidate-login.min.css">
@section('content')
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <div class="login100-form-title" style="background: url({{asset('/img/candidate.jpg')}});background-position:center;background-repeat:no-repeat;height: 240px;">
                    <div class="logobox-login">
                        <img src="/dist/img/logo-gold-login_dy8gg5_c_scale,w_200.png" class="img-responsive center-block" width="130" height="130">
                        <hr>
                        <label style="margin-left: 15px">Candidate Login</label>
                    </div>
                </div>
                <form class="login100-form validate-form" method="POST" action="{{ route('candidate.auth.loginCandidate') }}" autocomplete="off">
                    {{ csrf_field() }}
                    <input type="hidden" name="timezone" id="timezone">
                    @if ($errors->has('email') || $errors->has('password'))
                        <div class="alert alert-danger" style="margin-top: 2%">
                            @if ($errors->has('email'))
                                <strong>{{  $errors->first('email') }}</strong>
                            @endif
                            @if ($errors->has('password'))
                                <strong>{{ $errors->first('password') }}</strong>
                            @endif
                        </div>
                    @endif
                    <div class="wrap-input100 validate-input m-b-26">
                        <span class="label-input100"><i class="glyphicon glyphicon-envelope"></i> @lang('auth.E-mail')</span>
                        <input class="input100" type="text" name="email" value="{{ Request::has('email')? request('email') : old('email')  }}" placeholder="Enter e-mail address">
                        <span class="focus-input100"></span>
                    </div>

                    <div class="wrap-input100 validate-input m-b-18">
                        <span class="label-input100"><i class="glyphicon glyphicon-lock"></i> @lang('auth.Password')</span>
                        <input class="input100" type="password" name="password" value="{{ Request::has('password')? request('password') : old('password') }}" placeholder="Enter password">
                        <span class="focus-input100"></span>
                    </div>

                    <div class="flex-sb-m w-full p-b-30">
                        <div class="contact100-form-checkbox">
                            <input class="input-checkbox100" id="ckb1" type="checkbox" name="remember">
                            <label class="label-checkbox100" for="ckb1">
                                @lang('auth.RememberMe')
                            </label>
                        </div>

                        <div>
                            <a href="{{ route('candidate.register') }}" class="txt1">
                                No account yet? Register here
                            </a>
                        </div>
                    </div>

                    <div class="container-login100-form-btn">
                        <button type="submit" class="btn bg-gold b-r4 text-white">
                            <i class="fa fa-btn fa-sign-in"></i> @lang('auth.Login')
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('post-body')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.13/moment-timezone-with-data.js"></script>
    <script>
        var timezone = moment.tz.guess();
        $('#timezone').val(timezone);
    </script>
@endsection