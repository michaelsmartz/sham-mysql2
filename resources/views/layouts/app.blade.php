<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Smartz Human Asset Management</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body id="page-top">
    @yield('content')

    <!-- Scripts -->
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
                } else {
                    $(targetContainer).addClass(sidebarClass);
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
    @yield('post-body')
</body>
</html>