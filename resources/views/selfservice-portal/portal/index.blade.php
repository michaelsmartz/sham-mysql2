@extends('portal-index')

@section('post-body')
    <link href="{{URL::to('/')}}/css/self-service-portal.css" rel="stylesheet">
    <link href="{{URL::to('/')}}/css/ssp-working-hours.css" rel="stylesheet">
    <link href="{{URL::to('/')}}/css/keyframes.css" rel="stylesheet">
    <link href="{{URL::to('/')}}/css/todolist.css" rel="stylesheet">

    <style>
        #page-container #content .row{
            margin-right: 0px;!important;
        }

        #icons-container .icon{
           height: 60px;
           width: 60px;
        }

        #icons-container a {
            vertical-align: text-top;
        }

        svg .icon {
            width: 30px;
        }

        .virtual-help-buttons a {
            width: 75px;
            height: 75px;
            border-radius: 50%;
            text-align: center;
            vertical-align: middle;
            margin: 0 auto;
            padding: 4px;
            position: relative;

        }

        .virtual-help-buttons svg:hover {
            /*box-shadow: 0 3px 3px rgba(0, 0, 0, 0.125) inset;*/
            /*-webkit-animation: bounce 1.1s ease-out 75ms;
            -moz-animation: bounce 1.1s ease-out 75ms;
            animation: bounce 1.1s ease-out 75ms;*/
            position: relative;
            z-index: 20;
        }

        @media (min-width: 768px) {
            .col2 {
                float: right;
            }
        }

        ::-webkit-input-placeholder { color: white; opacity: 1 !important; }
        :-moz-placeholder { color: white; opacity: 1 !important;}
        ::-moz-placeholder {color: white; opacity: 1 !important;}
        :-ms-input-placeholder {color: white;}

        .panel-heading-btn {
            float: right;
        }
        .panel-heading-btn > a {
            margin-left: 8px;
        }

        .btn-icon,
        .btn.btn-icon {
            display: inline-block;
            width: 20px;
            height: 20px;
            padding: 0;
            border: none;
            line-height: 20px;
            text-align: center;
            font-size: 14px;
        }
        .btn-icon.btn-xs {
            width: 16px;
            height: 16px;
            font-size: inherit;
            line-height: 16px;
        }

        .panel-loading .main-body {
            position: relative;
            z-index: 0;
        }
        .panel-loading.panel-expand .main-body {
            position: absolute;
        }
        .panel-loading .main-body .panel-loader {
            position: absolute;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            background: #fff;
            opacity: 0.3;
            filter: alpha(opacity=30);
            animation: fadeIn .2s;
            -webkit-animation: fadeIn .2s;
            z-index: 1020;
            -webkit-border-radius: 0 0 4px 4px;
            -moz-border-radius: 0 0 4px 4px;
            border-radius: 0 0 4px 4px;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @-webkit-keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .panel-loader > .loading-circular-x2:before {
            background: none !important;
            width: 64px !important;
            height: 64px !important;
            border-left-color: red !important;
            border-right-color: black !important;
        }

        .panel-loader + section {
            pointer-events: none;
            cursor: text;
        }

        #ajax-swallow {
            display: none !important;
            height: 0;
            max-height: 0;
        }

        #calendar {
            padding:15px;
            background-color: inherit;
        }

        #todo-main-container .slimScrollBar {
            background: rgba(255, 250, 250, 0.8) !important;
            border-radius: 2px;
        }

        #calendar {
            font-family: inherit;
        }

        #calendar .fc-button {
            box-shadow: none;
            -webkit-border-radius: 0;
            -moz-border-radius: 0;
            border-radius: 0;
        }

        .fc-state-default, .fc-state-default .fc-button-inner {
            background: #F3F3F3 !important;
            border-color: #DDDDDD;
            border-style: none solid;
            color: #646464;
            text-shadow: none;
        }

        .fc-state-disabled {
            background: #32323A !important;
            color: #fff !important;
            text-shadow: none;
            opacity: 1;
        }

        .fc-state-active, .fc-state-active .fc-button-inner, .fc-state-active, .fc-button-today .fc-button-inner, .fc-state-hover, .fc-state-hover .fc-button-inner {
            background: #32323A !important;
            color: #fff !important;
        }

        .fc-view th {
            height: 50px;
            line-height: 50px;
            text-align: center;
            background: #e4e4e4 !important;
        }

        .fc-event {
            border-radius: 4px;
            padding: 4px 6px;
            text-decoration: none !important;
            outline: none !important;
        }

        .fc-event:active, .fc-event:hover, .fc-event:visited {
            text-decoration: none;
        }

        .fc-day-grid-event .fc-content {
            white-space: normal;
        }

        .chat {
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .chat li {
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 1px dotted #999;
        }

    </style>
    <script src="{{URL::to('/')}}/js/todoList.js"></script>
    <script>

        var handlePanelAction = function() {
            "use strict";

            $('[data-click=panel-remove]').click(function(e) {
                e.preventDefault();
                $(this).closest('.panel').remove();
            });

            $('[data-click=panel-collapse]').click(function(e) {
                e.preventDefault();
                $(this).closest('main').find('.main-body').slideToggle();
                $(this).closest('main').find('.default-body').slideToggle();
            });

            // reload
            $('[data-click=panel-reload]').hover(function() {

            });
            $('[data-click=panel-reload]').click(function(e) {
                e.preventDefault();
                var target = $(this).closest('main');
                var hasIcAttribs = $(this).attr('ic-target') || $(this).attr('ic-get-from') || $(this).attr('ic-post-to');

                if (!$(target).hasClass('panel-loading')) {
                    var targetBody = $(target).find('.main-body');
                    var spinnerHtml = '<div class="panel-loader"  data-original-title="Please wait, ..."><span class="loading-circular-x2"></span></div>';
                    $(target).addClass('panel-loading');
                    $(targetBody).prepend(spinnerHtml);
                    if (!hasIcAttribs) {
                        setTimeout(function() {
                            $(target).removeClass('panel-loading');
                            $(target).find('.panel-loader').remove();
                        }, 8000);
                    } else {
                        $(this).on('success.ic', function(evt, elt, data, textStatus, xhr, requestId){
                            evt.preventDefault();
                            evt.stopImmediatePropagation();
                            $(data).find("ul[ic-select-from-response]").each(function (i, val) {
                                $('#' + $(val).attr("id")).html($(val).html());
                            });
                            return false;
                        });
                    }
                }

            });

            $('[data-click=panel-expand]').click(function(e) {
                e.preventDefault();
                var target = $(this).closest('.panel');
                var targetBody = $(target).find('.panel-body');
                var targetTop = 40;
                if ($(targetBody).length !== 0) {
                    var targetOffsetTop = $(target).offset().top;
                    var targetBodyOffsetTop = $(targetBody).offset().top;
                    targetTop = targetBodyOffsetTop - targetOffsetTop;
                }

                if ($('body').hasClass('panel-expand') && $(target).hasClass('panel-expand')) {
                    $('body, .panel').removeClass('panel-expand');
                    $('.panel').removeAttr('style');
                    $(targetBody).removeAttr('style');
                } else {
                    $('body').addClass('panel-expand');
                    $(this).closest('.panel').addClass('panel-expand');

                    if ($(targetBody).length !== 0 && targetTop != 40) {
                        var finalHeight = 40;
                        $(target).find(' > *').each(function() {
                            var targetClass = $(this).attr('class');

                            if (targetClass != 'panel-heading' && targetClass != 'panel-body') {
                                finalHeight += $(this).height() + 30;
                            }
                        });
                        if (finalHeight != 40) {
                            $(targetBody).css('top', finalHeight + 'px');
                        }
                    }
                }
                $(window).trigger('resize');
            });
        };

        $(document).on('click', '.panel-heading span.clickable', function (e) {
            var $this = $(this);
            if (!$this.hasClass('panel-collapsed')) {
                $this.parents('.panel').find('.panel-body').slideUp();
                $this.addClass('panel-collapsed');
                $this.find('i').removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
            } else {
                $this.parents('.panel').find('.panel-body').slideDown();
                $this.removeClass('panel-collapsed');
                $this.find('i').removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
            }
        });

        $(document).ready(function () {
            handlePanelAction();

            //***Start working hours getting current day****

            let d = new Date();
            let weekday = new Array(7);
            weekday[0] = "Monday";
            weekday[1] = "Tuesday";
            weekday[2] = "Wednesday";
            weekday[3] = "Thursday";
            weekday[4] = "Friday";
            weekday[5] = "Saturday";
            weekday[6] =  "Sunday";

            let now = weekday[d.getDay()-1];

            $('.current-working-hours').children('li').filter(function(val){

                let text = $(this).text().trim();

                if (text.indexOf(now) === 0 ) {
                    $('.current-working-hours > li').eq(val).addClass('today');
                }

            });
        });

        //show/hide list in working hours
        let group = $('#accordion');
        group.on('show.bs.collapse','.collapse', function() {
            group.find('.collapse.in').collapse('hide');
        });

        //group.collapse({"toggle": true, 'parent': '#accordion'});

        //***End working hours getting current day****
    </script>
@endsection

@section('title', trans('home.SelfServicePortal.label'))
@section('subtitle',trans('home.SelfServicePortal.desc'))

@section('right-title')
<div id="icons-container" class="pull-right" style="position: relative;top:-10px;width:100%;text-align:right;vertical-align:text-top;">
    <a class="btn" data-container="svg" data-wenk-pos="bottom" data-wenk="My Profile" href="{{URL::to('/')}}/my-details">
        <svg class="icon" width="48" height="48" >
            <use xlink:href="#medical-3" />

        </svg>
        <span class="indicator-dot" id="myDetails"></span>
    </a>

    <a class="btn" data-container="svg" data-wenk-pos="bottom" data-wenk="My E-learning" href="{{URL::to('/')}}/my-courses">
        <svg class="icon" width="48" height="48">
            <use xlink:href="#mortarboard" />
        </svg>
    </a>

    <a class="btn" data-container="svg" data-wenk-pos="bottom" data-wenk="My Surveys" href="{{URL::to('/')}}/my-surveys">
        <svg class="icon" width="47" height="40">
            <use xlink:href="#interface-4" />
        </svg>
    </a>

    <a class="btn" data-container="svg" data-wenk-pos="bottom" data-wenk="My absences and leaves" href="{{URL::to('/')}}/my-leaves">
        <svg class="icon" width="47" height="40">
            <use xlink:href="#time-5" />
        </svg>
    </a>

    <a class="btn" data-container="svg" data-wenk-pos="bottom" data-wenk="My Team" href="{{URL::to('/')}}/my-team">
        <svg class="icon" width="47" height="40">
            <use xlink:href="#communication" />
        </svg>
    </a>
</div>
@endsection

@section('content')
@if (!empty($warnings))
<div class="col-xs-12 alert alert-danger">
    <i class="glyphicon glyphicon-exclamation-sign"></i>
    @foreach($warnings as $index => $warning)
    <div>{{$warning}}</div>
    @if($index<count($warnings)-1))<br>@endif
    @endforeach
