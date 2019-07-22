<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Smartz Human Asset Management software (c) Kalija Global">
        <meta name="author" content="Kalija Global">
        <meta name="csrf-token" content="{{csrf_token()}}">
        <link rel="prefetch" href="{{asset('css/app.min.css')}}" as="stylesheet">
        <link rel="stylesheet" href="{{asset('css/app.min.css')}}">
        <title>Smartz Human Asset Management</title>
    </head>

    <body @yield('bodyparam')>
        <div id="page-loader" hidden><span class="spinner"></span><br/><br/></div>
        <div id="page-container" class="page-sidebar-minified page-sidebar-fixed page-header-fixed">
            <div id="header" class="header navbar" style="position:fixed;top:0;left:0;right:0;z-index:1030;background:white">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#top-right-menu">☰</button>
                        <a class="logotopleft" href="{{ route('candidate.vacancies') }}"></a>
                    </div>
                    <div class="navbar-collapse collapse" id="top-right-menu">
                        <ul class="nav navbar-nav navbar-right list-group" style="margin-bottom:0;margin-top:3px;cursor:pointer;">
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" title="Candidate profile & logout">
                                    <i class="fa fa-user fa-fw"></i><i class="fa fa-caret-down"></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="{{ route('candidate.auth.details') }}" class="user-profile item-edit">
                                            <i class="fa fa-user fa-fw"></i> Candidate Profile
                                        </a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a href="{{ route('candidate.auth.logout') }}"><i class="fa fa-sign-out fa-fw" style="width:20px !important"></i>Logout</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div id="progress-container" style="height:15px;margin:5px 0 0 70px;padding:0;z-index:1000000"></div>
            <div id="content" class="container-fluid">
                <div class="row title-row">
                    <div class="col-lg-12 col-md-12 col-xs-12">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <h2 class="page-header">@yield('title')</h2>
                            <small>@yield('subtitle')</small>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="pull-right">@yield('right-title')</div>
                        </div>
                    </div>
                </div>
                <div id="mainContentHolder">
                    @yield('content')
                </div>
            </div>

            @component('partials.light-modal')
            @endcomponent

            @if(Session::has('success') || Session::has('error'))
                @include('alert')
            @endif

            <div class="footer">
                Copyright &copy; 2019 Smartz Solutions - Smartz Human Asset Management. All rights reserved. Release {{env('VERSION')}} {{env('PLATFORM', '(VVM Version)')}}
                @yield('footer')
            </div>
        </div>

        <script src="{{asset('js/app2.js')}}"></script>

        <!-- Custom Theme JavaScript -->
        <noscript id="deferred-styles"></noscript>

        <script>
            
            var loadDeferredStyles = function() {
                var addStylesNode = document.getElementById("deferred-styles");
                var replacement = document.createElement("div");
                replacement.innerHTML = addStylesNode.textContent;
                document.body.appendChild(replacement);
                addStylesNode.parentElement.removeChild(addStylesNode);
            };
            var raf = requestAnimationFrame || mozRequestAnimationFrame ||
                    webkitRequestAnimationFrame || msRequestAnimationFrame;
            if (raf) raf(function() { window.setTimeout(loadDeferredStyles, 0); });
            else window.addEventListener('load', loadDeferredStyles);

            /*! loadCSS. [c]2017 Filament Group, Inc. MIT License */
            !function(a){"use strict";var b=function(b,c,d){function e(a){return h.body?a():void setTimeout(function(){e(a)})}function f(){i.addEventListener&&i.removeEventListener("load",f),i.media=d||"all"}var g,h=a.document,i=h.createElement("link");if(c)g=c;else{var j=(h.body||h.getElementsByTagName("head")[0]).childNodes;g=j[j.length-1]}var k=h.styleSheets;i.rel="stylesheet",i.href=b,i.media="only x",e(function(){g.parentNode.insertBefore(i,c?g:g.nextSibling)});var l=function(a){for(var b=i.href,c=k.length;c--;)if(k[c].href===b)return a();setTimeout(function(){l(a)})};return i.addEventListener&&i.addEventListener("load",f),i.onloadcssdefined=l,l(f),i};"undefined"!=typeof exports?exports.loadCSS=b:a.loadCSS=b}("undefined"!=typeof global?global:this);
            /*! loadCSS rel=preload polyfill. [c]2017 Filament Group, Inc. MIT License */
            !function(a){if(a.loadCSS){var b=loadCSS.relpreload={};if(b.support=function(){try{return a.document.createElement("link").relList.supports("preload")}catch(b){return!1}},b.poly=function(){for(var b=a.document.getElementsByTagName("link"),c=0;c<b.length;c++){var d=b[c];"preload"===d.rel&&"style"===d.getAttribute("as")&&(a.loadCSS(d.href,d,d.getAttribute("media")),d.rel=null)}},!b.support()){b.poly();var c=a.setInterval(b.poly,300);a.addEventListener&&a.addEventListener("load",function(){b.poly(),a.clearInterval(c)}),a.attachEvent&&a.attachEvent("onload",function(){a.clearInterval(c)})}}}(this);

            function keepTokenAlive() {
                $.ajax({
                    url: '{{url("/")}}/refresh-csrf', //https://stackoverflow.com/q/31449434/470749
                    type: 'post',
                    global: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                }).then(function (d) {
                    $('meta[name="csrf-token"]').attr('content', d);
                });
            }

            var handleAfterPageLoadAddClass = function() {
                if ($('[data-pageload-addclass]').length !== 0) {
                    $(window).load(function() {
                        $('[data-pageload-addclass]').each(function() {
                            var targetClass = $(this).attr('data-pageload-addclass');
                            $(this).addClass(targetClass);
                        });
                    });
                }
            };

            window.cleanUrlHash = function(){
                window.history.pushState(null, "", window.location.href.replace("#light-modal", ""));
                //history.replaceState(null, "", window.location.pathname);
                return window.location.hash.replace(/^#/, '');
            };

            window.loadUrl = function(url) {
                var ret = false;
                $(".light-modal-heading").empty().html('');
                $(".light-modal-footer .buttons").empty().html('');
                $(".light-modal-body").empty().html('Loading...please wait...');
                $.get(url).done(function(data) {
                    $(".light-modal-heading").empty().html(data.title);
                    $(".light-modal-body").empty().html(data.content);
                    $(".light-modal-footer .buttons").empty().html(data.footer);
                    $("#modalForm").attr('action',data.url);

                    cleanUrlHash();

                    $('.multipleSelect').each(function(){
                        $(this).multiselect({
                            submitAllLeft:false,
                            sort: false,
                            keepRenderingSort: false,
                            search: {
                                left: '<input type="text" name="q" class="form-control" placeholder="Search..." />',
                                right: '<input type="text" name="q" class="form-control" placeholder="Search..." />',
                            },
                            fireSearch: function(value) {
                                return value.length > 3;
                            }
                        });
                    });

                    ret = true;
                    window.appEe.emit('loadUrl', 'ok');

                }).fail(function() {
                    alerty.alert("An error has occurred. Please try again!",{okLabel:'Ok'});
                });
                return ret;
            };

            window.editForm = function(id, event, baseUrl) {
                var route; 
                if (baseUrl === void 0) {
                    route = '{{url()->current()}}/';
                } else {
                    route = '{{URL::to('/')}}/' + baseUrl + '/';
                }

                if (id) {
                    @if (isset($fullPageEdit) && $fullPageEdit == TRUE)
                        window.location = route + id + '/edit';
                    @else
                        loadUrl(route + id + '/edit');
                    @endif
                }
            };

            $(document).ready(function() {
                //setInterval(keepTokenAlive, 1000 * 60 * 15); // every 15 mins
                handleSidebarMenu();
                handleDynamicMenu();
                handleSidebarMinify();
            });

        </script>

        @routes

        <!-- Customised pickadate picker-->
        <style>
            .picker {
                font-size: 10px;
            }

            .picker__frame {
                max-width: 300px;
            }

            @media (min-height: 40.125em) {
                .picker__frame {
                    margin-bottom: 15%;
                }
            }

            .picker__select--year {
                width: 25.5%;
            }

            .picker__select--month, .picker__select--year {
                font-size: 12px;
                height: 28px;
            }

        </style>

        @yield('scripts')
        @yield('post-body')
        @stack('css-stack')
        @stack('js-stack')

    </body>
</html>