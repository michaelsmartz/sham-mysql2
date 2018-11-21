<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="preload" href="/dist/img/logo-gold-login_dy8gg5_c_scale,w_200.png" as="image">
        <title>Smartz Human Asset Management</title>
        <link rel="prefetch" href="{{asset('css/app.min.css')}}" as="stylesheet">
        <link rel="stylesheet" href="{{asset('css/app.min.css')}}">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Source Sans Pro', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 14px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @if (!empty($user))
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ url('/login') }}">Login</a>
                        <a href="{{ url('/register') }}">Register</a>
                    @endif
                </div>
            @endif

            <div class="">
                <div class="text-center">
                    <a href="{{ url('/home') }}"><picture >
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
                    </picture></a>
                </div>
            </div>
        </div>
    </body>
</html>