</div>
@endif


<div hidden=""> <!-- svg menu item definitions -->
    @include('partials.menu-svg')
</div> <!-- end of svg menu item definitions -->

<div class="col-xs-12">
    <div id="message"></div>
</div>

<div id="ajax-swallow"></div>

<section id="employeedir">
    <br>
    <div class='row'>
        @if ($allowedActionsAssets->contains('List'))
        <!-- assets -->
        <div class="col1 col-lg-8">
            <main class="main-container">
                <header class="portal-help-header">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    </div>
                    <h3>My Assets</h3>
                </header>
                <div class="default-body">
                    <section>
                        <div class="row">
                            <div class="col-lg-12">
                                @if(count($assets)>0)
                                    @foreach($assets as $asset)
                                        <div class="sham-rounded-border assetItem">
                                            <span class="title">{{$asset['Name']}}</span><br>
                                            <span>
                                                    <span class="label-group"><span class="label label-default">Date allocated</span><span class="label label-default">{{ \Carbon\Carbon::parse($asset['DateOut'])->toDateString() }}</span></span>
                                                    <span class="label-group"><span class="label label-default">Price</span><span class="label label-default">{{$asset['PurchasePrice']}}</span></span>
                                                    <span class="label-group"><span class="label label-default">Warranty expiry</span><span class="label label-default">{{\Carbon\Carbon::parse($asset['WarrantyExpiryDate'])->toDateString()}}</span></span>
                                                {{--
                                                @if(!empty($asset->DateIn))
                                                    <span class="label-group"><span class="label label-default">Date to return</span><span class="label label-default">{{\Carbon\Carbon::parse($asset->DateIn)->toDateString()}}</span></span>
                                                @else
                                                    <br><br>
                                                @endif
                                                --}}
                                                </span>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="text-success">Currently, there are no assets allocated to you</div>
                                @endif
                            </div>
                        </div>
                    </section>
                </div>
            </main>
        </div>
        @endif
        <!-- end of assets -->


        <!-- working hours -->
        <div class="col2 col-lg-4 col-md-4">
            <main class="main-container" id="timesheet-main-container">
                <header class="working-hours-header">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-warning" data-wenk="Expand / Compress" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    </div>
                    <h3>My Working Hours</h3>
                </header>
                <div class="main-body">
                    <section>
                        <div class="row">
                            <div class="timesheet">
                                <div class="working-hours">
                                    @if(isset($workingHours['team']) && sizeof($workingHours['team']) > 0
                                             && isset($workingHours['timegroup']) && sizeof($workingHours['timegroup']) > 0
                                    )
                                        @if(!empty($workingHours['team']))
                                            <h2 class="list title">{{ $workingHours['team'] }}</h2>
                                        @endif

                                        @if(!empty($workingHours['timegroup']))

                                            @if(!empty($workingHours['timegroup']['description']))
                                                <h3 class="list sub-title">{{ $workingHours['timegroup']['description'] }}</h3>
                                            @endif

                                            <ul class="list-unstyled current-working-hours" id="accordion">
                                                @if(!empty($workingHours['timegroup']['time_period']))
                                                    @foreach($workingHours['timegroup']['time_period'] as $workingDesc => $workingHour)
                                                        <li data-toggle="collapse"
                                                            href="#break_{{$workingHour['day_count']}}"
                                                            aria-expanded="false"
                                                            aria-controls="break_{{$workingHour['day_count']}}"
                                                            data-parent="#accordion"
                                                        >
                                                            @if($workingDesc != '' && !is_null($workingDesc)){{ $workingDesc }}@else No description @endif
                                                            <span class="pull-right">
                                                        {{ $workingHour['start_time'] }} - {{ $workingHour['end_time'] }}
                                                </span>
                                                            @if(!empty($workingHour['breaks']))
                                                                <span>
                                                    <i class="fa fa-question-circle" aria-hidden="true"  data-wenk="Click to view break details"></i>
                                                </span>
                                                            @endif
                                                        </li>
                                                        @if(!empty($workingHour['breaks']))
                                                            <ul id="break_{{$workingHour['day_count']}}" class="collapse">
                                                                @foreach($workingHour['breaks'] as $periodDesc => $break)
                                                                    <li>
                                                                        @if($periodDesc != '' && !is_null($periodDesc)){{ $periodDesc }}@else No description @endif
                                                                        <span class="pull-right">
                                                       {{ $break['start_time'] }} - {{ $break['end_time'] }}
                                                    </span>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </ul>
                                        @endif
                                    @elseif(isset($workingHours['timegroup']) && sizeof($workingHours['timegroup']) == 0)
                                        <p style="color: #ffffee ">Your team has not been allocated to a time group yet</p>
                                    @elseif(isset($workingHours['team']) && sizeof($workingHours['team']) == 0)
                                        <p style="color: #ffffee ">You have not been assigned to a team.</p>
                                    @else
                                        <p style="color: #ffffee ">An error occured</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </main>
        </div>
        <!-- end of working hours -->

        <!-- announcements -->
        @if(count($announcements)>0 &&  $allowedActionsAnnouncements->contains('List'))
            <div class="col1 col-lg-8 col-md-8">
                <main class="main-container">
                    <header class="portal-help-header">
                        <div class="panel-heading-btn">
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                        </div>
                        <h3><i class="fa fa-bullhorn"></i> Announcements</h3>
                    </header>
                    <div class="default-body">
                        <section>
                            <div class="row">
                                <div class="col-lg-12">
                                    <ul class="chat">
                                        @foreach($announcements as $announcement)
                                            <li class="right clearfix">
                                                <span class="chat-img pull-right"></span>
                                                <div class="chat-body">
                                                    <div class="header">
                                                        <a onclick="contentToModalDialogLoader('{{URL::to('/')}}/announcements/{{$announcement['Id']}}')" href="#">
                                                            <strong class="primary-font">{{$announcement['Title']}}</strong>
                                                        </a>
                                                    </div>
                                                    <p>{{$announcement['Description']}}</p>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </section>
                    </div>
                </main>
            </div>
        @endif
        <!-- end of announcements -->
    </div>
</section>
@stop