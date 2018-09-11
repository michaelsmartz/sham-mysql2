<?php

    $msg = '';
    $msgAlertClass = '';
    if ( Session::has('success_msg') ) {
        $msg = Session::get('success_msg');
        $msgAlertClass = 'success';
    } elseif (Session::has('fail_msg') ) {
        $msg = Session::get('fail_msg');
        $msgAlertClass = 'danger';
    }

?>
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
                        <ul class="nav navbar-nav navbar-right list-group" style="margin-bottom:0;margin-top:0;overflow:hidden;cursor:pointer;">
                            <li class="dropdown" id="user-dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" title="User profile & logout">
                                    <i class="fa fa-user fa-fw"></i><i class="fa fa-caret-down"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-user" data-max-width="400px" style="top:auto;right:0;position:fixed;transition:all 0.3s;z-index:999999999">
                                    <li><a href="javascript: void 0;" class="user-profile" ><i class="fa fa-user fa-fw"></i> User Profile</a>
                                    </li>

                                    @if( (env('CLOCK_IN',0) == 1 && ($user!= null && !empty($user->EmployeeId))) )
                                        <li id="clockInMenuLi" class="hide">
                                            <a id="clockinTrigger" title="Click to show or hide clock in/out buttons">
                                                <i class="fa fa-clock-o fa-fw"></i> Clock in/out</a>
                                        </li>
                                        <div id="popover-content" class="hide">
                                            <div class="clockinout">
                                                <div id="main-clockin-container" style="width: 100%;">
                                                    <a class="btn md-skip btn-success btn-lg" id="clockinBtn" title="click to clock in">
                                                        <i class="fa fa-sign-in pull-left"></i>
                                            <span>Clock in<br>
                                            <small title="last clock-in time"><i>... </i><b id="clockinBtnTime"></b></small>
                                        </span>
                                                    </a>
                                                    <a class="btn md-skip btn-danger btn-lg" id="clockoutBtn" title="click to clock out">
                                                        <i class="fa fa-sign-out pull-left"></i>
                                            <span>Clock out<br>
                                            <small title="last clock-out time"><i>... </i><b id="clockoutBtnTime"></b></small>
                                        </span>
                                                    </a>
                                                </div>
                                                <div class="clock-in-message" style="text-align:right; position:absolute; bottom:5px; right:15px; font-weight:bold;"></div>
                                            </div>
                                        </div>
                                    @endif

                                    @if( ($user!= null && !empty($user->EmployeeId)) )
                                        <li class="hide"><a href="{{URL::to('/')}}/my-leaves"><i class="fa fa-suitcase" style="width:18px !important"></i> Apply for leave</a>
                                    @endif

                                    <li class="divider"></li>
                                    <li><a href="{{URL::to('/')}}/auth/logout"><i class="fa fa-sign-out fa-fw" style="width:20px !important"></i>Logout</a>
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
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-xs-12">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <h2 class="page-header">@yield('title')</h2>
                            <small>@yield('subtitle')</small>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="pull-right" style="/*position:relative;*/">
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

            {{-- 
            <div id="md" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="true" >
                <div class="modal-dialog modal-lg">
                    <div id="md-content" class="modal-content"></div>
                </div>
            </div>
            <div id="mdd" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false" >
                <div class="modal-dialog modal-md">
                    <div id="md-content" class="modal-content"></div>
                </div>
            </div>
            <div id="mde" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="true" >
                <div class="modal-dialog modal-lg">
                    <div id="md-content" class="modal-content">
                        <div class="modal-header  b-n">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Attention!</h4>
                        </div>
                        <div class="modal-body p-t0 p-r5">
                            <div class="scrolled-content-wrapper">
                                Could not complete this operation. Please make sure you are connected and that your session has not expired then try again!
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn bg-gold b-r4 text-white has-spinner" data-dismiss="modal">OK</button>
                        </div>
                    </div>
                </div>
            </div>
            --}}

            @if(Session::has('success') || Session::has('error'))
                @include('alert')
            @endif

            <div class="footer">
                Copyright &copy; {{ date('Y') }} Kalija Global - Smartz Human Asset Management. All rights reserved. Release {{env('VERSION', '1.2')}} {{env('PLATFORM', '(VVM Version)')}}
                @yield('footer')
            </div>
        </div>

        <script src="{{asset('js/app.js')}}"></script>

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
        </script>

        <script>

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
            /*
            function loaded(selector, callback){
                //trigger after page load.

                $(function () {
                    callback($(selector));
                });

                //trigger after page update eg ajax event or jquery insert.
                $('.modal-content').on('load', selector, function () {
                    callback($(this));
                });

                $(window).on("load", selector, function() {
                    callback($(this));
                });

            }

            var makeFieldsRequired = function(container) {
                var requiredInputs = $(container).find(':input.field-required,:input.required');
                if (requiredInputs.length > 0) {
                    // add required marker on each label
                    requiredInputs.each(function(){
                        $(this).prev('label:not(.required)').addClass('required');
                    });
                }
            };
            
            var markRequiredFields = function() {

                // for any new fields when a modal dialog is shown
                $('body').on('shown.bs.modal', function(e) {
                    var element = e.target;

                    var $form = $(element).find('form')[0];
                    makeFieldsRequired($form);

                    if( $($form).is('[data-jquery-validate=true]')) {
                        $($form).validate();
                    }

                    if(typeof $.fn.charcounter !== 'undefined') {
                        $($form).find(':input[maxlength],:input[warnlength]').each(function(){
                            $(this).charcounter({
                                ccDebug: false,
                                placement: 'bottom-right'
                            });
                        });
                    }
                });

            };
            */
            var handleDynamicMenu = function() {
                var url = window.location;

                // to get base url without get parameters
                if (!window.location.origin){
                    // For IE
                    window.location.origin = window.location.protocol + "//" + (window.location.port ? ':' + window.location.port : '');
                }
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

            var generateSlimScroll = function(element) {
                var elem = $(element),
                        dataScrollBarColor = elem.attr('data-scrollbar-color'),
                        dataHeight = $(element).attr('data-height'),
                        dataMaxHeight = $(element).attr('data-max-height');

                dataHeight = (!dataHeight) ? '' : dataHeight;
                dataScrollBarColor = (!dataScrollBarColor) ? '' : dataScrollBarColor;

                if(dataMaxHeight) {
                    $(element).css('max-height',dataMaxHeight);
                }

                var scrollBarOption = {
                    color: dataScrollBarColor,
                    height: dataHeight,
                    alwaysVisible: true,
                    size: '4px',
                    distance: '0px',
                    position: 'left'
                };

                if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
                    $(element).css('height', dataHeight);
                    $(element).css('overflow-x','scroll');
                } else {
                    $(element).slimScroll(scrollBarOption);
                }
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

            var detectFormChanges = function() {
                var $form = $(' #md > #md-content > form'),
                    origForm = $form.serialize();

                $('form :input').on('change input', function() {
                    $('.change-message').toggle($form.serialize() !== origForm);
                });
            };

            $(document).ready(function() {
                /*
                setInterval(keepTokenAlive, 1000 * 60 * 15); // every 15 mins
                $(document).on('mouseenter','.tooltips', function (event) {
                    $(this).qtip({
                        overwrite: false, show: { ready: true },
                        position: { at: 'top center', my: 'bottom center' },
                        style: { classes: 'qtip-tipsy' }
                    });
                });
                */
                handleSidebarMenu();
                handleDynamicMenu();
                handleSidebarMinify();
                //markRequiredFields();

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
        <script>
            //var q = window.asyncJS();
            /*
            q.add("{{URL::to('/')}}/js/index-pack2.js");
            q.whenDone(function(){
                q.then("{{URL::to('/')}}/js/sham.js");
                q.whenDone(function() {
                    // sham.js is ready
                    setAutoTooltips();
                    @if($msg!='')
                    $('.top-right').notify({
                        message: { text: '{{$msg}}' }, type:'{{$msgAlertClass}}', transition: 'fade', fadeOut: { enabled: true, delay: 8000 }
                    }).show();
                    @endif
                });
            });
            */
        </script>

        @yield('scripts')
        @yield('post-body')
    </body>
</html>