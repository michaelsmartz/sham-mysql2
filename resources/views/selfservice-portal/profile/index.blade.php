@extends('portal-index')

@section('post-body')
    <link href="{{URL::to('/')}}/plugins/ladda-bootstrap/ladda-themeless.min.css" rel="stylesheet">
    <link href="{{URL::to('/')}}/css/Amaran/amaran.min.css" rel="stylesheet">
    <link href="{{URL::to('/')}}/plugins/fancybox/jquery.fancybox.min.css" rel="stylesheet">
    <link href="{{URL::to('/')}}/css/bootstrap-reset.css" rel="stylesheet">

    <script type="text/javascript" src="{{URL::to('/')}}/js/knockout-min.js"></script>
    <script type="text/javascript" src="{{URL::to('/')}}/js/knockout.mapping-2.4.1.min.js"></script>
    <script type="text/javascript" src="{{URL::to('/')}}/js/jquery.serializejson.min.js"></script>
    <script type="text/javascript" src="{{URL::to('/')}}/js/portal-profile.js"></script>
    <script async type="text/javascript" src="{{URL::to('/')}}/plugins/fancybox/jquery.fancybox.min.js"></script>
    <script async type="text/javascript" src="{{URL::to('/')}}/js/Amaran/jquery.amaran.min.js"></script>
    <script async type="text/javascript" src="{{URL::to('/')}}/plugins/ladda-bootstrap/spin.min.js"></script>
    <script async type="text/javascript" src="{{URL::to('/')}}/plugins/ladda-bootstrap/ladda.min.js"></script>

    <script>
        var q = asyncJS();
        q.add(["{{URL::to('/')}}/js/jquery.alphanum.js"]);
        q.then("{{URL::to('/')}}/js/sham.js");
        q.whenDone(function(){
            $.fn.mirror = function (selector) {
                return this.each(function () {
                    var $this = $(this);
                    var $selector = $(selector);
                    $this.bind('keyup', function () {
                        $selector.val($this.val());
                    });
                });
            };

            $(':input[data-mirror]').each(function(){
                $(this).mirror($(this).data('mirror'));
            });

            $("#SpouseFullName").alphanum({
                allowSpace: true,allowNumeric: false
            }).bind("change keyup input", titleCaseFormat);
            $("#homecomplex,#homeaddr1,#homeaddr2,#homeaddr3,#homeaddr4,#homecity").bind("change keyup input", titleCaseFormat);
            $("#postalcomplex,#postaladdr1,#postaladdr2,#postaladdr3,#postaladdr4,#postalcity").bind("change keyup input", titleCaseFormat);
            // restrict input in telephone and mobile fields to numbers only
            $('#phone,#cell,#emergency').numeric('positiveInteger');
        });

    </script>

    <style>

        #employeedir * {
            color: #7c7f83;
            padding: 0 40px 0 40px;
            font-family: 'Open Sans',sans-serif;
            font-size: 13px;
        }

        .avatar-container {
            position: relative;
            display: inline-block;
            border-radius: 50%;
            overflow: hidden;
            height: 250px;
            width: 250px;
            padding: 0;
            margin: 0 1rem;
            border: none;
            background: #efefef;
        }
        .avatar-container .avatar {
            display: block;
            margin: 15px;
            border-radius: 50%;
            width: 220px;
            height: 220px;
            overflow: hidden;
            z-index: 100;
        }
        .avatar-container .avatar img {
            width: 100%;
            height: auto;
        }

        #employeedir h1 {
            font-family: Stolzl, Helvetica, Arial, sans-serif;
            font-size: 28px;
            color: #303030;
        }

        #employeedir b, #employeedir .b {
            font-size: 14px;
            font-weight: 400;
            color: #6a6a6a;
        }

        .section {
            position: relative;
            overflow: hidden;
        }

        .section--profile {
            margin: 0;
            padding-bottom: 25px;
        }

        .section--profile:not(:last-of-type) {
            border-bottom: 1px solid rgba(0, 0, 0, .08);
        }

        .section__header {
            display: -webkit-flex;
            display: flex;
            -webkit-align-items: center;
            align-items: center;
            margin: 0 0 15px;
        }

        .section__title {
            margin-bottom: 0;
            font-weight: 300;
            color: #303030;
            font-size: 20px;
            line-height: 1.2;
        }

        .badge-large {
            padding: 20px 75px;
            font-size: 20px;
            letter-spacing: 2px;
            border-radius: 4px;
        }

        .info-label {
            font-weight: 300;
            font-size: 14px;
            color: #999;
            line-height: 19px;
        }

        .info-value {
            padding-top: 10px;
            font-weight: 400;
            font-size: 16px;
            color: #666;
            position: relative;
        }

        .info-value .tooltips {
            color: #348fe2;
        }

        .edit {
            /*position: absolute;
            top: -0.5em;
            left: 0;*/
            padding-left: 10px;
            display: none;
            font-size: 70%;
        }

        .info-value:hover .edit {
            display: inline-block;
        }

        .editable-inline:hover > * .edit {
            display: none;
        }

        .editable-click, a.editable-click {
            text-decoration: none;
            border-bottom: none;
            color: #348fe2;
        }

        a.editable-click:hover {
            border-bottom: none;
            color: #2a72b5;
        }

        .editable-input > .form-control {
            background: whitesmoke;
        }

        .amaran.default {
            top: 60px;
        }

        ::selection {
            background:#1FB5AD;
            color:#fff;
        }
        ::-moz-selection {
            background:#1FB5AD;
            color:#fff;
        }

        .position-center {
            width: 62%;
            margin: 0 auto;
        }

        /*profile*/
        .profile-information {
            font-family: 'Open Sans',sans-serif;
        }
        .profile-information .profile-pic img {
            width:160px;
            height:160px;
            border-radius:50%;
            -webkit-border-radius:50%;
            border:10px solid #f1f2f7;
            margin-top:0;
        }

        .profile-information .profile-pic img[src] {
            opacity: 1 !important;
        }

        .profile-information .profile-pic img:empty {
            display: inline-block;
            background-color: #a1a1a1;
            opacity: 0.25;
        }

        .profile-information .profile-desk {
            border-right: 1px solid #ddd;
            padding-right: 30px;
        }
        .profile-information .profile-desk h1 {
            color: #1fb5ad;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 0;
            transition: opacity 1s ease-in-out;
        }

        .profile-information .profile-desk h1:empty {
            background-color: #1FB5AD;
            height: 26px;
            width: 100%;
            opacity: 0.25;
        }

        .profile-information .profile-desk span,.profile-information .profile-desk p {
            padding-bottom: 25px;
            display: inline-block;
            transition: opacity 1s ease-in-out;
        }

        .profile-information .profile-desk span:empty {
            margin-top: 5px;
            width: 100%;
            height: 20px;
            background-color: #a1a1a1;
            display: inline-block;
            opacity: 0.25;
        }

        .profile-information .profile-statistics h1 {
            color: #757575;
            font-size: 22px;
            font-weight: 400;
            margin-bottom: 5px;
        }
        .profile-information .profile-statistics p {
            margin-bottom: 15px;
            display: inline-block;
        }

        .profile-information .profile-statistics p:last-of-type {
            margin-bottom: 0;
        }
        .profile-information .profile-statistics ul {
            margin-top:10px;
        }
        .profile-information .profile-statistics ul li {
            float:left;
            margin-right:10px;
            list-style: none;
        }
        .profile-information .profile-statistics ul li a {
            background:#f6f6f6;
            text-align:center;
            border-radius:50%;
            -webkit-border-radius:50%;
            width:30px;
            height:30px;
            line-height:30px;
            float:left;
        }
        .profile-information .profile-statistics ul li a:hover {
            color: #1fb5ad;
        }
        /*-----*/
        .profile-nav .user-heading {
            color:#fff;
            border-radius:4px 4px 0 0;
            -webkit-border-radius:4px 4px 0 0;
            padding:30px;
            text-align:center;
        }
        .profile-nav .user-heading.round a {
            border-radius:50%;
            -webkit-border-radius:50%;
            border:10px solid rgba(256,256,256,0.3);
            display:inline-block;
        }
        .profile-nav .user-heading a img {
            width:112px;
            height:112px;
            border-radius:50%;
            -webkit-border-radius:50%;
        }
        .profile-nav .user-heading h1 {
            font-size:20px;
            font-weight:300;
            margin-bottom:5px;
        }
        .profile-nav .user-heading p {
            font-size:16px;
            color:#8b8b8b;
            line-height:25px;
        }
        .profile-nav ul {
            margin-top:1px;
        }
        .profile-nav ul>li {
            border-bottom:1px solid #ebeae6;
            margin-top:0;
            line-height:30px;
        }
        .profile-nav ul>li:last-child {
            border-bottom:none;
        }
        .profile-nav ul>li>a {
            border-radius:0;
            -webkit-border-radius:0;
            color:#89817f;
        }
        .profile-nav ul>li>a:hover,.profile-nav ul>li>a:focus,.profile-nav ul li.active a {
            background:#f8f7f5 !important;
            color:#89817f !important;
        }
        .profile-nav ul>li:last-child>a:last-child {
            border-radius:0 0 4px 4px;
            -webkit-border-radius:0 0 4px 4px;
        }
        .profile-nav ul>li>a>i {
            font-size:16px;
            padding-right:10px;
            color:#bcb3aa;
        }

        .tab-bg-dark-navy-blue {
            background:#e0e1e7;
            border-radius:5px 5px 0 0;
            -webkit-border-radius:5px 5px 0 0;
            border-bottom:none;
        }

        /*-----*/
        .recent-act {
            border-collapse:collapse;
            border-spacing:0;
            display:table;
            position:relative;
            table-layout:fixed;
            width:100%;
        }
        .recent-act:before {
            background-color:#eeeeee;
            bottom:0;
            content:"";
            left:50%;
            position:absolute;
            top:50px;
            width:2px;
            z-index:0;
        }
        .recent-act h1 {
            text-align:center;
            color:#1fb5ad;
            font-size:16px;
            font-weight:bold;
            text-transform:uppercase;
        }
        .activity-icon.terques {
            background:#8fd6d6;
        }
        .activity-icon.red {
            background:#EF6F66;
        }
        .activity-icon.purple {
            background:#bda4ec;
        }
        .activity-icon.green {
            background:#aec785;
        }
        .activity-icon.yellow {
            background:#fed65a;
        }
        .activity-icon {
            border-radius:50%;
            -webkit-border-radius:50%;
            color:#FFFFFF;
            height:30px;
            line-height:30px;
            text-align:center;
            width:30px;
            margin:20px auto 20px;
            position:relative;
        }
        .activity-icon {
            background:#C7CBD6;
        }
        .activity-desk {
            padding:15px 30px;
            background:#f2f2f2;
            border-radius:5px;
            -webkit-border-radius:5px;
            position:relative;
            text-align:center;
        }
        .activity-desk h2 {
            color:#1fb5ad;
            font-size:14px;
            font-weight:bold;
            margin:0 0 10px 0;
            text-transform:uppercase;
        }
        .activity-desk .terques {
            color:#1fb5ad;
        }
        .activity-desk .red {
            color:#EF6F66;
        }
        .activity-desk .purple {
            color:#bda4ec;
        }
        .activity-desk .green {
            color:#aec785;
        }
        .activity-desk .yellow {
            color:#fed65a;
        }
        .activity-desk .blue {
            color:#20aaf1;
        }
        .photo-gl {
            margin-top:10px;
            display:inline-block;
        }
        .photo-gl a {
            margin:0 10px;
        }
        .photo-gl a img {
            border:1px solid #c8c8c8;
            width:150px;
            height:120px;
        }
        .prf-box {
            display:inline-block;
            width:100%;
            margin-bottom:30px;
        }
        .prf-border-head {
            color:#1fb5ad;
            border-bottom:1px solid #f1f2f7;
            font-size:16px;
            font-weight:bold;
            padding-bottom:10px;
            margin-bottom:20px;
            text-transform:uppercase;
        }
        .wk-progress {
            border-bottom:1px solid #f1f2f7;
            margin-bottom:20px;
            width:100%;
            display:inline-block;
        }
        .pf-status {
            padding-bottom:25px;
        }
        .tm-avatar img {
            width:50px;
            height:50px;
            border-radius:50%;
            -webkit-border-radius:50%;
        }
        .tm-membr {
            padding-bottom:12px;
            margin-bottom:10px;
        }
        .tm-membr .tm {
            padding-top:10px;
            display:inline-block;
            padding-left: 10px;
        }

        /*profile contact*/
        .prf-contacts h2 {
            color:#1fb5ad;
            font-size:16px;
            margin-top:0;
            text-transform:uppercase;
        }
        .prf-contacts h2 span {
            width:40px;
            height:40px;
            line-height:42px;
            background:#1fb5ad;
            color:#fff;
            border-radius:50%;
            -webkit-border-radius:50%;
            display:inline-block;
            text-align:center;
            margin-right:15px;
        }
        .prf-contacts h2 span i {
            font-size:16px;
        }
        .prf-contacts .location-info {
            margin-left:60px;
        }
        .prf-contacts .location-info p {
            padding-bottom:15px;
        }
        .prf-map {
            width:430px;
            height:430px;
            border-radius:50%;
            -webkit-border-radius:50%;
            border:10px solid #e6e6e6;
            margin-top:50px;
        }
        .sttng h2 {
            margin: 20px 0;
        }

        .panel-heading .nav {
            border:medium none;
            font-size:13px;
            margin:-15px -15px -15px;
        }

        .panel-heading .nav>li>a,.panel-heading .nav>li.active>a,.panel-heading .nav>li.active>a:hover,.panel-heading .nav>li.active>a:focus {
            border-width:0;
            border-radius:0;
        }
        .panel-heading .nav>li>a {
            color:#898989;
        }
        .panel-heading .nav>li.active>a,.panel-heading .nav>li>a:hover {
            color:#1fb5ad;
            background:#fff;
        }
        .panel-heading .nav>li:first-child.active>a,.panel-heading .nav>li:first-child>a:hover {
            border-radius:4px 0 0 0;
            -webkit-border-radius:4px 0 0 0;
        }
        .tab-right {
            height:58px;
        }
        .panel-heading.tab-right .nav>li:first-child.active>a,.tab-right.panel-heading .nav>li:first-child>a:hover {
            border-radius:0;
            -webkit-border-radius:0;
        }
        .panel-heading.tab-right .nav>li:last-child.active>a,.tab-right.panel-heading .nav>li:last-child>a:hover {
            border-radius:0 4px 0 0;
            -webkit-border-radius:0 4px 0 0;
        }
        .panel-heading.tab-right .nav-tabs>li>a {
            margin-left:1px;
            margin-right:0px;
        }

        /* Timeline */
        .timeline-messages h3 {
            margin-bottom:30px;
            color:#1fb5ad;
            font-size:16px;
            text-transform:uppercase;
            background:#fff;
            padding:20px;
            margin-top:-3px;
            position:relative;
        }
        .timeline-messages:before {
            background:rgba(0,0,0,0.05);
            bottom:0;
            top:0;
            width:2px;
        }
        .timeline-messages:before,.msg-time-chat:before,.msg-time-chat .text:before {
            content:"";
            left:20px;
            position:absolute;
            top:-2px;
        }
        .timeline-messages,.msg-time-chat,.timeline-messages .msg-in,.timeline-messages .msg-out {
            position:relative;
        }
        .timeline-messages .msg-in .arrow {
            border-right:8px solid #949496 !important;
        }
        .timeline-messages .msg-in .arrow {
            border-bottom:8px solid transparent;
            border-top:8px solid transparent;
            display:block;
            height:0;
            left:-8px;
            position:absolute;
            top:25px;
            width:0;
        }
        .timeline-messages .msg-out .arrow {
            border-right:8px solid #41cac0 !important;
        }
        .timeline-messages .msg-out .arrow {
            border-bottom:8px solid transparent;
            border-top:8px solid transparent;
            display:block;
            height:0;
            left:-8px;
            position:absolute;
            top:25px;
            width:0;
        }

        .msg-time-chat:first-child:before {
            margin-top:27px;
        }
        .msg-time-chat:before {
            background:#CCCCCC;
            border:2px solid #FAFAFA;
            border-radius:100px;
            -moz-border-radius:100px;
            -webkit-border-radius:100px;
            height:16px;
            margin:35px 0 0 -7px;
            width:16px;
        }
        .msg-time-chat:hover:before {
            background:#41cac0;
        }
        .msg-time-chat:first-child {
            padding-top:0;
        }
        .message-img {
            float:left;
            margin-right:30px;
            overflow:hidden;
        }
        .message-img img {
            display:block;
            height:44px;
            width:44px;
        }
        .message-body {
            margin-left:50px;
            display: inline-block;
        }
        .msg-time-chat .msg-in .text {
            /*border:1px solid #e3e6ed;*/
            /*padding:10px;*/
            border-radius:4px;
            -webkit-border-radius:4px;
            margin-top:14px;
        }
        .msg-time-chat .msg-in .text .first {
            background:#949496;
            padding:10px;
            color:#fff;
            float:left;
            border-radius:4px;
            -webkit-border-radius:4px;
            margin-right:5px;
            width:130px;
            text-align:right;
        }

        .msg-time-chat .msg-in .text .first:empty {
            content: '&nbsp;';
            height: 40px;
            opacity: 0.25;
        }

        .msg-time-chat .msg-in .text .second {
            background: #348fe2 /*#8fd6d6*/;
            padding:10px;
            color:#fff;
            float:left;
            border-radius:4px;
            -webkit-border-radius:4px;
        }

        .msg-time-chat .msg-in .text .second:empty {
            content: '&nbsp;';
            height: 40px;
            opacity: 0.25;
            width: 150px;
            background-color: #a1a1a1;
        }

        .msg-time-chat .msg-out .text {
            border:1px solid #e3e6ed;
            padding:10px;
            border-radius:4px;
            -webkit-border-radius:4px;
        }
        .msg-time-chat p {
            margin:0;
        }
        .msg-time-chat .attribution {
            font-size:11px;
            margin:0px 0 5px;
        }
        .msg-time-chat {
            overflow:hidden;
            padding:8px 0;
        }
        .msg-in a,.msg-in a:hover {
            color:#b64c4c;
            text-decoration:none;
            border-radius:4px;
            -webkit-border-radius:4px;
            margin-right:10px;
            font-weight:400;
            font-size:13px;
        }
        .msg-out a,.msg-out a:hover {
            color:#288f98;
            text-decoration:none;
            border-radius:4px;
            -webkit-border-radius:4px;
            margin-right:10px;
            font-weight:400;
            font-size:13px;
        }

        input[aria-invalid=true] {
            border-radius: 4px 4px 0 0;
        }
        input[aria-invalid=true] + strong.help-block {
            font-size: 11px !important;
            font-weight: 500 !important;
            border-radius: 0 0 5px 5px;
            background-color: #a94442;
            margin-top:0;
            color: white !important;
            padding: 0 5px 5px 10px;
            vertical-align: middle;
            transition: all 0.3s ease-in;
            line-height: 2em;
        }

        .ph-lg {
            padding-left: 15px !important;
            padding-right: 15px !important;
        }

        .discoverer .file-icon em:empty {
            height: 70px;
            background-color:rgba(255,255,255, 0.15);
            display: inline-block;
        }

        .discoverer p small {
            font-size: 80%;
        }

        .discoverer p small:empty, .discoverer .text-muted small:empty {
            height: 16px;
            background-color:rgba(255,255,255, 0.15);
            display: inline-block;
        }

    </style>
