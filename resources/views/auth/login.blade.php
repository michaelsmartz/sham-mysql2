@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4 ">
            <div class="logobox">
                    <picture>
                        <source
                        media="(max-width: 767px)"
                        sizes="(max-width: 200px) 100vw, 200px"
                        srcset="
                        /dist/img/logo-gold-login_dy8gg5_ar_1_1,c_fill,g_auto__c_scale,w_200.png 200w">
                        <source
                        media="(min-width: 768px) and (max-width: 991px)"
                        sizes="(max-width: 286px) 70vw, 200px"
                        srcset="
                        /dist/img/logo-gold-login_dy8gg5_ar_4_3,c_fill,g_auto__c_scale,w_200.png 200w">
                        <source
                        media="(min-width: 992px) and (max-width: 1199px)"
                        sizes="(max-width: 333px) 60vw, 200px"
                        srcset="
                        /dist/img/logo-gold-login_dy8gg5_ar_16_9,c_fill,g_auto__c_scale,w_200.png 200w">
                        <img
                        sizes="(max-width: 500px) 40vw, 200px"
                        srcset="
                        /dist/img/logo-gold-login_dy8gg5_c_scale,w_200.png 200w"
                        src="/dist/img/logo-gold-login_dy8gg5_c_scale,w_200.png"
                        alt="">
                    </picture>
            </div>
            <!--<h2 class="section-heading">Smartz Human Asset Management</h2>-->
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-heading" style="border-bottom: 1px solid #ddd;">
                    <span class="glyphicon glyphicon-lock"></span> @lang('auth.Login')
                </div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('login') }}" autocomplete="off">
                        {{ csrf_field() }}
                        <input type="hidden" name="timezone" id="timezone">
                        @if(env('USE_C4_AUTH',0) == 0)
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label class="control-label">@lang('auth.E-mail')</label>
                                <input type="email" class="form-control field-required" name="email" value="{{ Request::has('email')? request('email') : old('email')  }}">
                            </div>
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label class="control-label">@lang('auth.Password')</label>
                                <input type="password" class="form-control" autocomplete="off" name="password" value="{{ Request::has('password')? request('password') : old('password') }}">
                            </div>
                        @else
                            <p><b><i>Please use your C4 credentials to login..</i></b></p>
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label class="control-label">C4 Username</label>
                                <input type="text" class="form-control field-required" name="email" value="{{ old('email') }}">
                            </div>
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label class="control-label">C4 Password</label>
                                <input type="password" class="form-control" autocomplete="off" name="password">
                            </div>
                        @endif

                        <div class="form-group pull-right">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="remember"> @lang('auth.RememberMe')
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn bg-gold b-r4 text-white">
                                <i class="fa fa-btn fa-sign-in"></i> @lang('auth.Login')
                            </button>
                        </div>
                        @if ($errors->has('email') || $errors->has('password'))
                            <div class="alert alert-danger">
                                @if ($errors->has('email'))
                                    <strong>{{  $errors->first('email') }}</strong>
                                @endif
                                @if ($errors->has('password'))
                                    <strong>{{ $errors->first('password') }}</strong>
                                @endif
                            </div>
                        @endif
                    </form>
                </div>
            </div>
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
