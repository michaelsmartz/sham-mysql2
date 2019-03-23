<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Smartz Human Asset Management software (c) Kalija Global">
        <meta name="author" content="Kalija Global">
        <meta name="csrf-token" content="{{ csrf_token() }}">
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
                        <a class="logotopleft" href="{{URL::to('/')}}"></a>
                    </div>
                    <div class="navbar-collapse collapse" id="top-right-menu">
                        <ul class="nav navbar-nav navbar-right list-group" style="margin-bottom:0;margin-top:3px;cursor:pointer;">
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" title="User profile & logout">
                                    <i class="fa fa-user fa-fw"></i><i class="fa fa-caret-down"></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="#light-modal" class="user-profile item-edit" onclick="editForm('2', event, 'users')">
                                            <i class="fa fa-user fa-fw"></i> User Profile
                                        </a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a href="{{URL::to('/')}}/auth/logout"><i class="fa fa-sign-out fa-fw" style="width:20px !important"></i>Logout</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div id="progress-container" style="height:15px;margin:5px 0 0 70px;padding:0;z-index:1000000"></div>
            <div id="sidebar" class="sidebar">
                <div data-scrollbar="true" data-height="100%">
                    <ul class="nav" id="sidebar-menu">
                        @include('portal-menu')
                    </ul>
                </div>
            </div>
            <div class="sidebar-bg"></div>
            <div id="content" class="content">
                <div class="row title-row">
                    <div class="col-lg-12 col-md-12 col-xs-12">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <h2 class="page-header">@yield('title')</h2>
                            <small>@yield('subtitle')</small>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="pull-right">
                                @yield('right-title')
                            </div>
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
                Copyright &copy; {{ date('Y') }} Smartz Solutions - Smartz Human Asset Management. All rights reserved. Release {{env('VERSION')}} {{env('PLATFORM', '(VVM Version)')}}
                @yield('footer')
            </div>
        </div>

        <script src="{{asset('js/alt-app.js')}}"></script>

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

            var handleDynamicMenu = function() {
                var url = window.location;

                // to get base url without get parameters
                var url2 = window.location.origin + window.location.pathname;

                var innerMenuLis = $('#sidebar-menu li a[data-menu-href]');

                // for tab urls inside a main menu page or for root link without url path
                $('#sidebar-menu li.active').parentsUntil('#sidebar-menu','li').addClass('active');

                // Will only work if string in href matches with location
                $('#sidebar-menu li a[href="' + url2 + '"]').parentsUntil('#sidebar-menu','li').addClass('active');

                // Will also work for relative and absolute hrefs
                $('#sidebar-menu li a').filter(function() {
                    return this.href == url2;
                }).parent().parent().parent().addClass('active');
            };

            var handleSidebarMenu = function() {
                "use strict";
                $('.sidebar .nav > .has-sub > a').click(function() {
                    var target = $(this).next('.sub-menu');
                    var otherMenu = '.sidebar .nav > li.has-sub > .sub-menu';

                    if ($('.page-sidebar-minified').length === 0) {
                        $(otherMenu).not(target).slideUp(250, function() {
                            $(this).closest('li').removeClass('expand');
                        });
                        $(target).slideToggle(250, function() {
                            var targetLi = $(this).closest('li');
                            if ($(targetLi).hasClass('expand')) {
                                $(targetLi).removeClass('expand');
                            } else {
                                $(targetLi).addClass('expand');
                            }
                        });
                    }
                });
                $('.sidebar .nav > .has-sub .sub-menu li.has-sub > a').click(function() {
                    if ($('.page-sidebar-minified').length === 0) {
                        var target = $(this).next('.sub-menu');
                        $(target).slideToggle(250);
                    }
                });
            };

            var handleSidebarMinify = function() {
                $('[data-click=sidebar-minify]').click(function(e) {
                    e.preventDefault();
                    var sidebarClass = 'page-sidebar-minified';
                    var targetContainer = '#page-container';
                    $('#sidebar [data-scrollbar="true"]').css('margin-top','0');
                    $('#sidebar [data-scrollbar=true]').stop();
                    if ($(targetContainer).hasClass(sidebarClass)) {
                        $(targetContainer).removeClass(sidebarClass);
                        if ($(targetContainer).hasClass('page-sidebar-fixed')) {
                            /*if ($('#sidebar .slimScrollDiv').length !== 0) {
                                $('#sidebar [data-scrollbar="true"]').slimScroll({destroy: true});
                                $('#sidebar [data-scrollbar="true"]').removeAttr('style');
                            }
                            generateSlimScroll($('#sidebar [data-scrollbar="true"]'));
                            
                            $('#sidebar [data-scrollbar=true]').trigger('mouseover');*/
                        } else if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
                            /*if ($('#sidebar .slimScrollDiv').length !== 0) {
                                $('#sidebar [data-scrollbar="true"]').slimScroll({destroy: true});
                                $('#sidebar [data-scrollbar="true"]').removeAttr('style');
                            }
                            generateSlimScroll($('#sidebar [data-scrollbar="true"]'));*/
                        }
                    } else {
                        $(targetContainer).addClass(sidebarClass);

                        if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
                            /*if ($(targetContainer).hasClass('page-sidebar-fixed')) {
                                $('#sidebar [data-scrollbar="true"]').slimScroll({destroy: true});
                                $('#sidebar [data-scrollbar="true"]').removeAttr('style');
                            }
                            $('#sidebar [data-scrollbar=true]').trigger('mouseover');*/
                        } else {
                            //$('#sidebar [data-scrollbar="true"]').css('margin-top','0');
                            //$('#sidebar [data-scrollbar="true"]').css('overflow', 'visible');
                        }
                    }
                    $(window).trigger('resize');
                });
            };

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

            $(document).ready(function() {
                //setInterval(keepTokenAlive, 1000 * 60 * 15); // every 15 mins
                handleSidebarMenu();
                handleDynamicMenu();
                handleSidebarMinify();

                $('.user-profile').click(function() {
                    $('#md-content').empty();
                    $('#md-content').load('{{URL::to("shamusers")}}/{{ (Auth::user()!=null)?Auth::user()->Id:0}}/edit',function(response, status){
                        if (status == "success"){
                            $('#md').modal('toggle');
                        } else {
                            $('#mde').modal('toggle');
                        }
                    });
                });

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