@stop

@php
    $_mode='view';
@endphp

@section('title','Profile')
@section('subtitle','')

@section('content')

<section id="sec-userProfile">
    <br>
    <div class="row">
        <div class="col-md-12">
            <section class="panel" style="margin-bottom:15px">
                <div class="panel-body profile-information">
                    <div class="col-md-3">
                        <div class="profile-pic text-center">
                            <img data-bind="attr:{src: Pic}" alt="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="profile-desk">
                            <h1 data-bind="text: fullName"></h1>
                            <span data-bind="text: Job" class="text-muted"></span>
                            <p style="display: block;line-height: 2.3">&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="profile-statistics">
                            <h1 data-bind="text: Team"></h1>
                            <p data-bind="text: Department"></p>
                            <h1 data-bind="text: Branch"></h1>
                            <p data-bind="text: Division"></p>
                        </div>
                    </div>

                </div>
            </section>
        </div>
        <div class="col-md-12">
            <section class="panel" style="margin-bottom:5px">
                <header class="panel-heading tab-bg-dark-navy-blue">
                    <ul class="nav nav-tabs nav-justified ">
                        <li class="active">
                            <a data-toggle="tab" href="#job-history">
                                Timeline
                            </a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#contacts" class="contact-map">
                                Contacts
                            </a>
                        </li>
                        <!-- ko if: FilesData().length > 0 -->
                        <li class="">
                            <a data-toggle="tab" href="#files">
                                Files
                            </a>
                        </li>
                        <!-- /ko -->
                        <li class="">
                            <a data-toggle="tab" href="#settings">
                                Edit Profile
                            </a>
                        </li>
                    </ul>
                </header>
                <div class="panel-body">
                    <div class="tab-content tasi-tab">
                        <div id="job-history" class="tab-pane active">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="timeline-messages">

                                        <div data-bind="foreach: TimeLineData">
                                            <!-- Comment -->
                                            <div class="msg-time-chat">
                                                <div class="message-body msg-in">
                                                    <span class="arrow"></span>
                                                    <div class="text">
                                                        <div class="first" data-bind="text: Date"></div>
                                                        <div class="second" data-bind="text: Description, css: { [ColorClass]:true, [DynamicClass]:true}"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- /comment -->
                                        </div>

                                        <!-- Comment -->
                                        <div class="msg-time-chat" hidden>
                                            <div class="message-body msg-in">
                                                <span class="arrow"></span>
                                                <div class="text">
                                                    <div class="first">
                                                        3 April 2009
                                                    </div>
                                                    <div class="second" style="background-color: #FA7240;">
                                                        Selected the Best Employee of the Year 2013 and was awarded
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /comment -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="contacts" class="tab-pane">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="prf-contacts">
                                        <h2> <span><i class="fa fa-map-marker"></i></span> location</h2>
                                        <div class="location-info" data-bind="updateOnce: true">
                                            <p><strong>Home Address</strong><br>
                                                <span data-bind="text: staticHomeAddressUnitNo"></span>
                                                <span data-bind="text: staticHomeAddressComplex"></span>
                                                <span data-bind="text: staticHomeAddressLine1"></span> <br>
                                                <span data-bind="text: staticHomeAddressLine2"></span> <br>
                                                <span data-bind="text: staticHomeAddressCity"></span> <span data-bind="text: HomeAddressProvince"></span> <span data-bind="text: staticHomeAddressZipCode"></span></p>
                                            <p><strong>Postal Address</strong><br>
                                                <span data-bind="text: staticPostalAddressUnitNo"></span>
                                                <span data-bind="text: staticPostalAddressComplex"></span>
                                                <span data-bind="text: staticPostalAddressLine1"></span> <br>
                                                <span data-bind="text: staticPostalAddressLine2"></span> <br>
                                                <span data-bind="text: staticPostalAddressCity"></span> <span data-bind="text: staticPostalAddressProvince"></span> {{$employee->PostalAddressProvince or '' }} {{$employee->PostalAddressZipCode or ''}}</p>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="prf-contacts">
                                        <h2> <span><i class="fa fa-phone"></i></span> contacts</h2>
                                        <div class="location-info">
                                            <p>Home Phone	: <span data-bind="text: HomeTel"></span> <br>
                                                Cell		: <span data-bind="text: Mobile"></span> <br>
                                                Email		: <span data-bind="text: HomeEmailAddress"></span> </p>
                                            <p>
                                                <span class="text-danger">Emergency Phone:</span> 	<span data-bind="text: WorkTel"></span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ko if: FilesData().length > 0 -->
                        <div id="files" class="tab-pane">
                            <div class="row">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div data-bind="foreach: FilesData">
                                                <div class="col-md-3 col-sm-5">
                                                    <div data-bind="attr: {'data-filter-group': Filter}" class="panel discoverer">
                                                        <div class="panel-body text-center">
                                                            <div class="clearfix discover">
                                                                <div class="pull-right">
                                                                    <a target="_blank" data-bind="attr: { 'href': DownloadLink}" title="Download" class="text-muted mr-sm tooltips">
                                                                        <em class="fa fa-download fa-fw"></em>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <!-- ko if: canPreview -->
                                                            <a data-fancybox data-type="iframe" data-width="450" data-height="250" href="javascript:;" data-bind="attr: { 'data-src': PreviewLink}" class="file-icon ph-lg" title="Click to preview">
                                                                <em class="" data-bind="css: { [FileClass]:true }"></em>
                                                            </a>
                                                            <!-- /ko -->
                                                            <!-- ko if: !canPreview -->
                                                            <a class="file-icon ph-lg">
                                                                <em class="" data-bind="css: { [FileClass]:true }"></em>
                                                            </a>
                                                            <!-- /ko -->
                                                            <p>
                                                                <small class="text-dark" data-bind="text: FileName"></small>
                                                            </p>
                                                            <div class="clearfix m0 text-muted">
                                                                <small class="pull-right" data-bind="text: FileSize"></small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /ko -->
                        <div id="settings" class="tab-pane">
                            <form role="form" class="form-horizontal" id="frmEditProfile">
                                <div class="position-center">
                                    <div class="prf-contacts sttng">
                                        <h2>  Personal Information</h2>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Marital Status</label>
                                        <div class="col-lg-8">
                                            {!! Form::select('MaritalStatusId', $maritalStatus, null, ['id' =>'MaritalStatusId', 'name'=>'MaritalStatusId', 'data-bind'=>'value: MaritalStatusId', 'class'=>'form-control', 'autocomplete'=>'off', 'placeholder'=>' ']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Next of Kin</label>
                                        <div class="col-lg-8">
                                            <input placeholder=" " id="SpouseFullName" name="SpouseFullName" data-bind="value: SpouseFullName" class="form-control" type="text">
                                        </div>
                                    </div>

                                    <div class="prf-contacts sttng">
                                        <h2>Contact</h2>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Unit No</label>
                                        <div class="col-lg-8">
                                            <div class="input-group">
                                                <input placeholder=" " id="homeunitno" name="HomeAddressUnitNo" data-bind="value: HomeAddressUnitNo" class="form-control" type="text" data-mirror="#postalunitno">
                                                <label for="homeunitno" class="input-group-addon btn-white tooltips" title="Home">
                                                    <i class="fa fa-home"></i>
                                                </label>
                                                <input placeholder=" " id="postalunitno" name="PostalAddressUnitNo" data-bind="value: PostalAddressUnitNo" class="form-control" type="text">
                                                <label for="postalunitno" class="input-group-addon btn-white tooltips" title="Postal">
                                                    <i class="fa fa-paper-plane"></i>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Complex</label>
                                        <div class="col-lg-8">
                                            <div class="input-group">
                                                <input placeholder=" " id="homecomplex" name="HomeAddressComplex" data-bind="value: HomeAddressComplex" class="form-control" type="text" data-mirror="#postalcomplex">
                                                <label for="homecomplex" class="input-group-addon btn-white tooltips" title="Home">
                                                    <i class="fa fa-home"></i>
                                                </label>
                                                <input placeholder=" " id="postalcomplex" name="PostalAddressComplex" data-bind="value: PostalAddressComplex" class="form-control" type="text">
                                                <label for="postalcomplex" class="input-group-addon btn-white tooltips" title="Postal">
                                                    <i class="fa fa-paper-plane"></i>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Address 1</label>
                                        <div class="col-lg-8">
                                            <div class="input-group">
                                                <input placeholder=" " id="homeaddr1" name="HomeAddressLine1" data-bind="value: HomeAddressLine1" class="form-control" type="text" data-mirror="#postaladdr1">
                                                <label for="homeaddr1" class="input-group-addon btn-white tooltips" title="Home">
                                                    <i class="fa fa-home"></i>
                                                </label>
                                                <input placeholder=" " id="postaladdr1" name="PostalAddressLine1" data-bind="value: PostalAddressLine1" class="form-control" type="text">
                                                <label for="postaladdr1" class="input-group-addon btn-white tooltips" title="Postal">
                                                    <i class="fa fa-paper-plane"></i>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Address 2</label>
                                        <div class="col-lg-8">
                                            <div class="input-group">
                                                <input placeholder=" " id="homeaddr2" name="HomeAddressLine2" data-bind="value: HomeAddressLine2" class="form-control" type="text" data-mirror="#postaladdr2">
                                                <label for="homeaddr2" class="input-group-addon btn-white tooltips" title="Home">
                                                    <i class="fa fa-home"></i>
                                                </label>
                                                <input placeholder=" " id="postaladdr2" name="PostalAddressLine2" data-bind="value: PostalAddressLine2" class="form-control" type="text">
                                                <label for="postaladdr2" class="input-group-addon btn-white tooltips" title="Postal">
                                                    <i class="fa fa-paper-plane"></i>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Address 3</label>
                                        <div class="col-lg-8">
                                            <div class="input-group">
                                                <input placeholder=" " id="homeaddr3" name="HomeAddressLine3" data-bind="value: HomeAddressLine3" class="form-control" type="text" data-mirror="#postaladdr3">
                                                <label for="homeaddr3" class="input-group-addon btn-white tooltips" title="Home">
                                                    <i class="fa fa-home"></i>
                                                </label>
                                                <input placeholder=" " id="postaladdr3" name="PostalAddressLine3" data-bind="value: PostalAddressLine3" class="form-control" type="text">
                                                <label for="postaladdr3" class="input-group-addon btn-white tooltips" title="Postal">
                                                    <i class="fa fa-paper-plane"></i>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Address 4</label>
                                        <div class="col-lg-8">
                                            <div class="input-group">
                                                <input placeholder=" " id="homeaddr4" name="HomeAddressLine4"
                                                       data-bind="value: HomeAddressLine4"
                                                       class="form-control" type="text"
                                                       data-mirror="#postaladdr4">
                                                <label for="homeaddr4" class="input-group-addon btn-white tooltips" title="Home">
                                                    <i class="fa fa-home"></i>
                                                </label>
                                                <input placeholder=" " id="postaladdr4" name="PostalAddressLine4" data-bind="value: PostalAddressLine4" class="form-control" type="text">
                                                <label for="postaladdr4" class="input-group-addon btn-white tooltips" title="Postal">
                                                    <i class="fa fa-paper-plane"></i>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">City</label>
                                        <div class="col-lg-8">
                                            <div class="input-group">
                                                <input placeholder=" " id="homecity" name="HomeAddressCity" data-bind="value: HomeAddressCity" class="form-control" type="text" data-mirror="#postalcity">
                                                <label for="homecity" class="input-group-addon btn-white tooltips" title="Home">
                                                    <i class="fa fa-home"></i>
                                                </label>
                                                <input placeholder=" " id="postalcity" name="PostalAddressCity" data-bind="value: PostalAddressCity" class="form-control" type="text">
                                                <label for="postalcity" class="input-group-addon btn-white tooltips" title="Postal">
                                                    <i class="fa fa-paper-plane"></i>
                                                </label>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Province</label>
                                        <div class="col-lg-8">
                                            <div class="input-group">
                                                <input placeholder=" " id="homeprovince" name="HomeAddressProvince" data-bind="value: HomeAddressProvince" class="form-control" type="text" data-mirror="#postalprovince">
                                                <label for="homeprovince" class="input-group-addon btn-white tooltips" title="Home">
                                                    <i class="fa fa-home"></i>
                                                </label>
                                                <input placeholder=" " id="postalprovince" name="PostalAddressProvince" data-bind="value: PostalAddressProvince" class="form-control" type="text">
                                                <label for="postalprovince" class="input-group-addon btn-white tooltips" title="Postal">
                                                    <i class="fa fa-paper-plane"></i>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Zip Code</label>
                                        <div class="col-lg-8">
                                            <div class="input-group">
                                                <input placeholder=" " id="homezipcode" name="HomeAddressZipCode" data-bind="value: HomeAddressZipCode" class="form-control" type="text" data-mirror="#postalzipcode">
                                                <label for="homezipcode" class="input-group-addon btn-white tooltips" title="Home">
                                                    <i class="fa fa-home"></i>
                                                </label>
                                                <input placeholder=" " id="postalzipcode" name="PostalAddressZipCode" data-bind="value: PostalAddressZipCode" class="form-control" type="text">
                                                <label for="postalzipcode" class="input-group-addon btn-white tooltips" title="Postal">
                                                    <i class="fa fa-paper-plane"></i>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Phone</label>
                                        <div class="col-lg-4">
                                            <input placeholder=" " id="phone" name="HomeTel" data-bind="value: HomeTel" class="form-control" type="text">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Cell</label>
                                        <div class="col-lg-4">
                                            <input placeholder=" " id="cell" name="Mobile" data-bind="value: Mobile" class="form-control" type="text">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Emergency</label>
                                        <div class="col-lg-4">
                                            <input placeholder=" " id="emergency" name="WorkTel" data-bind="value: WorkTel" class="form-control" type="text">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Email</label>
                                        <div class="col-lg-4">
                                            <input placeholder=" " id="email" name="HomeEmailAddress" data-bind="value: HomeEmailAddress" class="form-control email" type="email">
                                        </div>
                                    </div>
                                    @if (!empty($employee->id))
                                    <div class="form-group">
                                        <div class="col-lg-offset-2 col-lg-10">
                                            <button id="btnSave" class="btn btn-primary ladda-button" data-size="l" data-style="expand-left" type="submit" onclick="saveHandler(event)">Save</button>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</section>
@stop

