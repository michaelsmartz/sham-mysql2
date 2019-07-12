@extends('layouts.app')

@section('content')
    <style type="text/css">
        ul, li {
            margin: 0px;
            list-style-type: none;
        }

        input {
            outline: none;
            border: none;
        }

        input:focus::-webkit-input-placeholder { color:transparent; }
        input:focus:-moz-placeholder { color:transparent; }
        input:focus::-moz-placeholder { color:transparent; }
        input:focus:-ms-input-placeholder { color:transparent; }

        textarea:focus::-webkit-input-placeholder { color:transparent; }
        textarea:focus:-moz-placeholder { color:transparent; }
        textarea:focus::-moz-placeholder { color:transparent; }
        textarea:focus:-ms-input-placeholder { color:transparent; }

        input::-webkit-input-placeholder {color: #999999;}
        input:-moz-placeholder {color: #999999;}
        input::-moz-placeholder {color: #999999;}
        input:-ms-input-placeholder {color: #999999;}

        textarea::-webkit-input-placeholder {color: #999999;}
        textarea:-moz-placeholder {color: #999999;}
        textarea::-moz-placeholder {color: #999999;}
        textarea:-ms-input-placeholder {color: #999999;}

        label {
            display: block;
            margin: 0;
        }

        .txt1 {

            font-size: 13px;
            line-height: 1.4;
            color: #999999;
        }

        .limiter {
            width: 100%;
            margin: 0 auto;
        }

        .container-login100 {
            width: 100%;
            min-height: 100vh;
            display: -webkit-box;
            display: -webkit-flex;
            display: -moz-box;
            display: -ms-flexbox;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            padding: 15px;
            background: #ebeeef;
        }


        .wrap-login100 {
            width: 640px;
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            position: relative;
        }


        .login100-form-title {
            width: 100%;
            position: relative;
            z-index: 1;
            display: -webkit-box;
            display: -webkit-flex;
            display: -moz-box;
            display: -ms-flexbox;
            display: flex;
            flex-wrap: wrap;
            flex-direction: column;
            align-items: center;

            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;

            padding: 70px 15px 74px 15px;
        }

        .login100-form-title-1 {
            font-size: 30px;
            color: #fff;
            line-height: 1.2;
            text-align: center;
            padding: 2%;
        }

        .login100-form-title::before {
            content: "";
            display: block;
            position: absolute;
            z-index: -1;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            background-color: rgba(255,255,255,0.7)
        }

        .login100-form {
            width: 100%;
            display: -webkit-box;
            display: -webkit-flex;
            display: -moz-box;
            display: -ms-flexbox;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            padding: 43px 88px 93px 190px;
        }

        .wrap-input100 {
            width: 100%;
            position: relative;
            border-bottom: 1px solid #b2b2b2;
        }

        .label-input100 {
            font-size: 15px;
            color: #808080;
            line-height: 1.2;
            text-align: left;

            position: absolute;
            top: 14px;
            left: -125px;
            width: 155px;

        }

        .input100 {
            font-size: 15px;
            color: #555555;
            line-height: 1.2;

            display: block;
            width: 100%;
            background: transparent;
            padding: 0 5px;
        }

        .focus-input100 {
            position: absolute;
            display: block;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            pointer-events: none;
        }

        .focus-input100::before {
            content: "";
            display: block;
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 0;
            height: 1px;

            -webkit-transition: all 0.6s;
            -o-transition: all 0.6s;
            -moz-transition: all 0.6s;
            transition: all 0.6s;

            background: #57b846;
        }

        input.input100 {
            height: 45px;
        }


        .input100:focus + .focus-input100::before {
            width: 100%;
        }

        .has-val.input100 + .focus-input100::before {
            width: 100%;
        }

        .input-checkbox100 {
            display: none;
        }

        .label-checkbox100 {
            font-size: 13px;
            color: #999999;
            line-height: 1.4;

            display: block;
            position: relative;
            padding-left: 26px;
            cursor: pointer;
        }

        .label-checkbox100::before {
            content: "\f00c";
            font-size: 13px;
            color: transparent;

            display: -webkit-box;
            display: -webkit-flex;
            display: -moz-box;
            display: -ms-flexbox;
            display: flex;
            justify-content: center;
            align-items: center;
            position: absolute;
            width: 18px;
            height: 18px;
            border-radius: 2px;
            background: #fff;
            border: 1px solid #e6e6e6;
            left: 0;
            top: 50%;
            -webkit-transform: translateY(-50%);
            -moz-transform: translateY(-50%);
            -ms-transform: translateY(-50%);
            -o-transform: translateY(-50%);
            transform: translateY(-50%);
        }

        .input-checkbox100:checked + .label-checkbox100::before {
            color: #57b846;
        }

        .container-login100-form-btn {
            width: 100%;
            display: -webkit-box;
            display: -webkit-flex;
            display: -moz-box;
            display: -ms-flexbox;
            display: flex;
            flex-wrap: wrap;
        }

        .login100-form-btn {
            display: -webkit-box;
            display: -webkit-flex;
            display: -moz-box;
            display: -ms-flexbox;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 0 20px;
            min-width: 160px;
            height: 50px;
            background-color: #57b846;
            border-radius: 25px;

            font-size: 16px;
            color: #fff;
            line-height: 1.2;

            -webkit-transition: all 0.4s;
            -o-transition: all 0.4s;
            -moz-transition: all 0.4s;
            transition: all 0.4s;
        }

        .login100-form-btn:hover {
            background-color: #333333;
        }


        @media (max-width: 576px) {
            .login100-form {
                padding: 43px 15px 57px 117px;
            }
        }

        @media (max-width: 480px) {
            .login100-form {
                padding: 43px 15px 57px 15px;
            }

            .label-input100 {
                text-align: left;
                position: unset;
                top: unset;
                left: unset;
                width: 100%;
                padding: 0 5px;
            }
        }

        .validate-input {
            position: relative;
        }


        .p-b-30 {padding-bottom: 30px;}
        .m-b-18 {margin-bottom: 18px;}
        .m-b-26 {margin-bottom: 26px;}
        .w-full {width: 100%;}

        .wrap-pic-w img {width: 100%;}
        .wrap-pic-max-w img {max-width: 100%;}


        .wrap-pic-h img {height: 100%;}
        .wrap-pic-max-h img {max-height: 100%;}

        .wrap-pic-cir img {
            width: 100%;
        }

        .hov-img-zoom img{
            width: 100%;
            -webkit-transition: all 0.6s;
            -o-transition: all 0.6s;
            -moz-transition: all 0.6s;
            transition: all 0.6s;
        }
        .hov-img-zoom:hover img {
            -webkit-transform: scale(1.1);
            -moz-transform: scale(1.1);
            -ms-transform: scale(1.1);
            -o-transform: scale(1.1);
            transform: scale(1.1);
        }


        .flex-sb-m {
            display: -webkit-box;
            display: -webkit-flex;
            display: -moz-box;
            display: -ms-flexbox;
            display: flex;
            justify-content: space-between;
            -ms-align-items: center;
            align-items: center;
        }
    </style>
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <div class="login100-form-title" style="background: url({{asset('/img/candidate.jpg')}});background-position:cover;background-repeat:no-repeat;height: 350px;">
                    <div class="logobox">
                        <legend>@lang('auth.candidateLogin')</legend>
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

                </div>
                <form class="login100-form validate-form" method="POST" action="{{ route('candidate.auth.loginCandidate') }}" autocomplete="off">
                    {{ csrf_field() }}
                    <input type="hidden" name="timezone" id="timezone">
                    <div class="wrap-input100 validate-input m-b-26">
                        <span class="label-input100"><i class="glyphicon glyphicon-envelope"></i> @lang('auth.E-mail')</span>
                        <input class="input100" type="text" name="email" value="{{ Request::has('email')? request('email') : old('email')  }}" placeholder="Enter e-mail address">
                        <span class="focus-input100"></span>
                    </div>

                    <div class="wrap-input100 validate-input m-b-18">
                        <span class="label-input100"><i class="glyphicon glyphicon-lock"></i> @lang('auth.Password')</span>
                        <input class="input100" type="password" name="pass" value="{{ Request::has('password')? request('password') : old('password') }} placeholder="Enter password">
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
                            <a href="#" class="txt1">
                                Forgot Password?
                            </a>
                        </div>
                    </div>

                    <div class="container-login100-form-btn">
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
@endsection

@section('post-body')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.13/moment-timezone-with-data.js"></script>
    <script>
        var timezone = moment.tz.guess();
        $('#timezone').val(timezone);
    </script>
@endsection